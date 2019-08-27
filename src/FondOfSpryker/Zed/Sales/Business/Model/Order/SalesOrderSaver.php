<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\OrderResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaver as SprykerSalesOrderSaver;

class SalesOrderSaver extends SprykerSalesOrderSaver
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface
     */
    protected $countryFacade;

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderResponseTransfer
     */
    public function createSalesOrder(OrderTransfer $orderTransfer): OrderResponseTransfer
    {
        $quoteTransfer = new QuoteTransfer();
        $saveOrderTransfer = new SaveOrderTransfer();
        $orderResponseTransfer = $this->createOrderResponseTransfer();

        $quoteTransfer->fromArray($orderTransfer->toArray(), true);
        $this->addPaymentToQuoteTransfer($quoteTransfer, $orderTransfer);

        $this->saveOrderSales($quoteTransfer, $saveOrderTransfer);

        $orderTransfer->setIdSalesOrder($saveOrderTransfer->getIdSalesOrder());

        $orderResponseTransfer
            ->setIsSuccess(true)
            ->setOrderTransfer($orderTransfer);

        return $orderResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    protected function addPaymentToQuoteTransfer(QuoteTransfer $quoteTransfer, OrderTransfer $orderTransfer): void
    {
        $paymentTransfer = new PaymentTransfer();
        $paymentTransfer->setPaymentSelection($orderTransfer->getPayment()->getPaymentSelection());
        $paymentTransfer->setPaymentProvider($orderTransfer->getPayment()->getPaymentMethod());
        $paymentTransfer->setPaymentMethod($orderTransfer->getPayment()->getPaymentMethod());
        $paymentTransfer->setAmount($orderTransfer->getPayment()->getAmount());

        $quoteTransfer->setPayment($paymentTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderAddress $salesOrderAddressEntity
     *
     * @return void
     */
    protected function hydrateSalesOrderAddress(
        AddressTransfer $addressTransfer,
        SpySalesOrderAddress $salesOrderAddressEntity
    ): void {
        $salesOrderAddressEntity->fromArray($addressTransfer->toArray());

        $salesOrderAddressEntity->setFkCountry(
            $this->countryFacade->getIdCountryByIso2Code($addressTransfer->getIso2Code())
        );

        if ($addressTransfer->getRegion()) {
            $salesOrderAddressEntity->setFkRegion(
                $this->countryFacade->getIdRegionByIso2Code($addressTransfer->getRegion())
            );
        }
    }

    /**
     * @param bool $isSuccess
     *
     * @return \Generated\Shared\Transfer\OrderResponseTransfer
     */
    protected function createOrderResponseTransfer($isSuccess = true): OrderResponseTransfer
    {
        $orderResponseTransfer = new OrderResponseTransfer();
        $orderResponseTransfer->setIsSuccess($isSuccess);

        return $orderResponseTransfer;
    }
}
