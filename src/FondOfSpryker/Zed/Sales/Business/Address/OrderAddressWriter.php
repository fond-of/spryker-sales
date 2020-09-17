<?php

namespace FondOfSpryker\Zed\Sales\Business\Address;

use Generated\Shared\Transfer\AddressTransfer;
use Spryker\Zed\Sales\Business\Address\OrderAddressWriterInterface;

class OrderAddressWriter implements OrderAddressWriterInterface
{
    /**
     * @var \FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\OrderAddressExpanderPluginInterface[]
     */
    protected $orderAddressExpanderPlugins;

    /**
     * @var \Spryker\Zed\Sales\Business\Address\OrderAddressWriterInterface
     */
    protected $orderAddressWriter;

    /**
     * @param \Spryker\Zed\Sales\Business\Address\OrderAddressWriterInterface $orderAddressWriter
     * @param \FondOfSpryker\Zed\SalesExtension\Dependency\Plugin\OrderAddressExpanderPluginInterface[] $orderAddressExpanderPlugins
     */
    public function __construct(
        OrderAddressWriterInterface $orderAddressWriter,
        array $orderAddressExpanderPlugins
    ) {
        $this->orderAddressExpanderPlugins = $orderAddressExpanderPlugins;
        $this->orderAddressWriter = $orderAddressWriter;
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\AddressTransfer
     */
    public function create(AddressTransfer $addressTransfer): AddressTransfer
    {
        foreach ($this->orderAddressExpanderPlugins as $plugin) {
            $addressTransfer = $plugin->expand($addressTransfer);
        }

        return $this->orderAddressWriter->create($addressTransfer);
    }

    public function update(AddressTransfer $addressTransfer, int $idAddress): bool
    {
        return $this->orderAddressWriter->update($addressTransfer, $idAddress);
    }
}
