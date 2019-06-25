<?php

namespace FondOfSpryker\Zed\Sales\Persistence;

use Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
use Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface as SprykerSalesQueryContainerInterface;

interface SalesQueryContainerInterface extends SprykerSalesQueryContainerInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderQuery
     */
    public function querySalesOrderByOrderReference(string $orderReference): SpySalesOrderQuery;

    /**
     * @param string $customerReference
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderQuery
     */
    public function querySalesOrderByCustomerReference(string $customerReference): SpySalesOrderQuery;
}
