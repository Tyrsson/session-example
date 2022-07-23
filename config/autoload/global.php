<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file. ** They should be in the /config/autoload/local.php file, which will not be **
 */

declare(strict_types=1);

use Laminas\Session\Container;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Validator\HttpUserAgent;
use Laminas\Session\Validator\RemoteAddr;

// adjust your settings here or you can pass a custom config class that extends the SessionConfig / StandardConfig class
return [
    'session_config'     => [
        'use_cookies'         => true, // I mean who doesn't like cookies?
        'gc_maxlifetime'      => 86400,
        'remember_me_seconds' => 86400, // Can be safely set or changed after the session has been started
        'cookie_httponly'     => true,
        'cookie_secure'       => false, // Since I use a localhost that is not localhost, I set this to false
    ],
    'session_containers' => [
        Container::class,
    ],
    'session_storage'    => [
        'type' => SessionArrayStorage::class,
    ],
    'session_validators' => [ // validation is great :)
        RemoteAddr::class,
        HttpUserAgent::class,
    ],
];
