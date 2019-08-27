<?php

namespace FondOfSpryker\Zed\Sales\Business;

use Generated\Shared\Transfer\OrderListTransfer;
use Generated\Shared\Transfer\OrderResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Sales\Business\SalesFacade as SprykerSalesFacade;

/**
 * @method \FondOfSpryker\Zed\Sales\Business\SalesBusinessFactory getFactory()
 */
class SalesFacade extends SprykerSalesFacade implements SalesFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderResponseTransfer
     */
    public function addOrder(OrderTransfer $orderTransfer): OrderResponseTransfer
    {
        /** @var \FondOfSpryker\Zed\Sales\Business\Model\Order\SalesOrderSaverInterface $salesOrderSaver */
        $salesOrderSaver = $this->getFactory()->createSalesOrderSaver();

        return $salesOrderSaver->createSalesOrder($orderTransfer);
    }

    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\OrderTransfer|null
     */
    public function findSalesOrderByOrderReference(string $orderReference): ?OrderTransfer
    {
        return $this->getFactory()
            ->createOrderReader()
            ->findSalesOrderByOrderReference($orderReference);
    }

    /**
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function findOrdersByCustomerReference(
        OrderListTransfer $orderListTransfer,
        string $customerReference
    ): OrderListTransfer {
        return $this->getFactory()
            ->createOrderReader()
            ->findOrdersByCustomerReference($orderListTransfer, $customerReference);
    }
}
