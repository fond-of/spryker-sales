<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use Generated\Shared\Transfer\AddressTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderAddress;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface;
use Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface;
use Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaver as SprykerSalesOrderSaver;
use Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaverPluginExecutorInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface;
use Spryker\Zed\Sales\Persistence\Propel\Mapper\SalesOrderItemMapperInterface;
use Spryker\Zed\Sales\SalesConfig;

class SalesOrderSaver extends SprykerSalesOrderSaver
{
    /**
     * @var \FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\SalesOrderAddressHydrationPluginInterface[]
     */
    protected $salesOrderAddressHydrationPlugins;

    /**
     * @param \Spryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface $countryFacade
     * @param \Spryker\Zed\Sales\Dependency\Facade\SalesToOmsInterface $omsFacade
     * @param \Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface $orderReferenceGenerator
     * @param \Spryker\Zed\Sales\SalesConfig $salesConfiguration
     * @param \Spryker\Zed\Locale\Persistence\LocaleQueryContainerInterface $localeQueryContainer
     * @param \Spryker\Shared\Kernel\Store $store
     * @param \Spryker\Zed\Sales\Dependency\Plugin\OrderExpanderPreSavePluginInterface[] $orderExpanderPreSavePlugins
     * @param \Spryker\Zed\Sales\Business\Model\Order\SalesOrderSaverPluginExecutorInterface $salesOrderSaverPluginExecutor
     * @param \Spryker\Zed\Sales\Persistence\Propel\Mapper\SalesOrderItemMapperInterface $salesOrderItemMapper
     * @param \Spryker\Zed\SalesExtension\Dependency\Plugin\OrderPostSavePluginInterface[] $orderPostSavePlugins
     * @param \FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\SalesOrderAddressHydrationPluginInterface[] $salesOrderAddressHydrationPlugins
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
        array $orderPostSavePlugins,
        array $salesOrderAddressHydrationPlugins
    ) {
        parent::__construct(
            $countryFacade,
            $omsFacade,
            $orderReferenceGenerator,
            $salesConfiguration,
            $localeQueryContainer,
            $store,
            $orderExpanderPreSavePlugins,
            $salesOrderSaverPluginExecutor,
            $salesOrderItemMapper,
            $orderPostSavePlugins
        );

        $this->salesOrderAddressHydrationPlugins = $salesOrderAddressHydrationPlugins;
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
        parent::hydrateSalesOrderAddress($addressTransfer, $salesOrderAddressEntity);

        foreach ($this->salesOrderAddressHydrationPlugins as $salesOrderAddressHydrationPlugin) {
            $salesOrderAddressEntity = $salesOrderAddressHydrationPlugin->hydrate(
                $addressTransfer,
                $salesOrderAddressEntity
            );
        }
    }
}
