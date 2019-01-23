<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface;
use Spryker\Zed\Sales\Business\Model\Order\OrderHydrator as BaseOrderHydrator;
use Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface;
use Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface;
use Spryker\Zed\Tax\Business\Model\PriceCalculationHelperInterface;

class OrderHydrator extends BaseOrderHydrator
{
    /**
     * @var \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface
     */
    protected $moneyPlugin;

    /**
     * @var \Spryker\Zed\Tax\Business\Model\PriceCalculationHelperInterface
     */
    protected $priceCalculationHelper;

    /**
     * OrderHydrator constructor.
     *
     * @param \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface $omsFacade
     * @param \Spryker\Zed\Sales\Dependency\Plugin\HydrateOrderPluginInterface[] $hydrateOrderPlugins
     * @param \Spryker\Shared\Money\Dependency\Plugin\MoneyPluginInterface $moneyPlugin
     * @param \Spryker\Zed\Tax\Business\Model\PriceCalculationHelperInterface $priceCalculationHelper
     */
    public function __construct(
        SalesQueryContainerInterface $queryContainer,
        SalesToOmsInterface $omsFacade,
        array $hydrateOrderPlugins,
        MoneyPluginInterface $moneyPlugin,
        PriceCalculationHelperInterface $priceCalculationHelper
    ) {
        $this->queryContainer = $queryContainer;
        $this->omsFacade = $omsFacade;
        $this->hydrateOrderPlugins = $hydrateOrderPlugins;
        $this->moneyPlugin = $moneyPlugin;
        $this->priceCalculationHelper = $priceCalculationHelper;
    }

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

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    protected function hydrateOrderTotals(SpySalesOrder $orderEntity, OrderTransfer $orderTransfer)
    {
        parent::hydrateOrderTotals($orderEntity, $orderTransfer);

        $totals = $orderTransfer->getTotals();
        $taxTotal = $totals->getTaxTotal();
        $taxTotalAmount = $taxTotal->getAmount();

        if ($taxTotalAmount <= 0) {
            $taxTotal->setTaxRate(0);
            return;
        }

        $taxRate = $this->moneyPlugin->convertDecimalToInteger(
            $this->priceCalculationHelper->getTaxRateFromPrice($totals->getGrandTotal(), $taxTotalAmount)
        );

        $taxTotal->setTaxRate($taxRate);
    }
}
