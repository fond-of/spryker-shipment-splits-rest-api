<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote\ShipmentSplitQuoteMapperInterface;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\ShipmentSplitsRestApiDependencyProvider;
use Spryker\Zed\Kernel\Container;

class ShipmentSplitsRestApiBusinessFactoryTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiBusinessFactory
     */
    protected $shipmentSplitsRestApiBusinessFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface
     */
    protected $shipmentSplitsRestApiToShipmentFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentSplitsRestApiToShipmentFacadeInterfaceMock = $this->getMockBuilder(ShipmentSplitsRestApiToShipmentFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentSplitsRestApiBusinessFactory = new ShipmentSplitsRestApiBusinessFactory();
        $this->shipmentSplitsRestApiBusinessFactory->setContainer($this->containerMock);
    }

    /**
     * @return void
     */
    public function testCreateShipmentQuoteMapper(): void
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('get')
            ->with(ShipmentSplitsRestApiDependencyProvider::FACADE_SHIPMENT)
            ->willReturn($this->shipmentSplitsRestApiToShipmentFacadeInterfaceMock);

        $this->assertInstanceOf(
            ShipmentSplitQuoteMapperInterface::class,
            $this->shipmentSplitsRestApiBusinessFactory->createShipmentQuoteMapper()
        );
    }
}
