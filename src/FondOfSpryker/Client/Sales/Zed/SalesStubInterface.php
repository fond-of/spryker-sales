<?php

namespace FondOfSpryker\Client\Sales\Zed;

use Generated\Shared\Transfer\OrderListTransfer;
use Spryker\Client\Sales\Zed\SalesStubInterface as SprykerSalesStubInterface;

interface SalesStubInterface extends SprykerSalesStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function findOrdersByCustomerReference(OrderListTransfer $orderListTransfer): OrderListTransfer;
}
