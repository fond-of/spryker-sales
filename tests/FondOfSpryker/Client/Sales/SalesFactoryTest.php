<?php

namespace FondOfSpryker\Client\Sales;

use Codeception\Test\Unit;
use FondOfSpryker\Client\Sales\Zed\SalesStubInterface;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Sales\SalesDependencyProvider;
use Spryker\Client\ZedRequest\ZedRequestClient;

class SalesFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Client\Sales\SalesFactory
     */
    protected $salesFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClient
     */
    protected $zedRequestClientMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->zedRequestClientMock = $this->getMockBuilder(ZedRequestClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->salesFactory = new SalesFactory();
        $this->salesFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateZedSalesStub(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(SalesDependencyProvider::SERVICE_ZED)
            ->willReturn($this->zedRequestClientMock);

        $this->assertInstanceOf(SalesStubInterface::class, $this->salesFactory->createZedSalesStub());
    }
}
