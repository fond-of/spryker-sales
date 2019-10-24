<?php

namespace FondOfSpryker\Zed\Sales;

use FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryBridge;
use FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToMoneyBridge;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Sales\SalesDependencyProvider as SprykerSalesDependencyProvider;

class SalesDependencyProvider extends SprykerSalesDependencyProvider
{
    public const PLUGINS_SALES_ORDER_ADDRESS_HYDRATION = 'PLUGINS_SALES_ORDER_ADDRESS_HYDRATION';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addMoneyPlugin($container);
        $container = $this->addCountryFacade($container);
        $container = $this->addSalesOrderAddressHydrationPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addMoneyPlugin(Container $container): Container
    {
        $container[static::FACADE_MONEY] = function (Container $container) {
            return new SalesToMoneyBridge($container->getLocator()->money()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCountryFacade(Container $container): Container
    {
        $container[static::FACADE_COUNTRY] = function (Container $container) {
            return new SalesToCountryBridge($container->getLocator()->country()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAddressHydrationPlugins(Container $container): Container
    {
        $container[static::PLUGINS_SALES_ORDER_ADDRESS_HYDRATION] = function () {
            return $this->getSalesOrderAddressHydrationPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\Sales\Dependency\Plugin\SalesOrderAddressHydrationPluginInterface[]
     */
    protected function getSalesOrderAddressHydrationPlugins(): array
    {
        return [];
    }
}
