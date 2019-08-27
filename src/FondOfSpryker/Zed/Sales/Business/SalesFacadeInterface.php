<?php

namespace FondOfSpryker\Zed\Sales\Business;

use Generated\Shared\Transfer\OrderListTransfer;
use Generated\Shared\Transfer\OrderResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Sales\Business\SalesFacadeInterface as SprykerSalesFacadeInterface;

interface SalesFacadeInterface extends SprykerSalesFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function findOrdersByCustomerReference(
        OrderListTransfer $orderListTransfer,
        string $customerReference
    ): OrderListTransfer;

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderResponseTransfer
     */
    public function addOrder(OrderTransfer $orderTransfer): OrderResponseTransfer;

    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\OrderTransfer|null
     */
    public function findSalesOrderByOrderReference(string $orderReference): ?OrderTransfer;
}
