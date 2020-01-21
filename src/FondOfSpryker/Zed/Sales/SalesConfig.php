<?php

namespace FondOfSpryker\Zed\Sales;

use FondOfSpryker\Shared\Sales\SalesConstants;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Sales\SalesConfig as SprykerSalesConfig;

class SalesConfig extends SprykerSalesConfig
{
    /**
     * Defines the prefix for the sequence number which is the public id of an order.
     *
     * @return \Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    public function getOrderReferenceDefaults(): SequenceNumberSettingsTransfer
    {
        $sequenceNumberSettingsTransfer = new SequenceNumberSettingsTransfer();

        $sequenceNumberSettingsTransfer->setName(SalesConstants::NAME_ORDER_REFERENCE);

        $sequenceNumberPrefixParts = [];
        $sequenceNumberPrefixParts[] = $this->get(SalesConstants::ORDER_REFERENCE_PREFIX, Store::getInstance()->getStoreName());

        if ($this->get(SalesConstants::ENVIRONMENT_PREFIX) !== '') {
            $sequenceNumberPrefixParts[] = $this->get(SalesConstants::ENVIRONMENT_PREFIX);
        }

        $prefix = implode($this->getUniqueIdentifierSeparator(), $sequenceNumberPrefixParts) . $this->getUniqueIdentifierSeparator();

        $sequenceNumberSettingsTransfer->setPrefix($prefix);

        if ($offset = $this->get(SalesConstants::ORDER_REFERENCE_OFFSET)) {
            $sequenceNumberSettingsTransfer->setOffset($offset);
        }

        return $sequenceNumberSettingsTransfer;
    }
}
