<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Spryker\Zed\Shipment\Business\ShipmentFacadeInterface;

class ShipmentSplitsRestApiToShipmentFacadeBridgeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeBridge
     */
    protected $shipmentSplitsRestApiToShipmentFacadeBridge;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Shipment\Business\ShipmentFacadeInterface
     */
    protected $shipmentFacadeInterfaceMock;

    /**
     * @var int
     */
    protected $idShipmentMethod;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ShipmentMethodTransfer
     */
    protected $shipmentMethodTransferMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->shipmentFacadeInterfaceMock = $this->getMockBuilder(ShipmentFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idShipmentMethod = 1;

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentMethodTransferMock = $this->getMockBuilder(ShipmentMethodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentSplitsRestApiToShipmentFacadeBridge = new ShipmentSplitsRestApiToShipmentFacadeBridge(
            $this->shipmentFacadeInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testFindAvailableMethodById(): void
    {
        $this->shipmentFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findAvailableMethodById')
            ->with($this->idShipmentMethod, $this->quoteTransferMock)
            ->willReturn($this->shipmentMethodTransferMock);

        $this->assertInstanceOf(
            ShipmentMethodTransfer::class,
            $this->shipmentSplitsRestApiToShipmentFacadeBridge->findAvailableMethodById(
                $this->idShipmentMethod,
                $this->quoteTransferMock
            )
        );
    }
}
