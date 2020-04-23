<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Communication\Plugin\CheckoutRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiFacadeInterface;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class ShipmentSplitQuoteMapperPluginTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\ShipmentSplitsRestApi\Communication\Plugin\CheckoutRestApi\ShipmentSplitQuoteMapperPlugin
     */
    protected $shipmentSplitQuoteMapperPlugin;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer
     */
    protected $restCheckoutRequestAttributesTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteCollectionTransfer
     */
    protected $quoteCollectionTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiFacadeInterface
     */
    protected $shipmentSplitsRestApiFacadeInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->shipmentSplitsRestApiFacadeInterfaceMock = $this->getMockBuilder(ShipmentSplitsRestApiFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restCheckoutRequestAttributesTransferMock = $this->getMockBuilder(RestCheckoutRequestAttributesTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteCollectionTransferMock = $this->getMockBuilder(QuoteCollectionTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->quoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentSplitQuoteMapperPlugin = new class (
            $this->shipmentSplitsRestApiFacadeInterfaceMock
        ) extends ShipmentSplitQuoteMapperPlugin {
            /**
             * @var \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiFacadeInterface
             */
            protected $shipmentSplitsRestApiFacade;

            /**
             * @param \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiFacadeInterface $shipmentSplitsRestApiFacade
             */
            public function __construct(ShipmentSplitsRestApiFacadeInterface $shipmentSplitsRestApiFacade)
            {
                $this->shipmentSplitsRestApiFacade = $shipmentSplitsRestApiFacade;
            }

            /**
             * @return \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiFacadeInterface
             */
            public function getFacade(): ShipmentSplitsRestApiFacadeInterface
            {
                return $this->shipmentSplitsRestApiFacade;
            }
        };
    }

    /**
     * @return void
     */
    public function testMap(): void
    {
        $this->shipmentSplitsRestApiFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('mapShipmentToQuote')
            ->with(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->quoteTransferMock,
                $this->quoteTransferMock
            )->willReturn($this->quoteTransferMock);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->shipmentSplitQuoteMapperPlugin->map(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->quoteTransferMock,
                $this->quoteTransferMock
            )
        );
    }
}
