<?php

namespace FondOfSpryker\Shared\Sales;

use Spryker\Shared\Sales\SalesConstants as SprykerSalesConstants;
use Spryker\Shared\SequenceNumber\SequenceNumberConstants;

interface SalesConstants extends SprykerSalesConstants
{
    /**
     * @var string
     */
    public const REFERENCE_NAME_VALUE = 'OrderReference';

    /**
     * @var string
     */
    public const REFERENCE_PREFIX = 'SALES:REFERENCE_PREFIX';

    /**
     * @var string
     */
    public const REFERENCE_PREFIX_DEFAULT = '';

    /**
     * @var string
     */
    public const REFERENCE_ENVIRONMENT_PREFIX = SequenceNumberConstants::ENVIRONMENT_PREFIX;

    /**
     * @var string
     */
    public const REFERENCE_ENVIRONMENT_PREFIX_DEFAULT = '';

    /**
     * @var string
     */
    public const REFERENCE_OFFSET = 'SALES:REFERENCE_OFFSET';

    /**
     * @var int
     */
    public const REFERENCE_OFFSET_DEFAULT = 100000000;

    /**
     * @var string
     */
    public const USE_SEPARATOR_TO_CONNECT_PREFIX_TO_ORDER_NUMBER = 'SALES:USE_SEPARATOR_TO_CONNECT_PREFIX_TO_ORDER_NUMBER';
}
