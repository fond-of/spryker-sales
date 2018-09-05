<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Sales\Business\Model\Order\OrderHydrator as BaseOrderHydrator;

class OrderHydrator extends BaseOrderHydrator
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function hydrateBaseOrderTransfer(SpySalesOrder $orderEntity): OrderTransfer
    {
        $orderTransfer = parent::hydrateBaseOrderTransfer($orderEntity);

        $localeTransfer = new LocaleTransfer();
        $localeTransfer->fromArray($orderEntity->getLocale()->toArray());

        $orderTransfer->setLocale($localeTransfer);

        return $orderTransfer;
    }
}
