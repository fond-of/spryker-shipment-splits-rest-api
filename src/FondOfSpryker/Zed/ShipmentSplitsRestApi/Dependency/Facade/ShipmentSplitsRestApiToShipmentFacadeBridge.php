<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;

class ShipmentSplitsRestApiToShipmentFacadeBridge implements ShipmentSplitsRestApiToShipmentFacadeInterface
{
    /**
     * @var \Spryker\Zed\Shipment\Business\ShipmentFacadeInterface
     */
    protected $shipmentFacade;

    /**
     * @param \Spryker\Zed\Shipment\Business\ShipmentFacadeInterface $shipmentFacade
     */
    public function __construct($shipmentFacade)
    {
        $this->shipmentFacade = $shipmentFacade;
    }

    /**
     * @param $idShipmentMethod
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentMethodTransfer|null
     */
    public function findAvailableMethodById($idShipmentMethod, QuoteTransfer $quoteTransfer): ?ShipmentMethodTransfer
    {
        return $this->shipmentFacade->findAvailableMethodById($idShipmentMethod, $quoteTransfer);
    }
}
