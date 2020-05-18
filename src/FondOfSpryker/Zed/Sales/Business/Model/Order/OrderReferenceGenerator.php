<?php

namespace FondOfSpryker\Zed\Sales\Business\Model\Order;

use FondOfSpryker\Shared\Sales\SalesConstants;
use FondOfSpryker\Zed\Sales\SalesConfig;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SequenceNumberSettingsTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Sales\Dependency\Facade\SalesToSequenceNumberInterface;

class OrderReferenceGenerator implements OrderReferenceGeneratorInterface
{
    /**
     * @var \Spryker\Zed\Sales\Dependency\Facade\SalesToSequenceNumberInterface
     */
    protected $sequenceNumberFacade;

    /**
     * @var \Spryker\Shared\Kernel\Store
     */
    protected $store;

    /**
     * @var \FondOfSpryker\Zed\Sales\SalesConfig
     */
    protected $config;

    /**
     * @param \Spryker\Zed\Sales\Dependency\Facade\SalesToSequenceNumberInterface $sequenceNumberFacade
     * @param \Spryker\Shared\Kernel\Store $store
     * @param \FondOfSpryker\Zed\Sales\SalesConfig $config
     */
    public function __construct(
        SalesToSequenceNumberInterface $sequenceNumberFacade,
        Store $store,
        SalesConfig $config
    ) {
        $this->sequenceNumberFacade = $sequenceNumberFacade;
        $this->store = $store;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return string
     */
    public function generateOrderReference(QuoteTransfer $quoteTransfer): string
    {
        $sequenceNumberSettingsTransfer = $this->getSequenceNumberSettingsTransfer();

        return $this->sequenceNumberFacade->generate($sequenceNumberSettingsTransfer);
    }

    /**
     * @return \Generated\Shared\Transfer\SequenceNumberSettingsTransfer
     */
    protected function getSequenceNumberSettingsTransfer(): SequenceNumberSettingsTransfer
    {
        $sequenceNumberSettingsTransfer = (new SequenceNumberSettingsTransfer())
            ->setName(SalesConstants::REFERENCE_NAME_VALUE)
            ->setPrefix($this->getSequenceNumberPrefix());

        if ($this->config->getReferenceOffset() === null) {
            return $sequenceNumberSettingsTransfer;
        }

        return $sequenceNumberSettingsTransfer->setOffset($this->config->getReferenceOffset());
    }

    /**
     * @return string
     */
    protected function getSequenceNumberPrefix(): string
    {
        $sequenceNumberPrefixParts = [
            $this->store->getStoreName(),
        ];

        $referencePrefix = $this->config->getReferencePrefix();

        if ($referencePrefix !== null && $referencePrefix !== '') {
            $sequenceNumberPrefixParts[0] = $referencePrefix;
        }

        $referenceEnvironmentPrefix = $this->config->getReferenceEnvironmentPrefix();

        if ($referenceEnvironmentPrefix !== null && $referenceEnvironmentPrefix !== '') {
            $sequenceNumberPrefixParts[] = $referenceEnvironmentPrefix;
        }

        return $this->createPrefix($sequenceNumberPrefixParts);
    }

    /**
     * @param  array  $sequenceNumberPrefixParts
     *
     * @return string
     */
    protected function createPrefix(array $sequenceNumberPrefixParts): string
    {
        $separator = $this->getUniqueIdentifierSeparator();
        $prefix = implode($separator, $sequenceNumberPrefixParts);

        if ($this->config->getUseSeparatorToConnectPrefixToOrderNumber() === false){
            $separator = '';
        }

        return sprintf('%s%s', $prefix, $separator);
    }

    /**
     * Separator for the sequence number
     *
     * @return string
     */
    protected function getUniqueIdentifierSeparator(): string
    {
        return '-';
    }
}
