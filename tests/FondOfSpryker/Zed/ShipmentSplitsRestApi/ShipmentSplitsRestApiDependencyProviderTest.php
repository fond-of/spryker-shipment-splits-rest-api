<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi;

use Codeception\Test\Unit;
use Spryker\Zed\Kernel\Container;

class ShipmentSplitsRestApiDependencyProviderTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\ShipmentSplitsRestApi\ShipmentSplitsRestApiDependencyProvider
     */
    protected $shipmentSplitsRestApiDependencyProvider;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Zed\Kernel\Container
     */
    protected $containerMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentSplitsRestApiDependencyProvider = new ShipmentSplitsRestApiDependencyProvider();
    }

    /**
     * @return void
     */
    public function testProvideBusinessLayerDependencies(): void
    {
        static::assertEquals(
            $this->containerMock,
            $this->shipmentSplitsRestApiDependencyProvider->provideBusinessLayerDependencies(
                $this->containerMock
            )
        );
    }
}
