<?php

namespace FondOfSpryker\Client\Sales;

use FondOfSpryker\Client\Sales\Zed\SalesStub;
use Spryker\Client\Sales\SalesDependencyProvider;
use Spryker\Client\Sales\SalesFactory as SprykerSalesFactory;

class SalesFactory extends SprykerSalesFactory
{
    /**
     * @return \Spryker\Client\Sales\Zed\SalesStubInterface
     */
    public function createZedSalesStub()
    {
        return new SalesStub(
            $this->getProvidedDependency(SalesDependencyProvider::SERVICE_ZED)
        );
    }
}
