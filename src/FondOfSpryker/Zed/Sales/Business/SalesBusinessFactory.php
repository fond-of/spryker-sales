<?php

namespace FondOfSpryker\Zed\Sales\Business;

use FondOfSpryker\Zed\Sales\Business\Address\OrderAddressWriter;
use FondOfSpryker\Zed\Sales\Business\Model\Order\OrderReferenceGenerator;
use FondOfSpryker\Zed\Sales\SalesDependencyProvider;
use Spryker\Zed\Sales\Business\Address\OrderAddressWriter as SprykerOrderAddressWriter;
use Spryker\Zed\Sales\Business\Address\OrderAddressWriterInterface;
use Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface;
use Spryker\Zed\Sales\Business\SalesBusinessFactory as SprykerSalesBusinessFactory;

/**
 * @codeCoverageIgnore
 *
 * @method \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Sales\SalesConfig getConfig()
 * @method \Spryker\Zed\Sales\Persistence\SalesEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\Sales\Persistence\SalesRepositoryInterface getRepository()
 */
class SalesBusinessFactory extends SprykerSalesBusinessFactory
{
    /**
     * @return \Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface
     */
    public function createReferenceGenerator(): OrderReferenceGeneratorInterface
    {
        /** @var \FondOfSpryker\Zed\Sales\SalesConfig $config */
        $config = $this->getConfig();

        if (method_exists($this, 'getStore')) {
            return new OrderReferenceGenerator(
                $this->getSequenceNumberFacade(),
                $config,
                $this->getStore()->getName(),
            );
        }

        return new OrderReferenceGenerator(
            $this->getSequenceNumberFacade(),
            $config,
            $this->getStoreFacade()
                ->getCurrentStore()
                ->getName(),
        );
    }

    /**
     * @return \Spryker\Zed\Sales\Business\Address\OrderAddressWriterInterface
     */
    public function createOrderAddressWriter(): OrderAddressWriterInterface
    {
        $spyOrderAddressWriter = new SprykerOrderAddressWriter($this->getEntityManager(), $this->getCountryFacade());

        return new OrderAddressWriter(
            $spyOrderAddressWriter,
            $this->getOrderAddressExpanderPlugins(),
        );
    }

    /**
     * @return array<\FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\OrderAddressExpanderPluginInterface>
     */
    protected function getOrderAddressExpanderPlugins(): array
    {
        return $this->getProvidedDependency(SalesDependencyProvider::PLUGINS_ORDER_ADDRESS_EXPANDER);
    }
}
