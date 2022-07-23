<?php

declare(strict_types=1);

namespace YourModule;

use Laminas\ModuleManager\ModuleEvent;
use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\Container;

final class Module
{
    /**
     * Fires 1st
     * This is an example of how we can manipulate the application configuration
     * just after its merged from all modules and just prior to it being
     * passed to the service manager.
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
        // This will allow the session manager to use the saveHandler
        $e->getApplication()->getServiceManager()->get(Container::class);
    }
}
