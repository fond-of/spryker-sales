<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface;
use Spryker\Zed\Sales\Business\Model\Order\OrderReader as SprykerOrderReader;

class OrderReader extends SprykerOrderReader implements OrderReaderInterface
{
    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\OrderTransfer|null
     */
    public function findSalesOrderByOrderReference(string $orderReference): ?OrderTransfer
    {
        $orderEntity = $this->queryContainer
            ->querySalesOrderByOrderReference($orderReference)
            ->findOne();

        if (!$orderEntity) {
            return null;
        }

        return $this->orderHydrator->hydrateOrderTransferFromPersistenceBySalesOrder($orderEntity);
    }
}
