<?php

namespace FondOfSpryker\Zed\Sales\Communication\Plugin\Checkout;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\Sales\Communication\Plugin\Checkout\SalesOrderSaverPlugin as SprykerSalesOrderSaverPlugin;

/**
 * @method \FondOfSpryker\Zed\Sales\Business\SalesFacadeInterface getFacade()
 */
class SalesOrderSaverPlugin extends SprykerSalesOrderSaverPlugin
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrder(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer)
    {
        $this->getFacade()->saveSalesOrder($quoteTransfer, $saveOrderTransfer);
    }
}
