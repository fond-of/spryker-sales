<?php

namespace FondOfSpryker\Client\Sales;

use Generated\Shared\Transfer\OrderListTransfer;

use Spryker\Client\Sales\SalesClientInterface as SprykerSalesClientInterface;

interface SalesClientInterface extends SprykerSalesClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function findOrdersByCustomerReference(OrderListTransfer $orderListTransfer): OrderListTransfer;
}
