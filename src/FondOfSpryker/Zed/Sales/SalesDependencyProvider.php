<?php

namespace FondOfSpryker\Zed\Sales;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Sales\SalesDependencyProvider as SprykerSalesDependencyProvider;

/**
 * @codeCoverageIgnore
 */
class SalesDependencyProvider extends SprykerSalesDependencyProvider
{
    /**
     * @var string
     */
    public const PLUGINS_ORDER_ADDRESS_EXPANDER = 'PLUGINS_ORDER_ADDRESS_EXPANDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        return $this->addOrderAddressExpanderPlugins($container);
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
            return $self->getOrderAddressExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return array<\FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\OrderAddressExpanderPluginInterface>
     */
    protected function getOrderAddressExpanderPlugins(): array
    {
        return [];
    }
}
