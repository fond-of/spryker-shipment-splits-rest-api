<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote;

use ArrayObject;
use Codeception\Test\Unit;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Generated\Shared\Transfer\RestShipmentTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;

class ShipmentSplitQuoteMapperTest extends Unit
{
    /**
     * @var \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote\ShipmentSplitQuoteMapper
     */
    protected $shipmentSplitQuoteMapper;

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
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface
     */
    protected $shipmentSplitsRestApiToShipmentFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestShipmentTransfer
     */
    protected $restShipmentTransferMock;

    /**
     * @var int
     */
    protected $idShipmentMethod;

    /**
     * @var \ArrayObject|\Generated\Shared\Transfer\QuoteTransfer[]
     */
    protected $quotes;

    /**
     * @var int
     */
    protected $idQuote;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ShipmentMethodTransfer
     */
    protected $shipmentMethodTransferMock;

    /**
     * @var int
     */
    protected $storeCurrencyPrice;

    /**
     * @return void
     */
    protected function _before(): void
    {
        $this->shipmentSplitsRestApiToShipmentFacadeInterfaceMock = $this->getMockBuilder(ShipmentSplitsRestApiToShipmentFacadeInterface::class)
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

        $this->restShipmentTransferMock = $this->getMockBuilder(RestShipmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->idShipmentMethod = 1;

        $this->quotes = new ArrayObject([
            $this->quoteTransferMock,
        ]);

        $this->idQuote = 2;

        $this->shipmentMethodTransferMock = $this->getMockBuilder(ShipmentMethodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeCurrencyPrice = 3;

        $this->shipmentSplitQuoteMapper = new ShipmentSplitQuoteMapper(
            $this->shipmentSplitsRestApiToShipmentFacadeInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testMapShipmentToQuote(): void
    {
        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getShipment')
            ->willReturn($this->restShipmentTransferMock);

        $this->restShipmentTransferMock->expects($this->atLeastOnce())
            ->method('getIdShipmentMethod')
            ->willReturn($this->idShipmentMethod);

        $this->quoteCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getQuotes')
            ->willReturn($this->quotes);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getIdQuote')
            ->willReturnOnConsecutiveCalls($this->idQuote, 99);

        $this->shipmentSplitsRestApiToShipmentFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findAvailableMethodById')
            ->with($this->idShipmentMethod, $this->quoteTransferMock)
            ->willReturn($this->shipmentMethodTransferMock);

        $this->shipmentMethodTransferMock->expects($this->atLeastOnce())
            ->method('setStoreCurrencyPrice')
            ->with(0)
            ->willReturnSelf();

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('setShipment')
            ->willReturnSelf();

        $this->shipmentMethodTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->shipmentMethodTransferMock->expects($this->atLeastOnce())
            ->method('getStoreCurrencyPrice')
            ->willReturn($this->storeCurrencyPrice);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('addExpense')
            ->willReturnSelf();

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->shipmentSplitQuoteMapper->mapShipmentToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->quoteTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapShipmentToQuoteNoShipment(): void
    {
        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getShipment')
            ->willReturn(null);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->shipmentSplitQuoteMapper->mapShipmentToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->quoteTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapShipmentToQuoteQuoteIdsMatch(): void
    {
        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getShipment')
            ->willReturn($this->restShipmentTransferMock);

        $this->restShipmentTransferMock->expects($this->atLeastOnce())
            ->method('getIdShipmentMethod')
            ->willReturn($this->idShipmentMethod);

        $this->quoteCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getQuotes')
            ->willReturn($this->quotes);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($this->idQuote);

        $this->shipmentSplitsRestApiToShipmentFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findAvailableMethodById')
            ->with($this->idShipmentMethod, $this->quoteTransferMock)
            ->willReturn($this->shipmentMethodTransferMock);

        $this->shipmentMethodTransferMock->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->shipmentMethodTransferMock->expects($this->atLeastOnce())
            ->method('getStoreCurrencyPrice')
            ->willReturn($this->storeCurrencyPrice);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('addExpense')
            ->willReturnSelf();

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->shipmentSplitQuoteMapper->mapShipmentToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->quoteTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapShipmentToQuoteShipmentMethodNull(): void
    {
        $this->restCheckoutRequestAttributesTransferMock->expects($this->atLeastOnce())
            ->method('getShipment')
            ->willReturn($this->restShipmentTransferMock);

        $this->restShipmentTransferMock->expects($this->atLeastOnce())
            ->method('getIdShipmentMethod')
            ->willReturn($this->idShipmentMethod);

        $this->quoteCollectionTransferMock->expects($this->atLeastOnce())
            ->method('getQuotes')
            ->willReturn($this->quotes);

        $this->quoteTransferMock->expects($this->atLeastOnce())
            ->method('getIdQuote')
            ->willReturn($this->idQuote);

        $this->shipmentSplitsRestApiToShipmentFacadeInterfaceMock->expects($this->atLeastOnce())
            ->method('findAvailableMethodById')
            ->with($this->idShipmentMethod, $this->quoteTransferMock)
            ->willReturn(null);

        $this->assertInstanceOf(
            QuoteTransfer::class,
            $this->shipmentSplitQuoteMapper->mapShipmentToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->quoteTransferMock,
                $this->quoteTransferMock
            )
        );
    }
}
