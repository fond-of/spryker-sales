<?php

namespace FondOfSpryker\Zed\Sales\Business;

use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Sales\Business\SalesFacadeInterface as SprykerSalesFacadeInterface;

interface SalesFacadeInterface extends SprykerSalesFacadeInterface
{
    /**
     * @param string $orderReference
     * 
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrder
     */
    public function findSalesOrderByOrderReference(string $orderReference);
}
