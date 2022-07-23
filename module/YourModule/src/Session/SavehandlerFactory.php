<?php

declare(strict_types=1);

namespace YourModule\Session;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\SaveHandler\DbTableGateway;
use Laminas\Session\SaveHandler\DbTableGatewayOptions;
use Psr\Container\ContainerExceptionInterface;

final class SaveHandlerFactory implements FactoryInterface
{
    /**
     * Fires 6th
     * @inheritdoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): DbTableGateway
    {
        // db options
        $dbOptions = [
            'idColumn'       => 'id',
            'nameColumn'     => 'name',
            'modifiedColumn' => 'modified',
            'lifetimeColumn' => 'lifetime',
            'dataColumn'     => 'data',
        ];
        return new DbTableGateway(
            new TableGateway('table_name', $container->get(AdapterInterface::class)),
            new DbTableGatewayOptions($dbOptions)
        );
    }
}
