<?php

namespace FondOfSpryker\Zed\Sales\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface SalesToStoreFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(): StoreTransfer;
}
