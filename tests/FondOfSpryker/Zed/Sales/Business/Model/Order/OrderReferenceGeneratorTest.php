<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use Codeception\Test\Unit;
use FondOfSpryker\Shared\Sales\SalesConstants;
use FondOfSpryker\Zed\Sales\SalesConfig;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use Spryker\Zed\Sales\Dependency\Facade\SalesToSequenceNumberInterface;

class OrderReferenceGeneratorTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Sales\Dependency\Facade\SalesToSequenceNumberInterface
     */
    protected $sequenceNumberFacadeMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\Sales\SalesConfig
     */
    protected $configMock;

    /**
     * @var string
     */
    protected $storeName;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \FondOfSpryker\Zed\Sales\Business\Model\Order\OrderReferenceGenerator
     */
    protected $orderReferenceGenerator;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->sequenceNumberFacadeMock = $this->getMockBuilder(SalesToSequenceNumberInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeName = 'FOO';

        $this->configMock = $this->getMockBuilder(SalesConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderReferenceGenerator = new OrderReferenceGenerator(
            $this->sequenceNumberFacadeMock,
            $this->configMock,
            $this->storeName,
        );
    }

    /**
     * @return void
     */
    public function testGenerateOrderReference(): void
    {
        $referencePrefix = 'PREFIX';
        $referenceEnvironmentPrefix = 'DEV';
        $referenceOffset = 5;
        $sequenceNumberPrefix = sprintf('%s-%s-', $referencePrefix, $referenceEnvironmentPrefix);
        $orderReference = sprintf('%s-000001', $sequenceNumberPrefix);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getReferencePrefix')
            ->willReturn($referencePrefix);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getUseSeparatorToConnectPrefixToOrderNumber')
            ->willReturn(true);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getReferenceEnvironmentPrefix')
            ->willReturn($referenceEnvironmentPrefix);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getReferenceOffset')
            ->willReturn($referenceOffset);

        $this->sequenceNumberFacadeMock->expects(static::atLeastOnce())
            ->method('generate')
            ->with(
                static::callback(
                    static function (SequenceNumberSettingsTransfer $sequenceNumberSettingsTransfer) use ($sequenceNumberPrefix, $referenceOffset) {
                        return $sequenceNumberSettingsTransfer->getPrefix() === $sequenceNumberPrefix
                            && $sequenceNumberSettingsTransfer->getName() === SalesConstants::REFERENCE_NAME_VALUE
                            && $sequenceNumberSettingsTransfer->getOffset() === $referenceOffset;
                    },
                ),
            )->willReturn($orderReference);

        static::assertEquals(
            $orderReference,
            $this->orderReferenceGenerator->generateOrderReference($this->quoteTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGenerateOrderReferenceWithoutSeparatorBetweenPrefixAndNumber(): void
    {
        $referencePrefix = 'PREFIX';
        $referenceEnvironmentPrefix = 'DEV';
        $referenceOffset = 5;
        $sequenceNumberPrefix = sprintf('%s-%s', $referencePrefix, $referenceEnvironmentPrefix);
        $orderReference = sprintf('%s000001', $sequenceNumberPrefix);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getReferencePrefix')
            ->willReturn($referencePrefix);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getUseSeparatorToConnectPrefixToOrderNumber')
            ->willReturn(false);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getReferenceEnvironmentPrefix')
            ->willReturn($referenceEnvironmentPrefix);

        $this->configMock->expects(static::atLeastOnce())
            ->method('getReferenceOffset')
            ->willReturn($referenceOffset);

        $this->sequenceNumberFacadeMock->expects(static::atLeastOnce())
            ->method('generate')
            ->with(
                static::callback(
                    static function (SequenceNumberSettingsTransfer $sequenceNumberSettingsTransfer) use ($sequenceNumberPrefix, $referenceOffset) {
                        return $sequenceNumberSettingsTransfer->getPrefix() === $sequenceNumberPrefix
                            && $sequenceNumberSettingsTransfer->getName() === SalesConstants::REFERENCE_NAME_VALUE
                            && $sequenceNumberSettingsTransfer->getOffset() === $referenceOffset;
                    },
                ),
            )->willReturn($orderReference);

        static::assertEquals(
            $orderReference,
            $this->orderReferenceGenerator->generateOrderReference($this->quoteTransferMock),
        );
    }
}
