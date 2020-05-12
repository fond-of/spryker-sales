<?php

namespace FondOfSpryker\Shared\Sales;

use Spryker\Shared\Sales\SalesConstants as SprykerSalesConstants;
use Spryker\Shared\SequenceNumber\SequenceNumberConstants;

interface SalesConstants extends SprykerSalesConstants
{
    public const REFERENCE_NAME_VALUE = 'OrderReference';
    public const REFERENCE_PREFIX = 'SALES:REFERENCE_PREFIX';
    public const REFERENCE_ENVIRONMENT_PREFIX = SequenceNumberConstants::ENVIRONMENT_PREFIX;
    public const REFERENCE_OFFSET = 'SALES:REFERENCE_OFFSET';
    const ORDER_REFERENCE_USE_SEPARATOR_TO_CONNECT_PREFIX_TO_ORDER_NUMBER = 'ORDER_REFERENCE_USE_SEPARATOR_TO_CONNECT_PREFIX_TO_ORDER_NUMBER';
}
