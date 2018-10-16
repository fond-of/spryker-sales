<?php

namespace FondOfSpryker\Zed\Sales\Business;

use FondOfSpryker\Zed\Sales\Business\Model\Order\OrderHydrator;
use Spryker\Zed\Sales\Business\Model\Order\OrderHydratorInterface;
use Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGenerator;
use Spryker\Zed\Sales\Business\SalesBusinessFactory as SprykerSalesBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\Sales\SalesConfig getConfig()
 */
class SalesBusinessFactory extends SprykerSalesBusinessFactory
{
    /**
     * @return \Spryker\Zed\Sales\Business\Model\Order\OrderHydratorInterface
     */
    public function createOrderHydrator(): OrderHydratorInterface
    {
        return new OrderHydrator(
            $this->getQueryContainer(),
            $this->getOmsFacade(),
            $this->getHydrateOrderPlugins()
        );
    }

    /**
     * @return \Spryker\Zed\Sales\Business\Model\Order\OrderReferenceGeneratorInterface
     */
    public function createReferenceGenerator()
    {
        $sequenceNumberSettings = $this->getConfig()->getOrderReferenceDefaults();

        return new OrderReferenceGenerator(
            $this->getSequenceNumberFacade(),
            $sequenceNumberSettings
        );
    }
}