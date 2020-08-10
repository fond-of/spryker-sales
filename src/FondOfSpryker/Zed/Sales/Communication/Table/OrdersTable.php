<?php

namespace FondOfSpryker\Zed\Sales\Communication\Table;

use FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToStoreFacadeInterface;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;
use Spryker\Zed\Sales\Communication\Table\OrdersTable as SprykerOrdersTable;
use Spryker\Zed\Sales\Communication\Table\OrdersTableQueryBuilderInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToCustomerInterface;
use Spryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface;
use Spryker\Zed\Sales\Dependency\Service\SalesToUtilSanitizeInterface;

class OrdersTable extends SprykerOrdersTable
{
    /**
     * @var string
     */
    protected $store;

    /**
     * @var \FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @param \Spryker\Zed\Sales\Communication\Table\OrdersTableQueryBuilderInterface $queryBuilder
     * @param \Spryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface $moneyFacade
     * @param \Spryker\Zed\Sales\Dependency\Service\SalesToUtilSanitizeInterface $sanitizeService
     * @param \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface $utilDateTimeService
     * @param \Spryker\Zed\Sales\Dependency\Facade\SalesToCustomerInterface $customerFacade
     * @param array $salesTablePlugins
     * @param \FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToStoreFacadeInterface $salesToStoreFacade
     */
    public function __construct(
        OrdersTableQueryBuilderInterface $queryBuilder,
        SalesToMoneyInterface $moneyFacade,
        SalesToUtilSanitizeInterface $sanitizeService,
        UtilDateTimeServiceInterface $utilDateTimeService,
        SalesToCustomerInterface $customerFacade,
        array $salesTablePlugins,
        SalesToStoreFacadeInterface $salesToStoreFacade
    ) {
        parent::__construct(
            $queryBuilder,
            $moneyFacade,
            $sanitizeService,
            $utilDateTimeService,
            $customerFacade,
            $salesTablePlugins
        );

        $this->storeFacade = $salesToStoreFacade;
    }

    /**
     * @param \Propel\Runtime\ActiveQuery\ModelCriteria $query
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     * @param bool $returnRawResults
     *
     * @return array|\Propel\Runtime\Collection\ObjectCollection
     */
    protected function runQuery(ModelCriteria $query, TableConfiguration $config, $returnRawResults = false)
    {
        $store = $this->getStore();

        if ($store !== null && $store !== '') {
            $query->filterByStore($this->getStore());
        }

        return parent::runQuery($query, $config, $returnRawResults);
    }

    /**
     * @return string|null
     */
    protected function getStore(): ?string
    {
        if ($this->store === null || $this->store === '') {
            $this->store = $this->request->query->get('store', null);
        }

        if ($this->store === null || $this->store === '') {
            $this->store = $this->storeFacade->getCurrentStore()->getName();
        }

        return strtoupper($this->store);
    }
}
