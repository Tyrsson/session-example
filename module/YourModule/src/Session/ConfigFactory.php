<?php

declare(strict_types=1);

namespace YourModule\Session;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\Config\SessionConfig;
use Psr\Container\ContainerInterface;

class ConfigFactory implements FactoryInterface
{
    /** @param string $requestedName */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): SessionConfig | StandardConfig
    {
        $config   = $container->get('config')['session_config'] ?? [];
        $instance = new $requestedName();
        $instance->setOptions($config);
        return $instance;
    }
}
