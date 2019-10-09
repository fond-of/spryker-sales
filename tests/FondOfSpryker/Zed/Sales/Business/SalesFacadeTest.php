<?php

namespace FondOfSpryker\Zed\Sales\Business\Model;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Sales\Business\Model\Order\OrderReaderInterface;
use FondOfSpryker\Zed\Sales\Business\Model\Order\SalesOrderSaverInterface;
use FondOfSpryker\Zed\Sales\Business\SalesBusinessFactory;
use FondOfSpryker\Zed\Sales\Business\SalesFacade;
use Generated\Shared\Transfer\OrderListTransfer;
use Generated\Shared\Transfer\OrderResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;

class SalesFacadeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Business\SalesFacade
     */
    protected $salesFacade;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\Business\SalesBusinessFactory
     */
    protected $salesBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderTransfer
     */
    protected $orderTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\Business\Model\Order\SalesOrderSaverInterface
     */
    protected $salesOrderSaverInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderResponseTransfer
     */
    protected $orderResponseTransferMock;

    /**
     * @var string
     */
    protected $orderReference;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\Business\Model\Order\OrderReaderInterface
     */
    protected $orderReaderInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\OrderListTransfer
     */
    protected $orderListTransferMock;

    /**
     * @var string
     */
    protected $customerReference;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->salesBusinessFactoryMock = $this->getMockBuilder(SalesBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderTransferMock = $this->getMockBuilder(OrderTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesOrderSaverInterfaceMock = $this->getMockBuilder(SalesOrderSaverInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderResponseTransferMock = $this->getMockBuilder(OrderResponseTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderReaderInterfaceMock = $this->getMockBuilder(OrderReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderReference = "order-reference";

        $this->orderListTransferMock = $this->getMockBuilder(OrderListTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->customerReference = "customer-reference";

        $this->salesFacade = new SalesFacade();
        $this->salesFacade->setFactory($this->salesBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testAddOrder(): void
    {
        $this->salesBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createSalesOrderSaver')
            ->willReturn($this->salesOrderSaverInterfaceMock);

        $this->salesOrderSaverInterfaceMock->expects($this->atLeastOnce())
            ->method('createSalesOrder')
            ->willReturn($this->orderResponseTransferMock);

        $this->assertInstanceOf(OrderResponseTransfer::class, $this->salesFacade->addOrder($this->orderTransferMock));
    }

    /**
     * @return void
     */
    public function testFindSalesOrderByOrderReference(): void
    {
        $this->salesBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createOrderReader')
            ->willReturn($this->orderReaderInterfaceMock);

        $this->orderReaderInterfaceMock->expects($this->atLeastOnce())
            ->method('findSalesOrderByOrderReference')
            ->willReturn($this->orderTransferMock);

        $this->assertInstanceOf(OrderTransfer::class, $this->salesFacade->findSalesOrderByOrderReference($this->orderReference));
    }

    /**
     * @return void
     */
    public function testFindOrdersByCustomerReference(): void
    {
        $this->salesBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createOrderReader')
            ->willReturn($this->orderReaderInterfaceMock);

        $this->orderReaderInterfaceMock->expects($this->atLeastOnce())
            ->method('findOrdersByCustomerReference')
            ->willReturn($this->orderListTransferMock);

        $this->assertInstanceOf(OrderListTransfer::class, $this->salesFacade->findOrdersByCustomerReference($this->orderListTransferMock, $this->customerReference));
    }
}
