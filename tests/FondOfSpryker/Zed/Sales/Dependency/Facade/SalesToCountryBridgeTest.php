<?php

namespace FondOfSpryker\Zed\Sales\Dependency\Facade;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\Country\Business\CountryFacadeInterface;

class SalesToCountryBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToCountryBridge
     */
    protected $salesToCountryBridge;

    /**
     * @var string
     */
    protected $isoCode;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected $countryFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->isoCode = "iso-code";

        $this->countryFacadeInterfaceMock = $this->getMockBuilder(CountryFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesToCountryBridge = new SalesToCountryBridge($this->countryFacadeInterfaceMock);
    }

    /**
     * @return void
     */
    public function testGetIdRegionByIso2Code(): void
    {
        $this->countryFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('getIdRegionByIso2Code')
            ->willReturn(1);

        $this->assertSame(1, $this->salesToCountryBridge->getIdRegionByIso2Code($this->isoCode));
    }
}
