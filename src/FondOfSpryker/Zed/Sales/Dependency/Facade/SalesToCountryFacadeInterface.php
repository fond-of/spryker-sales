<?php

namespace FondOfSpryker\Zed\Sales\Dependency\Facade;

use Spryker\Zed\Sales\Dependency\Facade\SalesToCountryInterface;

interface SalesToCountryFacadeInterface extends SalesToCountryInterface
{
    /**
     * @param string $iso2code
     *
     * @return int
     */
    public function getIdRegionByIso2Code(string $iso2code): int;
}
