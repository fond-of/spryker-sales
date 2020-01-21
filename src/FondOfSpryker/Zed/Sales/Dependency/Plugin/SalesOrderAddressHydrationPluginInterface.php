<?php

namespace FondOfSpryker\Zed\Sales\Dependency\Plugin;

use Generated\Shared\Transfer\AddressTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;

interface SalesOrderAddressHydrationPluginInterface
{
    /**
     * Specifications:
     * - Hydrate sales order address with additional data
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderAddress $salesOrderAddressEntity
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderAddress
     */
    public function hydrate(
        AddressTransfer $addressTransfer,
        SpySalesOrderAddress $salesOrderAddressEntity
    ): SpySalesOrderAddress;
}
