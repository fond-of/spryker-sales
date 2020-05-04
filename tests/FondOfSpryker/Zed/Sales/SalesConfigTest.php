<?php

namespace FondOfSpryker\Zed\Sales;

use Codeception\Test\Unit;
use FondOfSpryker\Shared\Sales\SalesConstants;

class SalesConfigTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\Sales\SalesConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $salesConfig;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->salesConfig = $this->getMockBuilder(SalesConfig::class)
            ->onlyMethods(['get'])
            ->getMock();
    }

    /**
     * @return void
     */
    public function testGetReferenceEnvironmentPrefix(): void
    {
        $this->salesConfig->expects($this->atLeastOnce())
            ->method('get')
            ->with(SalesConstants::REFERENCE_ENVIRONMENT_PREFIX, null)
            ->willReturn(null);

        $this->assertEquals(null, $this->salesConfig->getReferenceEnvironmentPrefix());
    }

    /**
     * @return void
     */
    public function testGetReferenceOffset(): void
    {
        $this->salesConfig->expects($this->atLeastOnce())
            ->method('get')
            ->with(SalesConstants::REFERENCE_OFFSET, null)
            ->willReturn(null);

        $this->assertEquals(null, $this->salesConfig->getReferenceOffset());
    }

    /**
     * @return void
     */
    public function testGetReferencePrefix(): void
    {
        $this->salesConfig->expects($this->atLeastOnce())
            ->method('get')
            ->with(SalesConstants::REFERENCE_PREFIX, null)
            ->willReturn(null);

        $this->assertEquals(null, $this->salesConfig->getReferencePrefix());
    }

    /**
     * @return void
     */
    public function testGetReferenceEnvironmentPrefixWithCustomValue(): void
    {
        $environmentPrefix = 'DEV';

        $this->salesConfig->expects($this->atLeastOnce())
            ->method('get')
            ->with(SalesConstants::REFERENCE_ENVIRONMENT_PREFIX, null)
            ->willReturn($environmentPrefix);

        $this->assertEquals($environmentPrefix, $this->salesConfig->getReferenceEnvironmentPrefix());
    }

    /**
     * @return void
     */
    public function testGetReferenceOffsetWithCustomValue(): void
    {
        $offset = 10;

        $this->salesConfig->expects($this->atLeastOnce())
            ->method('get')
            ->with(SalesConstants::REFERENCE_OFFSET, null)
            ->willReturn($offset);

        $this->assertEquals($offset, $this->salesConfig->getReferenceOffset());
    }

    /**
     * @return void
     */
    public function testGetReferencePrefixWithCustomValue(): void
    {
        $prefix = 'PREFIX';

        $this->salesConfig->expects($this->atLeastOnce())
            ->method('get')
            ->with(SalesConstants::REFERENCE_PREFIX, null)
            ->willReturn($prefix);

        $this->assertEquals($prefix, $this->salesConfig->getReferencePrefix());
    }
}
