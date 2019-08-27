<?php

namespace FondOfSpryker\Client\Sales;

use Generated\Shared\Transfer\OrderListTransfer;
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
        /** @var \FondOfSpryker\Client\Sales\Zed\SalesStubInterface $zedSalesStub */
        $zedSalesStub = $this->getFactory()->createZedSalesStub();

        return $zedSalesStub->findOrdersByCustomerReference($orderListTransfer);
    }
}
