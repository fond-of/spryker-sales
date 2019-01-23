<?php

namespace FondOfSpryker\Zed\Sales\Business;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Sales\Business\SalesFacade as SprykerSalesFacade;

/**
 * @method \FondOfSpryker\Zed\Sales\Business\SalesBusinessFactory getFactory()
 */
class SalesFacade extends SprykerSalesFacade implements SalesFacadeInterface
{
    /**
     * @return void
     */
    public function saveSalesOrder(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer)
    {
        $this->getFactory()
            ->createSalesOrderSaver()
            ->saveOrderSales($quoteTransfer, $saveOrderTransfer);
    }
}
