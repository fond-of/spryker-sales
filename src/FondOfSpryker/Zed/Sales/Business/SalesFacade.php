<?php

namespace FondOfSpryker\Zed\Sales\Business;

use Generated\Shared\Transfer\OrderListTransfer;
use Generated\Shared\Transfer\OrderResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Sales\Business\SalesFacade as SprykerSalesFacade;

/**
 * @method \FondOfSpryker\Zed\Sales\Business\SalesBusinessFactory getFactory()
 */
class SalesFacade extends SprykerSalesFacade implements SalesFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param array $orderItemCollection
     * @return \Generated\Shared\Transfer\OrderResponseTransfer
     */
    public function addOrder(OrderTransfer $orderTransfer): OrderResponseTransfer
    {
        return $this->getFactory()
            ->createSalesOrderSaver()
            ->createSalesOrder($orderTransfer);
    }

    /**
     * @return void
     */
    public function saveSalesOrder(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer)
    {
        $this->getFactory()
            ->createSalesOrderSaver()
            ->saveOrderSales($quoteTransfer, $saveOrderTransfer);
    }

    /**
     * @param string $orderReference
     * 
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrder
     */
    public function findSalesOrderByOrderReference(string $orderReference)
    {
        return $this->getFactory()
            ->createOrderReader()
            ->findSalesOrderByOrderReference($orderReference);

    }

    /**
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function findOrdersByCustomerReference(OrderListTransfer $orderListTransfer, string $customerReference): OrderListTransfer
    {
        return $this->getFactory()
            ->createOrderReader()
            ->findOrdersByCustomerReference($orderListTransfer, $customerReference);
    }
}
