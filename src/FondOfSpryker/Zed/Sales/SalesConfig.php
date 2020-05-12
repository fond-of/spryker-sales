<?php

namespace FondOfSpryker\Zed\Sales;

use FondOfSpryker\Shared\Sales\SalesConstants;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use Spryker\Shared\Kernel\Store;
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

    /**
     * @return bool
     */
    public function getUseSeparatorToConnectPrefixToOrderNo(): bool
    {
        return $this->get(SalesConstants::ORDER_REFERENCE_USE_SEPARATOR_TO_CONNECT_PREFIX_TO_ORDER_NUMBER, true);
    }

}
