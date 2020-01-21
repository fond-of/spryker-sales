<?php

namespace FondOfSpryker\Zed\Sales\Dependency\Facade;

use Codeception\Test\Unit;
use Spryker\Zed\Money\Business\MoneyFacadeInterface;

class SalesToMoneyBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Sales\Dependency\Facade\SalesToMoneyBridge
     */
    protected $salesToMoneyBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Money\Business\MoneyFacadeInterface
     */
    protected $moneyFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->moneyFacadeInterfaceMock = $this->getMockBuilder(MoneyFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesToMoneyBridge = new SalesToMoneyBridge($this->moneyFacadeInterfaceMock);
    }

    /**
     * @return void
     */
    public function testConvertDecimalToInteger(): void
    {
        $this->moneyFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('convertDecimalToInteger')
            ->willReturn(1);

        $this->assertSame(1, $this->salesToMoneyBridge->convertDecimalToInteger(23.4));
    }
}
