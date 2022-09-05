<?php

declare(strict_types=1);

namespace YourModule\Session;

use YourModule\Session\Container;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SessionManager;
use Psr\Container\ContainerInterface;

class ContainerFactory implements FactoryInterface
{
    /** @param string $requestedName*/
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Container
    {
        return new $requestedName('YourModule_Context', $container->get(SessionManager::class));
    }
}
