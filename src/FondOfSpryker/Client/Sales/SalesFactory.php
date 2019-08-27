<?php

namespace FondOfSpryker\Client\Sales;

use FondOfSpryker\Client\Sales\Zed\SalesStub;
use Spryker\Client\Sales\SalesDependencyProvider;
use Spryker\Client\Sales\SalesFactory as SprykerSalesFactory;
use Spryker\Client\Sales\Zed\SalesStubInterface;

class SalesFactory extends SprykerSalesFactory
{
    /**
     * @throws
     *
     * @return \Spryker\Client\Sales\Zed\SalesStubInterface
     */
    public function createZedSalesStub(): SalesStubInterface
    {
        return new SalesStub(
            $this->getProvidedDependency(SalesDependencyProvider::SERVICE_ZED)
        );
    }
}
