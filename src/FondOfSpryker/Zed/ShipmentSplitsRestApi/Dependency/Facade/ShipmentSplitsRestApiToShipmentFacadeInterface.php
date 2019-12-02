<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;

interface ShipmentSplitsRestApiToShipmentFacadeInterface
{
    /**
     * @param int $idShipmentMethod
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ShipmentMethodTransfer|null
     */
    public function findAvailableMethodById(
        int $idShipmentMethod,
        QuoteTransfer $quoteTransfer
    ): ?ShipmentMethodTransfer;
}
