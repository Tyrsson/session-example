<?php

    /**
     * This MUST be setup this way for the session manager to use it from the configuration...
     * Well you could set it up a different way but this is the simplest way to set it up since
     * it doesnt require an 'aliases' entry in with the service manager
     * */

declare(strict_types=1);

use Laminas\Session\SaveHandler\SaveHandlerInterface;
use YourModule\Session\SavehandlerFactory;

return [
    'service_manager' => [
        'factories' => [
            SaveHandlerInterface::class => SaveHandlerFactory::class,
        ],
    ],
];
