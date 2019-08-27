<?php

namespace FondOfSpryker\Zed\Sales\Persistence;

use Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
use Spryker\Zed\Sales\Persistence\SalesQueryContainer as SprykerSalesQueryContainer;

/**
 * @method \Spryker\Zed\Sales\Persistence\SalesPersistenceFactory getFactory()
 */
class SalesQueryContainer extends SprykerSalesQueryContainer implements SalesQueryContainerInterface
{
    /**
     * @param string $orderReference
     *
     * @throws
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderQuery
     */
    public function querySalesOrderByOrderReference(string $orderReference): SpySalesOrderQuery
    {
        $query = $this->getFactory()->createSalesOrderQuery();

        $query->filterByOrderReference($orderReference);

        return $query;
    }

    /**
     * @param string $customerReference
     *
     * @throws
     *
     * @return
     */
    public function querySalesOrderByCustomerReference(string $customerReference): SpySalesOrderQuery
    {
        $query = $this->getFactory()->createSalesOrderQuery();

        $query->filterByCustomerReference($customerReference);

        return $query;
    }
}
