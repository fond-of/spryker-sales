<?php

namespace FondOfSpryker\Zed\Sales\Dependency\Facade;

use Spryker\Zed\Sales\Dependency\Facade\SalesToMoneyBridge as SprykerSalesToMoneyBridge;

class SalesToMoneyFacadeBridge extends SprykerSalesToMoneyBridge implements SalesToMoneyFacadeInterface
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
