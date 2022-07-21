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
     *
     * The important parts here is that we are returning the SaveHandler instance
     * to retrieve the instance we would call $container->get(SaveHandlerInterface::class) which
     * would return an instance of the save handler.
     * Also notice that we are passing the $dbOptions to the DbTableGatewayOptions instance. and
     * not to the saveHandler constructor. Also note that we are using Psr\Container\ContainerInterface
     * not the old Interop\Container\ContainerInterface.
     * - the first argument to the TableGateway constructor is the table name. The second is the adapter.
     *
     * - Its important to note here that the AdapterInterface relies on a top level config key of 'db'
     * which should be in the $root/config/autoload/local.php file. I assume that anyone reading this
     * has already setup an adapter, if not please just open an issue.
     *
     * {@inheritdoc}
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
