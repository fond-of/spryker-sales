<?php

namespace FondOfSpryker\Zed\Sales;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Sales\SalesDependencyProvider as SprykerSalesDependencyProvider;

class SalesDependencyProvider extends SprykerSalesDependencyProvider
{
    public const PLUGINS_SALES_ORDER_ADDRESS_HYDRATION = 'PLUGINS_SALES_ORDER_ADDRESS_HYDRATION';
    public const PLUGINS_ORDER_ADDRESS_EXPANDER = 'PLUGINS_ORDER_ADDRESS_EXPANDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addSalesOrderAddressHydrationPlugins($container);
        $container = $this->addOrderAddressExpanderPlugins($container);

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
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addOrderAddressExpanderPlugins(Container $container): Container
    {
        $self = $this;

        $container[static::PLUGINS_ORDER_ADDRESS_EXPANDER] = static function () use ($self) {
            return $self->getOrderAddressExpanderPlguins();
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

    /**
     * @return \FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\OrderAddressExpanderPluginInterface[]
     */
    protected function getOrderAddressExpanderPlguins(): array
    {
        return [];
    }
}
