<?php

namespace FondOfSpryker\Zed\Sales\Business\Address;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\SalesRegionConnector\Communication\Plugin\SalesExtension\RegionOrderAddressExpanderPlugin;
use Generated\Shared\Transfer\AddressTransfer;
use Spryker\Zed\Sales\Business\Address\OrderAddressWriter as SprykerOrderAddressWriter;

class OrderAddressWriterTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $addressTransferMock;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $sprykerOrderAddressWriterMock;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $orderAddressExpanderPluginMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->addressTransferMock = $this->getMockBuilder(AddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->sprykerOrderAddressWriterMock = $this->getMockBuilder(SprykerOrderAddressWriter::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderAddressExpanderPluginMock = $this->getMockBuilder(RegionOrderAddressExpanderPlugin::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return void
     */
    public function testCreateWithoutPlugins(): void
    {
        $orderAddressWriter = new OrderAddressWriter(
            $this->sprykerOrderAddressWriterMock,
            []
        );

         $this->sprykerOrderAddressWriterMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->addressTransferMock);

        $addressTransfer = $orderAddressWriter->create($this->addressTransferMock);

        $this->assertEquals($this->addressTransferMock, $addressTransfer);
    }

    /**
     * @return void
     */
    public function testCreateWithPlugins(): void
    {
        $this->orderAddressExpanderPluginMock->expects($this->once())
            ->method('expand')
            ->with($this->addressTransferMock)
            ->willReturn($this->addressTransferMock);

        $orderAddressWriter = new OrderAddressWriter(
            $this->sprykerOrderAddressWriterMock,
            [ $this->orderAddressExpanderPluginMock ]
        );

        $this->sprykerOrderAddressWriterMock
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->addressTransferMock);

        $addressTransfer = $orderAddressWriter->create($this->addressTransferMock);

        $this->assertEquals($this->addressTransferMock, $addressTransfer);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $orderAddressWriter = new OrderAddressWriter(
            $this->sprykerOrderAddressWriterMock,
            []
        );

        $this->sprykerOrderAddressWriterMock
            ->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $updated = $orderAddressWriter->update($this->addressTransferMock, 1);

        $this->assertEquals(true, $updated);
    }
}
