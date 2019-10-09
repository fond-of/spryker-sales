<?php

namespace FondOfSpryker\Client\Sales\Zed;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\OrderListTransfer;
use Spryker\Client\ZedRequest\ZedRequestClient;

class SalesStubTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\Sales\Zed\SalesStub
     */
    protected $salesStub;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderListTransfer
     */
    protected $orderListTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClient
     */
    protected $zedRequestClientMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->zedRequestClientMock = $this->getMockBuilder(ZedRequestClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderListTransferMock = $this->getMockBuilder(OrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesStub = new SalesStub($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testFindOrderByCustomerReference(): void
    {
        $this->zedRequestClientMock->expects($this->atLeastOnce())
            ->method('call')
            ->with('/sales/gateway/find-orders-by-customer-reference', $this->orderListTransferMock)
            ->willReturn($this->orderListTransferMock);

        $this->assertInstanceOf(OrderListTransfer::class, $this->salesStub->findOrdersByCustomerReference($this->orderListTransferMock));
    }
}
