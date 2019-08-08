<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\OrderResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\PaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface;
use Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface;
use Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaver as SprykerSalesOrderSaver;
use Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaverPluginExecutorInterface;
use Spryker\Zed\Sales\Business\Model\OrderItem\SalesOrderItemMapperInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface;
use Spryker\Zed\Sales\SalesConfig;

class SalesOrderSaver extends SprykerSalesOrderSaver
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface
     */
    protected $countryFacade;

    /**
     * @var array
     */
    protected $orderCreatePostPlugins;

    /**
     * @param \FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface $countryFacade
     * @param \Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface $omsFacade
     * @param \Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface $orderReferenceGenerator
     * @param \Spryker\Zed\Sales\SalesConfig $salesConfiguration
     * @param \Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface $localeQueryContainer
     * @param \Spryker\Shared\Kernel\Store $store
     * @param \Spryker\Zed\Sales\Dependency\Plugin\OrderExpanderPreSavePluginInterface[] $orderExpanderPreSavePlugins
     * @param \Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaverPluginExecutorInterface $salesOrderSaverPluginExecutor
     * @param \Spryker\Zed\Sales\Business\Model\OrderItem\SalesOrderItemMapperInterface $salesOrderItemMapper
     */
    public function __construct(
        SalesToCountryInterface $countryFacade,
        SalesToOmsInterface $omsFacade,
        OrderReferenceGeneratorInterface $orderReferenceGenerator,
        SalesConfig $salesConfiguration,
        LocaleQueryContainerInterface $localeQueryContainer,
        Store $store,
        $orderExpanderPreSavePlugins,
        SalesOrderSaverPluginExecutorInterface $salesOrderSaverPluginExecutor,
        SalesOrderItemMapperInterface $salesOrderItemMapper,
        array $orderCreatePostPlugins
    ) {
        $this->countryFacade = $countryFacade;
        $this->omsFacade = $omsFacade;
        $this->orderReferenceGenerator = $orderReferenceGenerator;
        $this->salesConfiguration = $salesConfiguration;
        $this->localeQueryContainer = $localeQueryContainer;
        $this->store = $store;
        $this->orderExpanderPreSavePlugins = $orderExpanderPreSavePlugins;
        $this->salesOrderSaverPluginExecutor = $salesOrderSaverPluginExecutor;
        $this->salesOrderItemMapper = $salesOrderItemMapper;
        $this->orderCreatePostPlugins = $orderCreatePostPlugins;
    }

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

        $this->executePostCreatePlugins($orderTransfer, $saveOrderTransfer);

        $orderTransfer->setIdSalesOrder($saveOrderTransfer->getIdSalesOrder());

        $orderResponseTransfer
            ->setIsSuccess(true)
            ->setOrderTransfer($orderTransfer);

        return $orderResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     */
    public function executePostCreatePlugins(OrderTransfer $orderTransfer, SaveOrderTransfer $saveOrderTransfer): void
    {
        foreach ($this->orderCreatePostPlugins as $plugin) {
            $plugin->execute($orderTransfer, $saveOrderTransfer);
        }
    }


    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
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
    protected function hydrateSalesOrderAddress(AddressTransfer $addressTransfer, SpySalesOrderAddress $salesOrderAddressEntity)
    {
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
