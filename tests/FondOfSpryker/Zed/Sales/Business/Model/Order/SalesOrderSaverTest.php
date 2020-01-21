<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface;
use FondOfSpryker\Zed\Sales\Dependency\Plugin\SalesOrderAddressHydrationPluginInterface;
use FondOfSpryker\Zed\Sales\SalesConfig;
use Generated\Shared\Transfer\AddressTransfer;
use ReflectionClass;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface;
use Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface;
use Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaverPluginExecutorInterface;
use Spryker\Zed\Sales\Business\Model\OrderItem\SalesOrderItemMapperInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface;

class SalesOrderSaverTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Business\Model\Order\SalesOrderSaver
     */
    protected $salesOrderSaver;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface
     */
    protected $countryFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface
     */
    protected $omsFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface
     */
    protected $orderReferenceGeneratorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\SalesConfig
     */
    protected $salesConfigMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface
     */
    protected $localeQueryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Store
     */
    protected $storeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $salesOrderSaverPluginExecutorMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Business\Model\OrderItem\SalesOrderItemMapperInterface
     */
    protected $salesOrderItemMapperMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\Dependency\Plugin\SalesOrderAddressHydrationPluginInterface
     */
    protected $salesOrderAddressHydrationPluginMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\AddressTransfer
     */
    protected $addressTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    protected $salesOrderAddressEntityMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->countryFacadeMock = $this->getMockBuilder(SalesToCountryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->omsFacadeMock = $this->getMockBuilder(SalesToOmsInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderReferenceGeneratorMock = $this->getMockBuilder(OrderReferenceGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesConfigMock = $this->getMockBuilder(SalesConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->localeQueryContainerMock = $this->getMockBuilder(LocaleQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeMock = $this->getMockBuilder(Store::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesOrderSaverPluginExecutorMock = $this->getMockBuilder(SalesOrderSaverPluginExecutorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesOrderItemMapperMock = $this->getMockBuilder(SalesOrderItemMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesOrderAddressHydrationPluginMock = $this->getMockBuilder(SalesOrderAddressHydrationPluginInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressTransferMock = $this->getMockBuilder(AddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesOrderAddressEntityMock = $this->getMockBuilder('\Orm\Zed\Sales\Persistence\SpySalesOrderAddress')
            ->disableOriginalConstructor()
            ->setMethods(['fromArray', 'setFkCountry', 'setFkRegion'])
            ->getMock();

        $this->salesOrderSaver = new SalesOrderSaver(
            $this->countryFacadeMock,
            $this->omsFacadeMock,
            $this->orderReferenceGeneratorMock,
            $this->salesConfigMock,
            $this->localeQueryContainerMock,
            $this->storeMock,
            [],
            $this->salesOrderSaverPluginExecutorMock,
            $this->salesOrderItemMapperMock,
            [],
            [$this->salesOrderAddressHydrationPluginMock]
        );
    }

    /**
     * @throws
     *
     * @return void
     */
    public function testHydrateSalesOrderAddress(): void
    {
        $idCountry = 61;
        $countryIso2Code = 'DE';

        $idRegion = 10;
        $regionIso2Code = 'DE-NW';

        $addressTransferAsArray = [];

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn($addressTransferAsArray);

        $this->salesOrderAddressEntityMock->expects($this->atLeastOnce())
            ->method('fromArray')
            ->with($addressTransferAsArray)
            ->willReturn($this->salesOrderAddressEntityMock);

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getIso2Code')
            ->willReturn($countryIso2Code);

        $this->countryFacadeMock->expects($this->atLeastOnce())
            ->method('getIdCountryByIso2Code')
            ->with($countryIso2Code)
            ->willReturn($idCountry);

        $this->salesOrderAddressEntityMock->expects($this->atLeastOnce())
            ->method('setFkCountry')
            ->with($idCountry)
            ->willReturn($this->salesOrderAddressEntityMock);

        $this->addressTransferMock->expects($this->atLeastOnce())
            ->method('getRegion')
            ->willReturn($regionIso2Code);

        $this->countryFacadeMock->expects($this->atLeastOnce())
            ->method('getIdRegionByIso2Code')
            ->with($regionIso2Code)
            ->willReturn($idRegion);

        $this->salesOrderAddressEntityMock->expects($this->atLeastOnce())
            ->method('setFkRegion')
            ->with($idRegion)
            ->willReturn($this->salesOrderAddressEntityMock);

        $this->salesOrderAddressHydrationPluginMock->expects($this->atLeastOnce())
            ->method('hydrate')
            ->with($this->addressTransferMock, $this->salesOrderAddressEntityMock)
            ->willReturn($this->salesOrderAddressEntityMock);

        $reflectionClass = new ReflectionClass(SalesOrderSaver::class);

        $reflectionMethod = $reflectionClass->getMethod('hydrateSalesOrderAddress');
        $reflectionMethod->setAccessible(true);

        $reflectionMethod->invokeArgs($this->salesOrderSaver, [
            $this->addressTransferMock, $this->salesOrderAddressEntityMock,
        ]);
    }
}
