<?php

namespace FondOfSpryker\Client\Sales;

use Codeception\Test\Unit;
use FondOfSpryker\Client\Sales\Zed\SalesStubInterface;
use Generated\Shared\Transfer\OrderListTransfer;

class SalesClientTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\Sales\SalesClient
     */
    protected $salesClient;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\Sales\SalesFactory
     */
    protected $salesFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderListTransfer
     */
    protected $orderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\Sales\Zed\SalesStubInterface
     */
    protected $salesStubInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->salesFactoryMock = $this->getMockBuilder(SalesFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderListTransferMock = $this->getMockBuilder(OrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesStubInterfaceMock = $this->getMockBuilder(SalesStubInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesClient = new SalesClient();
        $this->salesClient->setFactory($this->salesFactoryMock);
    }

    /**
     * @return void
     */
    public function testFindOrdersByCustomerReference(): void
    {
        $this->salesFactoryMock->expects($this->atLeastOnce())
            ->method('createZedSalesStub')
            ->willReturn($this->salesStubInterfaceMock);

        $this->salesStubInterfaceMock->expects($this->atLeastOnce())
            ->method('findOrdersByCustomerReference')
            ->with($this->orderListTransferMock)
            ->willReturn($this->orderListTransferMock);

        $this->assertInstanceOf(OrderListTransfer::class, $this->salesClient->findOrdersByCustomerReference($this->orderListTransferMock));
    }
}
