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
     * This is an example of how we can manipulate the application configuration
     * just after its merged from all modules and just prior to it being
     * passed to the service manager. Its important to note that the order in which
     * the listeners will have access is determined by the priority that its assigned.
     * The default priority is 1. please see the following doc for more infromation:
     * https://docs.laminas.dev/tutorials/advanced-config/#manipulating-merged-configuration
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
        /**
         * This initializes the session manager and the saveHandler, which basically is what
         * executes your SaveHandlerFactory class.
         * Without this call the saveHandler will not be initialized and passed to the
         * session manager. Its backed by the DI container so it can be configured by the
         * ConfigProvider.
         * It also occurs to me this should really not be needed, but it appears that it is.
         * I will do some research on this and update the example if needed.
         */
        $session = $serviceManager->get(SessionManager::class);
        // not to be confused with the Psr | serviceManager container
        $container          = $serviceManager->get(Container::class);
        $container->someVar = 'someValue'; // this is how you can set a value in the session container
    }
}
