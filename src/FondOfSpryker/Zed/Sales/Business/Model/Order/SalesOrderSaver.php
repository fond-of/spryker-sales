<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface;
use Generated\Shared\Transfer\AddressTransfer;
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
        SalesOrderItemMapperInterface $salesOrderItemMapper
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
}
