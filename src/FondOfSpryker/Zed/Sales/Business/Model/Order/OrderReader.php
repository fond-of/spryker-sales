<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use Generated\Shared\Transfer\OrderListTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Spryker\Zed\Sales\Business\Model\Order\OrderReader as SprykerOrderReader;

class OrderReader extends SprykerOrderReader implements OrderReaderInterface
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Persistence\SalesQueryContainerInterface
     */
    protected $queryContainer;

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

    /**
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     * @param string $customerReference
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function findOrdersByCustomerReference(OrderListTransfer $orderListTransfer, string $customerReference): OrderListTransfer
    {
        $orderCollection = $this->queryContainer
            ->querySalesOrderByCustomerReference($customerReference)
            ->find();

        if (count($orderCollection) === 0) {
            return null;
        }

        foreach ($orderCollection as $orderEntity) {
            $orderListTransfer->addOrder(
                $this->orderHydrator->hydrateOrderTransferFromPersistenceBySalesOrder($orderEntity)
            );
        }

        return $orderListTransfer;
    }
}
