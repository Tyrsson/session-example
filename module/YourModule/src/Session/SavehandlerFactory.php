<?php

declare(strict_types=1);

namespace YourModule\Session;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SaveHandler\DbTableGateway;
use Laminas\Session\SaveHandler\DbTableGatewayOptions;
use Psr\Container\ContainerInterface;

final class SaveHandlerFactory implements FactoryInterface
{
    /** @inheritdoc */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): DbTableGateway
    {
        // db options
        $config = $container->get('config');
        return new $requestedName(
            new TableGateway($config['session_table_name'], $container->get(AdapterInterface::class)),
            new DbTableGatewayOptions($config['session_save_handler_options'])
        );
    }
}
