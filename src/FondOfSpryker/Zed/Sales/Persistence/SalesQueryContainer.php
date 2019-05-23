<?php

namespace FondOfSpryker\Zed\Sales\Persistence;

use FondOfSpryker\Zed\Sales\Persistence\SalesQueryContainerInterface;
use Orm\Zed\Sales\Persistence\SpySalesOrderQuery;
use Spryker\Zed\Sales\Persistence\SalesQueryContainer as SprykerSalesQueryContainer;

/**
 * @method \Spryker\Zed\Sales\Persistence\SalesPersistenceFactory getFactory()
 */
class SalesQueryContainer extends SprykerSalesQueryContainer implements SalesQueryContainerInterface
{
    /**
     *
     * @param string $orderReference
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderQuery
     */
    public function querySalesOrderByOrderReference(string $orderReference): SpySalesOrderQuery
    {
        $query = $this->getFactory()->createSalesOrderQuery();
        $query->filterByOrderReference($orderReference);

        return $query;
    }

}
