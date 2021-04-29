<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote\ShipmentSplitQuoteMapperInterface;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;

class ShipmentSplitsRestApiFacadeTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiFacade
     */
    protected $shipmentSplitsRestApiFacade;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiBusinessFactory
     */
    protected $shipmentSplitsRestApiBusinessFactoryMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote\ShipmentSplitQuoteMapperInterface
     */
    protected $shipmentSplitQuoteMapperInterfaceMock;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->shipmentSplitsRestApiBusinessFactoryMock = $this->getMockBuilder(ShipmentSplitsRestApiBusinessFactory::class)
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

        $this->shipmentSplitQuoteMapperInterfaceMock = $this->getMockBuilder(ShipmentSplitQuoteMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentSplitsRestApiFacade = new ShipmentSplitsRestApiFacade();
        $this->shipmentSplitsRestApiFacade->setFactory($this->shipmentSplitsRestApiBusinessFactoryMock);
    }

    /**
     * @return void
     */
    public function testMapShipmentToQuote(): void
    {
        $this->shipmentSplitsRestApiBusinessFactoryMock->expects(static::atLeastOnce())
            ->method('createShipmentQuoteMapper')
            ->willReturn($this->shipmentSplitQuoteMapperInterfaceMock);

        $this->shipmentSplitQuoteMapperInterfaceMock->expects(static::atLeastOnce())
            ->method('mapShipmentToQuote')
            ->with(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->quoteTransferMock,
                $this->quoteTransferMock
            )->willReturn($this->quoteTransferMock);

        static::assertEquals(
            $this->quoteTransferMock,
            $this->shipmentSplitsRestApiFacade->mapShipmentToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->quoteTransferMock,
                $this->quoteTransferMock
            )
        );
    }
}
