<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;

interface ShipmentSplitsRestApiToShipmentFacadeInterface
{
    /**
     * @param $idShipmentMethod
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ShipmentMethodTransfer|null
     */
    public function findAvailableMethodById($idShipmentMethod, QuoteTransfer $quoteTransfer): ?ShipmentMethodTransfer;
}
