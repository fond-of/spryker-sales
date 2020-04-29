<?php

namespace FondOfSpryker\Zed\Sales\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Sales\Business\Model\Order\SalesOrderSaver;
use FondOfSpryker\Zed\Sales\SalesConfig;
use FondOfSpryker\Zed\Sales\SalesDependencyProvider;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToSequenceNumberInterface;

class SalesBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Business\SalesBusinessFactory
     */
    protected $salesBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\SalesConfig
     */
    protected $salesConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface
     */
    protected $omsFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface
     */
    protected $countryFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Dependency\Facade\SalesToSequenceNumberInterface
     */
    protected $sequenceNumberFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface
     */
    protected $localeQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Store
     */
    protected $storeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject[]|\Spryker\Zed\Sales\Dependency\Plugin\OrderExpanderPreSavePluginInterface[]
     */
    protected $orderExpanderPreSavePlugins;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject[]|\Spryker\Zed\SalesExtension\Dependency\Plugin\OrderPostSavePluginInterface[]
     */
    protected $orderPostSavePlugins;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject[]|\Spryker\Zed\SalesExtension\Dependency\Plugin\OrderItemExpanderPreSavePluginInterface[]
     */
    protected $orderItemExpanderPreSavePlugins;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject[]|\FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\SalesOrderAddressHydrationPluginInterface[]
     */
    protected $salesOrderAddressHydrationPlugins;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesConfigMock = $this->getMockBuilder(SalesConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->omsFacadeMock = $this->getMockBuilder(SalesToOmsInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->countryFacadeMock = $this->getMockBuilder(SalesToCountryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sequenceNumberFacadeMock = $this->getMockBuilder(SalesToSequenceNumberInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeQueryContainerMock = $this->getMockBuilder(LocaleQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeMock = $this->getMockBuilder(Store::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderExpanderPreSavePlugins = [];
        $this->orderItemExpanderPreSavePlugins = [];
        $this->orderPostSavePlugins = [];
        $this->salesOrderAddressHydrationPlugins = [];

        $this->salesBusinessFactory = new SalesBusinessFactory();
        $this->salesBusinessFactory->setConfig($this->salesConfigMock);
        $this->salesBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateSalesOrderSaver(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturnOnConsecutiveCalls(
                true,
                true,
                true,
                true,
                true,
                true,
                true,
                true,
                true,
                true
            );

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [SalesDependencyProvider::FACADE_COUNTRY],
                [SalesDependencyProvider::FACADE_OMS],
                [SalesDependencyProvider::FACADE_SEQUENCE_NUMBER],
                [SalesDependencyProvider::STORE],
                [SalesDependencyProvider::QUERY_CONTAINER_LOCALE],
                [SalesDependencyProvider::STORE],
                [SalesDependencyProvider::ORDER_EXPANDER_PRE_SAVE_PLUGINS],
                [SalesDependencyProvider::ORDER_ITEM_EXPANDER_PRE_SAVE_PLUGINS],
                [SalesDependencyProvider::PLUGINS_ORDER_POST_SAVE],
                [SalesDependencyProvider::PLUGINS_SALES_ORDER_ADDRESS_HYDRATION]
            )
            ->willReturnOnConsecutiveCalls(
                $this->countryFacadeMock,
                $this->omsFacadeMock,
                $this->sequenceNumberFacadeMock,
                $this->storeMock,
                $this->localeQueryContainerMock,
                $this->storeMock,
                $this->orderExpanderPreSavePlugins,
                $this->orderItemExpanderPreSavePlugins,
                $this->orderPostSavePlugins,
                $this->salesOrderAddressHydrationPlugins
            );

        $this->assertInstanceOf(SalesOrderSaver::class, $this->salesBusinessFactory->createSalesOrderSaver());
    }
}
