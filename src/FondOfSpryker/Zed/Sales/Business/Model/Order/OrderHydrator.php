<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use FondOfSpryker\Zed\Sales\Business\Model\Exception\CalculationException;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Sales\Business\Model\Order\OrderHydrator as SprykerOrderHydrator;
use Spryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface;
use Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface;

class OrderHydrator extends SprykerOrderHydrator
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface
     */
    protected $moneyFacade;

    /**
     * @var \Spryker\Zed\Tax\Business\Model\PriceCalculationHelperInterface
     */
    protected $priceCalculationHelper;

    /**
     * @param \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface $omsFacade
     * @param \Spryker\Zed\Sales\Dependency\Plugin\HydrateOrderPluginInterface[] $hydrateOrderPlugins
     * @param \Spryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface $moneyFacade
     */
    public function __construct(
        SalesQueryContainerInterface $queryContainer,
        SalesToOmsInterface $omsFacade,
        array $hydrateOrderPlugins,
        SalesToMoneyInterface $moneyFacade
    ) {
        parent::__construct($queryContainer, $omsFacade, $hydrateOrderPlugins);

        $this->moneyFacade = $moneyFacade;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @throws
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function hydrateBaseOrderTransfer(SpySalesOrder $orderEntity): OrderTransfer
    {
        $orderTransfer = parent::hydrateBaseOrderTransfer($orderEntity);

        $localeTransfer = (new LocaleTransfer())
            ->fromArray($orderEntity->getLocale()->toArray());

        return $orderTransfer->setLocale($localeTransfer);
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @throws
     *
     * @return void
     */
    protected function hydrateOrderTotals(SpySalesOrder $orderEntity, OrderTransfer $orderTransfer): void
    {
        parent::hydrateOrderTotals($orderEntity, $orderTransfer);

        $totals = $orderTransfer->getTotals();
        $taxTotal = $totals->getTaxTotal();
        $taxTotalAmount = $taxTotal->getAmount();

        if ($taxTotalAmount <= 0) {
            $taxTotal->setTaxRate(0);

            return;
        }

        $taxRate = $this->moneyFacade->convertDecimalToInteger(
            $this->getTaxRateFromPrice($totals->getGrandTotal(), $taxTotalAmount)
        );

        $taxTotal->setTaxRate($taxRate);
    }

    /**
     * @param int $price
     * @param float $taxAmount
     *
     * @throws \FondOfSpryker\Zed\Sales\Business\Model\Exception\CalculationException
     *
     * @return float
     */
    protected function getTaxRateFromPrice($price, $taxAmount): float
    {
        $price = (int)$price;

        if ($price < 0 || $taxAmount <= 0) {
            throw new CalculationException('Invalid price or tax amount value given.');
        }

        $netPrice = $price - $taxAmount;

        if ($netPrice <= 0) {
            throw new CalculationException('Division by zero.');
        }

        return $taxAmount / $netPrice;
    }
}
