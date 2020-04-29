<?php

namespace FondOfSpryker\Zed\Sales\Business;

use FondOfSpryker\Zed\Sales\Business\Model\Order\OrderReferenceGenerator;
use FondOfSpryker\Zed\Sales\Business\Model\Order\SalesOrderSaver;
use FondOfSpryker\Zed\Sales\SalesDependencyProvider;
use Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface;
use Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaverInterface;
use Spryker\Zed\Sales\Business\SalesBusinessFactory as SprykerSalesBusinessFactory;

/**
 * @method \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface getQueryContainer()
 * @method \FondOfSpryker\Zed\Sales\SalesConfig getConfig()
 */
class SalesBusinessFactory extends SprykerSalesBusinessFactory
{
    /**
     * @return \Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaverInterface
     */
    public function createSalesOrderSaver(): SalesOrderSaverInterface
    {
        return new SalesOrderSaver(
            $this->getCountryFacade(),
            $this->getOmsFacade(),
            $this->createReferenceGenerator(),
            $this->getConfig(),
            $this->getLocaleQueryContainer(),
            $this->getStore(),
            $this->getOrderExpanderPreSavePlugins(),
            $this->createSalesOrderSaverPluginExecutor(),
            $this->createSalesOrderItemMapper(),
            $this->getOrderPostSavePlugins(),
            $this->getSalesOrderAddressHydrationPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\SalesOrderAddressHydrationPluginInterface[]
     */
    protected function getSalesOrderAddressHydrationPlugins(): array
    {
        return $this->getProvidedDependency(SalesDependencyProvider::PLUGINS_SALES_ORDER_ADDRESS_HYDRATION);
    }

    /**
     * @return \Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface
     */
    public function createReferenceGenerator(): OrderReferenceGeneratorInterface
    {
        return new OrderReferenceGenerator(
            $this->getSequenceNumberFacade(),
            $this->getStore(),
            $this->getConfig()
        );
    }
}
