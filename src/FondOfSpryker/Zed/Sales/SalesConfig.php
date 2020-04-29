<?php

namespace FondOfSpryker\Zed\Sales;

use FondOfSpryker\Shared\Sales\SalesConstants;
use Spryker\Zed\Sales\SalesConfig as SprykerSalesConfig;

class SalesConfig extends SprykerSalesConfig
{
    /**
     * @return string|null
     */
    public function getReferenceEnvironmentPrefix(): ?string
    {
        return $this->get(SalesConstants::REFERENCE_ENVIRONMENT_PREFIX, null);
    }

    /**
     * @return string|null
     */
    public function getReferencePrefix(): ?string
    {
        return $this->get(SalesConstants::REFERENCE_PREFIX, null);
    }

    /**
     * @return int|null
     */
    public function getReferenceOffset(): ?int
    {
        return $this->get(SalesConstants::REFERENCE_OFFSET, null);
    }
}
