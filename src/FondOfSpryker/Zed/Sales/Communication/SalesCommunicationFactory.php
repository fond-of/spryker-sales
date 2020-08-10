<?php

namespace FondOfSpryker\Zed\Sales\Communication;

use FondOfSpryker\Zed\Sales\Communication\Table\OrdersTable;
use FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToStoreFacadeInterface;
use FondOfSpryker\Zed\Sales\SalesDependencyProvider;
use Spryker\Zed\Sales\Communication\SalesCommunicationFactory as SprykerSalesCommunicationFactory;

/**
 * @method \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Sales\SalesConfig getConfig()
 * @method \Spryker\Zed\Sales\Persistence\SalesEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\Sales\Persistence\SalesRepositoryInterface getRepository()
 * @method \Spryker\Zed\Sales\Business\SalesFacadeInterface getFacade()
 */
class SalesCommunicationFactory extends SprykerSalesCommunicationFactory
{
    /**
     * @return \Spryker\Zed\Sales\Communication\Table\OrdersTable
     */
    public function createOrdersTable()
    {
        return new OrdersTable(
            $this->createOrdersTableQueryBuilder(),
            $this->getProvidedDependency(SalesDependencyProvider::FACADE_MONEY),
            $this->getProvidedDependency(SalesDependencyProvider::SERVICE_UTIL_SANITIZE),
            $this->getProvidedDependency(SalesDependencyProvider::SERVICE_DATE_FORMATTER),
            $this->getProvidedDependency(SalesDependencyProvider::FACADE_CUSTOMER),
            $this->getSalesTablePlugins(),
            $this->getStoreFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToStoreFacadeInterface
     */
    protected function getStoreFacade(): SalesToStoreFacadeInterface
    {
        return $this->getProvidedDependency(SalesDependencyProvider::FACADE_STORE);
    }
}
