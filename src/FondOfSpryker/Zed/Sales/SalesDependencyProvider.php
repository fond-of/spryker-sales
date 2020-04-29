<?php

namespace FondOfSpryker\Zed\Sales;

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

        $container = $this->addSalesOrderAddressHydrationPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSalesOrderAddressHydrationPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_SALES_ORDER_ADDRESS_HYDRATION] = static function () use ($self) {
            return $self->getSalesOrderAddressHydrationPlugins();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\SalesOrderAddressHydrationPluginInterface[]
     */
    protected function getSalesOrderAddressHydrationPlugins(): array
    {
        return [];
    }
}
