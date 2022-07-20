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
 * file.
 */

declare(strict_types=1);

use Laminas\Session\Container;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Validator\HttpUserAgent;
use Laminas\Session\Validator\RemoteAddr;

// adjiust your settings here or you can pass a custom config class that extends the SessionConfig class
return [
    'session_manager'    => [
        'enable_default_container_manager' => true,
    ],
    'session_config'     => [
        'use_cookies'         => true,
        'gc_maxlifetime'      => 86400 * 14,
        'remember_me_seconds' => 86400 * 14,
        'cookie_httponly'     => true,
        'cookie_samesite'     => 'Strict',
        'cookie_secure'       => false,
    ],
    'session_containers' => [
        Container::class,
    ],
    'session_storage'    => [
        'type' => SessionArrayStorage::class,
    ],
    'session_validators' => [
        RemoteAddr::class,
        HttpUserAgent::class,
    ],
];
