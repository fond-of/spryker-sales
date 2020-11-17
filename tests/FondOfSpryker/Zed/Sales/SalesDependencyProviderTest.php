<?php

namespace FondOfSpryker\Zed\Sales;

use Codeception\Test\Unit;
use ReflectionMethod;
use Spryker\Zed\Kernel\Container;

class SalesDependencyProviderTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \FondOfSpryker\Zed\Sales\SalesDependencyProvider
     */
    protected $salesDependencyProvider;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethodsExcept(['factory', 'set', 'offsetSet', 'get', 'offsetGet'])
            ->getMock();

        $this->salesDependencyProvider = new SalesDependencyProvider();
    }

    /**
     * @return void
     */
    public function testAddSalesOrderAddressHydrationPlugins(): void
    {
        $method = new ReflectionMethod(
            get_class($this->salesDependencyProvider),
            'addSalesOrderAddressHydrationPlugins'
        );

        $method->setAccessible(true);

        $container = $method->invokeArgs($this->salesDependencyProvider, [$this->containerMock]);

        $this->assertEquals($this->containerMock, $container);
        $this->assertIsArray($container[SalesDependencyProvider::PLUGINS_SALES_ORDER_ADDRESS_HYDRATION]);
        $this->assertCount(0, $container[SalesDependencyProvider::PLUGINS_SALES_ORDER_ADDRESS_HYDRATION]);
    }
}
