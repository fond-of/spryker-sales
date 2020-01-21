<?php

namespace FondOfSpryker\Zed\Sales\Dependency\Facade;

use Spryker\Zed\Sales\Dependency\Facade\SalesToCountryBridge as SprykerSalesToCountryBridge;

class SalesToCountryBridge extends SprykerSalesToCountryBridge implements SalesToCountryInterface
{
    /**
     * @var \FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacade;

    /**
     * @param string $iso2code
     *
     * @return int
     */
    public function getIdRegionByIso2Code(string $iso2code): int
    {
        return $this->countryFacade->getIdRegionByIso2Code($iso2code);
    }
}
