<?php

namespace FondOfSpryker\Zed\Sales\Dependency\Facade;

use Spryker\Zed\Sales\Dependency\Facade\SalesToMoneyBridge as SprykerSalesToMoneyBridge;

class SalesToMoneyBridge extends SprykerSalesToMoneyBridge implements SalesToMoneyInterface
{
    /**
     * @param float $value
     *
     * @return int
     */
    public function convertDecimalToInteger(float $value): int
    {
        return $this->moneyFacade->convertDecimalToInteger($value);
    }
}
