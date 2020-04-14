<?php

namespace FondOfSpryker\Zed\Sales\Dependency\Facade;

use Spryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface;

interface SalesToMoneyFacadeInterface extends SalesToMoneyInterface
{
    /**
     * @param float $value
     *
     * @return int
     */
    public function convertDecimalToInteger(float $value): int;
}
