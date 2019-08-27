<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use Generated\Shared\Transfer\OrderResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaverInterface as SprykerSalesOrderSaverInterface;

interface SalesOrderSaverInterface extends SprykerSalesOrderSaverInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderResponseTransfer
     */
    public function createSalesOrder(OrderTransfer $orderTransfer): OrderResponseTransfer;
}
