<?php

namespace FondOfSpryker\Client\Sales\Zed;

use Generated\Shared\Transfer\OrderListTransfer;
use Spryker\Client\Sales\Zed\SalesStub as SprykerSalesStub;


class SalesStub extends SprykerSalesStub implements SalesStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function findOrdersByCustomerReference(OrderListTransfer $orderListTransfer): OrderListTransfer
    {
        /** @var \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer */
        $orderListTransfer = $this->zedStub->call('/sales/gateway/find-orders-by-customer-reference', $orderListTransfer);

        return $orderListTransfer;
    }

}
