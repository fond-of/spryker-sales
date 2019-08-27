<?php

namespace FondOfSpryker\Zed\Sales\Communication\Controller;

use Generated\Shared\Transfer\OrderListTransfer;
use Spryker\Zed\Sales\Communication\Controller\GatewayController as SprykerGatewayController;

/**
 * @method \FondOfSpryker\Zed\Sales\Business\SalesFacadeInterface getFacade()
 */
class GatewayController extends SprykerGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function findOrdersByCustomerReferenceAction(OrderListTransfer $orderListTransfer): OrderListTransfer
    {
        return $this->getFacade()->findOrdersByCustomerReference(
            $orderListTransfer,
            $orderListTransfer->getCustomerReference()
        );
    }
}
