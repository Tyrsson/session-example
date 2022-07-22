<?php

declare(strict_types=1);

namespace YourModule;

use Laminas\ModuleManager\ModuleEvent;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;

final class Module
{
    /**
     * Fires 1st
     */
    public function init(ModuleManager $modulemanager): void
    {
        $events = $modulemanager->getEventManager();
        $events->attach(ModuleEvent::EVENT_MERGE_CONFIG, [$this, 'onMergeConfig']);
    }

    /**
     * Fires 2nd
     *
     * @return array<string, mixed>
     * */
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Fires 3rd
     * Please note that this is the ModuleEvent and not the MvcEvent
     * */
    public function onMergeConfig(ModuleEvent $event): void
    {
        $configListener = $event->getConfigListener();
        $config         = $configListener->getMergedConfig(false);
        if (
            isset($config['session_config']['cookie_secure']) &&
            isset($GLOBALS['_SERVER']['REQUEST_SCHEME']) &&
            ! $config['session_config']['cookie_secure'] &&
            $GLOBALS['_SERVER']['REQUEST_SCHEME'] === 'https'
        ) {
            $config['session_config']['cookie_secure']   = true;
            $config['session_config']['cookie_samesite'] = 'None';
        }
    }

    /** Fires 4th */
    public function onBootstrap(MvcEvent $e): void
    {
        $this->bootstrapSession($e);
    }

    /** Fires 5th */
    public function bootstrapSession(MvcEvent $e): void
    {
        // get an instance of the service manager
        $serviceManager = $e->getApplication()->getServiceManager();
        // If this call is not made then the saveHandler is not picked up
        $session = $serviceManager->get(SessionManager::class);
        // not to be confused with the Psr | serviceManager container
        $container          = $serviceManager->get(Container::class);
        $container->someVar = 'someValue'; // this is how you can set a value in the session container
    }
}
