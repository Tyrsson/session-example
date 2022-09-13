<?php

declare(strict_types=1);

use Laminas\Session\Config\ConfigInterface;
use Laminas\Session\Container as DefaultContainer;
use Laminas\Session\SaveHandler\SaveHandlerInterface; // this is what the autowiring is looking for as a service name or alias
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Validator\HttpUserAgent;
use Laminas\Session\Validator\RemoteAddr;
use YourModule\Session\Container;
use YourModule\Session\SavehandlerFactory;

return [
    'session_config'     => [
        'use_cookies'         => true, // I mean who doesn't like cookies?
        'gc_maxlifetime'      => 86400,
        'remember_me_seconds' => 86400, // Can be safely set or changed after the session has been started
        'cookie_httponly'     => true,  // Example only
        'cookie_secure'       => false, // Example only
    ],
    'session_containers' => [
        /**
         * default container $sessionContainer = $container->get(DefaultContainer::class); Laminas\Session\Container
         * Namespace Default
         */
        DefaultContainer::class,
        /**
         * This will setup a custom container that can be called from the service manager
         * $sessionContainer = $container->get(Container::class) service name will be YourModule\Session\Container
         */
        Container::class,
        /**
         * You can also pass a string name and the AbstractContainerFactory will create a container with
         * that name passed and it can be retrieved from the service manager by the string name
         * like calling an alias
         * $sessionContainer = $container->get('YourModule_Container');
         */
        'YourModule_Container',
    ],
    'session_storage'    => [
        'type' => SessionArrayStorage::class, // if youre Unit, Integration testing you may want to set this to ArrayStorage
    ],
    'session_validators' => [ // validation is great :)
        RemoteAddr::class,
        HttpUserAgent::class,
    ],
    'service_manager' => [
        'factories' => [
            ConfigInterface::class      => Session\ConfigFactory::class,
            Session\Container::class    => Session\ContainerFactory::class,
            //SaveHandlerInterface::class => SaveHandlerFactory::class, // <- uncomment this if you want to use db driven sessions
        ],
    ],
    'session_save_handler_options' => [ // option to db table column map
        'idColumn'       => 'id',
        'nameColumn'     => 'name',
        'modifiedColumn' => 'modified',
        'lifetimeColumn' => 'lifetime',
        'dataColumn'     => 'data',
    ],
    'session_table_name' => 'sessions', // db table name for the save handler to write too
];
