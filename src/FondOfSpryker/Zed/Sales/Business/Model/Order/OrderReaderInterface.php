<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Sales\Business\Model\Order\OrderReaderInterface as SprykerOrderReaderInterface;

interface OrderReaderInterface extends SprykerOrderReaderInterface
{
    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\OrderTransfer|null
     */
    public function findSalesOrderByOrderReference(string $orderReference): ?OrderTransfer;
}
