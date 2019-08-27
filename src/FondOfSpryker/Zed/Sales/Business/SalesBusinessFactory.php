<?php

namespace FondOfSpryker\Zed\Sales\Business;

use FondOfSpryker\Zed\Sales\Business\Model\Order\OrderHydrator;
use FondOfSpryker\Zed\Sales\Business\Model\Order\OrderReader;
use FondOfSpryker\Zed\Sales\Business\Model\Order\SalesOrderSaver;
use FondOfSpryker\Zed\Sales\SalesDependencyProvider;
use Spryker\Zed\Sales\Business\Model\Order\OrderHydratorInterface;
use Spryker\Zed\Sales\Business\Model\Order\OrderReaderInterface;
use Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaverInterface;
use Spryker\Zed\Sales\Business\SalesBusinessFactory as SprykerSalesBusinessFactory;
use Spryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface;

/**
 * @method \FondOfSpryker\Zed\Sales\Persistence\SalesQueryContainerInterface getQueryContainer()
 * @method \FondOfSpryker\Zed\Sales\SalesConfig getConfig()
 */
class SalesBusinessFactory extends SprykerSalesBusinessFactory
{
    /**
     * @return \Spryker\Zed\Sales\Business\Model\Order\OrderHydratorInterface
     */
    public function createOrderHydrator(): OrderHydratorInterface
    {
        return new OrderHydrator(
            $this->getQueryContainer(),
            $this->getOmsFacade(),
            $this->getHydrateOrderPlugins(),
            $this->getMoneyFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\Sales\Business\Model\Order\OrderReaderInterface
     */
    public function createOrderReader(): OrderReaderInterface
    {
        return new OrderReader(
            $this->getQueryContainer(),
            $this->createOrderHydrator()
        );
    }

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
            $this->createOrderItemMapper(),
            $this->getOrderPostSavePlugins()
        );
    }

    /**
     * @throws
     *
     * @return \Spryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface
     */
    protected function getMoneyFacade(): SalesToMoneyInterface
    {
        return $this->getProvidedDependency(SalesDependencyProvider::FACADE_MONEY);
    }
}
