<?php

namespace FondOfSpryker\Zed\Sales;

use FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToStoreFacadeBridge;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Sales\SalesDependencyProvider as SprykerSalesDependencyProvider;

class SalesDependencyProvider extends SprykerSalesDependencyProvider
{
    public const PLUGINS_SALES_ORDER_ADDRESS_HYDRATION = 'PLUGINS_SALES_ORDER_ADDRESS_HYDRATION';
    public const FACADE_STORE = 'FACADE_STORE';

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
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addStoreFacade($container);

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

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = static function () use ($container) {
            return new SalesToStoreFacadeBridge($container->getLocator()->store()->facade());
        };

        return $container;
    }
}
