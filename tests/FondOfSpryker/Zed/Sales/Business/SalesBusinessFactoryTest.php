<?php

namespace FondOfSpryker\Zed\Sales\Business\Model;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Sales\Business\Model\Order\OrderReaderInterface;
use FondOfSpryker\Zed\Sales\Business\Model\Order\SalesOrderSaver;
use FondOfSpryker\Zed\Sales\Business\SalesBusinessFactory;
use FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface;
use FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface;
use FondOfSpryker\Zed\Sales\Persistence\SalesQueryContainer;
use FondOfSpryker\Zed\Sales\SalesConfig;
use FondOfSpryker\Zed\Sales\SalesDependencyProvider as SalesSalesDependencyProvider;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface;
use Spryker\Zed\Sales\Business\Model\Order\OrderHydratorInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToSequenceNumberInterface;
use Spryker\Zed\Sales\Dependency\Plugin\OrderExpanderPreSavePluginInterface;
use Spryker\Zed\Sales\SalesDependencyProvider;
use Spryker\Zed\SalesExtension\Dependency\Plugin\OrderExpanderPluginInterface;
use Spryker\Zed\SalesExtension\Dependency\Plugin\OrderItemExpanderPreSavePluginInterface;
use Spryker\Zed\SalesExtension\Dependency\Plugin\OrderPostSavePluginInterface;

class SalesBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Business\SalesBusinessFactory
     */
    protected $salesBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\Persistence\SalesQueryContainer
     */
    protected $salesQueryContainerInterfaceMock;

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
    protected $salesToOmsInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\SalesExtension\Dependency\Plugin\OrderExpanderPluginInterface
     */
    protected $orderExpanderPluginInterfaceMock;

    /**
     * @var array
     */
    protected $orderExpanderPlugins;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface
     */
    protected $salesToMoneyInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface
     */
    protected $salesToCountryInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    protected $sequenceNumberSettingsTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Dependency\Facade\SalesToSequenceNumberInterface
     */
    protected $salesToSequenceNumberInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface
     */
    protected $localeQueryContainerInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Store
     */
    protected $storeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Dependency\Plugin\OrderExpanderPreSavePluginInterface
     */
    protected $orderExpanderPreSavePluginInterfaceMock;

    /**
     * @var array
     */
    protected $orderExpanderPreSavePlugins;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\SalesExtension\Dependency\Plugin\OrderPostSavePluginInterface
     */
    protected $orderPostSavePluginInterfaceMock;

    /**
     * @var array
     */
    protected $orderPostSavePlugins;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\SalesExtension\Dependency\Plugin\OrderItemExpanderPreSavePluginInterface
     */
    protected $orderItemExpanderPreSavePluginInterfaceMock;

    /**
     * @var array
     */
    protected $orderItemExpanderPreSavePlugins;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->salesConfigMock = $this->getMockBuilder(SalesConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesQueryContainerInterfaceMock = $this->getMockBuilder(SalesQueryContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesToOmsInterfaceMock = $this->getMockBuilder(SalesToOmsInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderExpanderPluginInterfaceMock = $this->getMockBuilder(OrderExpanderPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderExpanderPlugins = [
            $this->orderExpanderPluginInterfaceMock,
        ];

        $this->salesToMoneyInterfaceMock = $this->getMockBuilder(SalesToMoneyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesToCountryInterfaceMock = $this->getMockBuilder(SalesToCountryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sequenceNumberSettingsTransferMock = $this->getMockBuilder(SequenceNumberSettingsTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesToSequenceNumberInterfaceMock = $this->getMockBuilder(SalesToSequenceNumberInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeQueryContainerInterfaceMock = $this->getMockBuilder(LocaleQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeMock = $this->getMockBuilder(Store::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderExpanderPreSavePluginInterfaceMock = $this->getMockBuilder(OrderExpanderPreSavePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderExpanderPreSavePlugins = [
            $this->orderExpanderPreSavePluginInterfaceMock,
        ];

        $this->orderItemExpanderPreSavePluginInterfaceMock = $this->getMockBuilder(OrderItemExpanderPreSavePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderItemExpanderPreSavePlugins = [
            $this->orderItemExpanderPreSavePluginInterfaceMock,
        ];

        $this->orderPostSavePluginInterfaceMock = $this->getMockBuilder(OrderPostSavePluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderPostSavePlugins = [
            $this->orderPostSavePluginInterfaceMock,
        ];

        $this->salesBusinessFactory = new SalesBusinessFactory();
        $this->salesBusinessFactory->setQueryContainer($this->salesQueryContainerInterfaceMock);
        $this->salesBusinessFactory->setConfig($this->salesConfigMock);
        $this->salesBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateOrderHydrator(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturnOnConsecutiveCalls(
                true,
                true,
                true
            );

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [SalesDependencyProvider::FACADE_OMS],
                [SalesDependencyProvider::HYDRATE_ORDER_PLUGINS],
                [SalesSalesDependencyProvider::FACADE_MONEY]
            )
            ->willReturnOnConsecutiveCalls(
                $this->salesToOmsInterfaceMock,
                $this->orderExpanderPlugins,
                $this->salesToMoneyInterfaceMock
            );

        $this->assertInstanceOf(OrderHydratorInterface::class, $this->salesBusinessFactory->createOrderHydrator());
    }

    /**
     * @return void
     */
    public function testCreateOrderReader(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturnOnConsecutiveCalls(
                true,
                true,
                true
            );

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [SalesDependencyProvider::FACADE_OMS],
                [SalesDependencyProvider::HYDRATE_ORDER_PLUGINS],
                [SalesSalesDependencyProvider::FACADE_MONEY]
            )
            ->willReturnOnConsecutiveCalls(
                $this->salesToOmsInterfaceMock,
                $this->orderExpanderPlugins,
                $this->salesToMoneyInterfaceMock
            );

        $this->assertInstanceOf(OrderReaderInterface::class, $this->salesBusinessFactory->createOrderReader());
    }

    /**
     * @return void
     */
    public function testCreateSalesOrderSaver(): void
    {
        $this->salesConfigMock->expects($this->atLeastOnce())
            ->method('getOrderReferenceDefaults')
            ->willReturn($this->sequenceNumberSettingsTransferMock);

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
                true
            );

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [SalesDependencyProvider::FACADE_COUNTRY],
                [SalesDependencyProvider::FACADE_OMS],
                [SalesDependencyProvider::FACADE_SEQUENCE_NUMBER],
                [SalesDependencyProvider::QUERY_CONTAINER_LOCALE],
                [SalesDependencyProvider::STORE],
                [SalesDependencyProvider::ORDER_EXPANDER_PRE_SAVE_PLUGINS],
                [SalesDependencyProvider::ORDER_ITEM_EXPANDER_PRE_SAVE_PLUGINS],
                [SalesDependencyProvider::PLUGINS_ORDER_POST_SAVE]
            )
            ->willReturnOnConsecutiveCalls(
                $this->salesToCountryInterfaceMock,
                $this->salesToOmsInterfaceMock,
                $this->salesToSequenceNumberInterfaceMock,
                $this->localeQueryContainerInterfaceMock,
                $this->storeMock,
                $this->orderExpanderPreSavePlugins,
                $this->orderItemExpanderPreSavePlugins,
                $this->orderPostSavePlugins
            );

        $this->assertInstanceOf(SalesOrderSaver::class, $this->salesBusinessFactory->createSalesOrderSaver());
    }
}
