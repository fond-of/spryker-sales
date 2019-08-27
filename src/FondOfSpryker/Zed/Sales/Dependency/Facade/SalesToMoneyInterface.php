<?php

namespace FondOfSpryker\Zed\Sales\Dependency\Facade;

use Spryker\Zed\Sales\Dependency\Facade\SalesToMoneyInterface as SprykerSalesToMoneyInterface;

interface SalesToMoneyInterface extends SprykerSalesToMoneyInterface
{
    /**
     * @param float $value
     *
     * @return int
     */
    public function convertDecimalToInteger(float $value): int;
}
