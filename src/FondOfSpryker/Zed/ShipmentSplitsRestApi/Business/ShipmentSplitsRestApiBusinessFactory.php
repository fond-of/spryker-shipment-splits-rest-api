<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Business;

use FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote\ShipmentSplitQuoteMapper;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote\ShipmentSplitQuoteMapperInterface;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\ShipmentSplitsRestApiDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class ShipmentSplitsRestApiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote\ShipmentSplitQuoteMapperInterface
     */
    public function createShipmentQuoteMapper(): ShipmentSplitQuoteMapperInterface
    {
        return new ShipmentSplitQuoteMapper($this->getShipmentFacade());
    }

    /**
     * @return \FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface
     */
    public function getShipmentFacade(): ShipmentSplitsRestApiToShipmentFacadeInterface
    {
        return $this->getProvidedDependency(ShipmentSplitsRestApiDependencyProvider::FACADE_SHIPMENT);
    }

}
