<?php

namespace FondOfSpryker\Client\Sales;

use Generated\Shared\Transfer\OrderListTransfer;
use Spryker\Client\Kernel\AbstractClient;
use Spryker\Client\Sales\SalesClient as SprykerSalesClient;

/**
 * @method \FondOfSpryker\Client\Sales\SalesFactory getFactory()
 */
class SalesClient extends SprykerSalesClient implements SalesClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function findOrdersByCustomerReference(OrderListTransfer $orderListTransfer): OrderListTransfer
    {
        return $this->getFactory()
            ->createZedSalesStub()
            ->findOrdersByCustomerReference($orderListTransfer);
    }
}
