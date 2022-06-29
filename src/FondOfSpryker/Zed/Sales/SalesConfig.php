<?php

namespace FondOfSpryker\Zed\Sales;

use FondOfSpryker\Shared\Sales\SalesConstants;
use Spryker\Zed\Sales\SalesConfig as SprykerSalesConfig;

/**
 * @codeCoverageIgnore
 */
class SalesConfig extends SprykerSalesConfig
{
    /**
     * @return string
     */
    public function getReferenceEnvironmentPrefix(): string
    {
        return $this->get(
            SalesConstants::REFERENCE_ENVIRONMENT_PREFIX,
            SalesConstants::REFERENCE_ENVIRONMENT_PREFIX_DEFAULT,
        );
    }

    /**
     * @return string
     */
    public function getReferencePrefix(): string
    {
        return $this->get(SalesConstants::REFERENCE_PREFIX, SalesConstants::REFERENCE_PREFIX_DEFAULT);
    }

    /**
     * @return int
     */
    public function getReferenceOffset(): int
    {
        return $this->get(SalesConstants::REFERENCE_OFFSET, SalesConstants::REFERENCE_OFFSET_DEFAULT);
    }

    /**
     * @return bool
     */
    public function getUseSeparatorToConnectPrefixToOrderNumber(): bool
    {
        return $this->get(SalesConstants::USE_SEPARATOR_TO_CONNECT_PREFIX_TO_ORDER_NUMBER, true);
    }
}
