<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface;
use Generated\Shared\Transfer\AddressTransfer;
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
     * @var \Generated\Shared\Transfer\QuoteTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $splitQuoteTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface
     */
    protected $shipmentSplitsRestApiToShipmentFacadeInterfaceMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\RestShipmentTransfer
     */
    protected $restShipmentTransferMock;

    /**
     * @var \Generated\Shared\Transfer\AddressTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $addressTransferMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Generated\Shared\Transfer\ShipmentMethodTransfer
     */
    protected $shipmentMethodTransferMock;

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

        $this->splitQuoteTransferMock = $this->getMockBuilder(QuoteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restShipmentTransferMock = $this->getMockBuilder(RestShipmentTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->addressTransferMock = $this->getMockBuilder(AddressTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentMethodTransferMock = $this->getMockBuilder(ShipmentMethodTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->shipmentSplitQuoteMapper = new ShipmentSplitQuoteMapper(
            $this->shipmentSplitsRestApiToShipmentFacadeInterfaceMock
        );
    }

    /**
     * @return void
     */
    public function testMapShipmentToQuote(): void
    {
        $idShipmentMethod = 3;
        $storeCurrencyPrice = 3;

        $this->restCheckoutRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getShipment')
            ->willReturn($this->restShipmentTransferMock);

        $this->restShipmentTransferMock->expects(static::atLeastOnce())
            ->method('getIdShipmentMethod')
            ->willReturn($idShipmentMethod);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getShippingAddress')
            ->willReturn($this->addressTransferMock);

        $this->splitQuoteTransferMock->expects(static::atLeastOnce())
            ->method('setShipment')
            ->willReturn($this->splitQuoteTransferMock);

        $this->shipmentSplitsRestApiToShipmentFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findAvailableMethodById')
            ->with($idShipmentMethod, $this->splitQuoteTransferMock)
            ->willReturn($this->shipmentMethodTransferMock);

        $this->shipmentMethodTransferMock->expects(static::atLeastOnce())
            ->method('toArray')
            ->willReturn([]);

        $this->shipmentMethodTransferMock->expects(static::atLeastOnce())
            ->method('getStoreCurrencyPrice')
            ->willReturn($storeCurrencyPrice);

        $this->splitQuoteTransferMock->expects(static::atLeastOnce())
            ->method('addExpense')
            ->willReturnSelf();

        static::assertEquals(
            $this->splitQuoteTransferMock,
            $this->shipmentSplitQuoteMapper->mapShipmentToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->splitQuoteTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapShipmentToQuoteNoShipment(): void
    {
        $this->restCheckoutRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getShipment')
            ->willReturn(null);

        static::assertEquals(
            $this->splitQuoteTransferMock,
            $this->shipmentSplitQuoteMapper->mapShipmentToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->splitQuoteTransferMock,
                $this->quoteTransferMock
            )
        );
    }

    /**
     * @return void
     */
    public function testMapShipmentToQuoteShipmentMethodNull(): void
    {
        $idShipmentMethod = 3;

        $this->restCheckoutRequestAttributesTransferMock->expects(static::atLeastOnce())
            ->method('getShipment')
            ->willReturn($this->restShipmentTransferMock);

        $this->restShipmentTransferMock->expects(static::atLeastOnce())
            ->method('getIdShipmentMethod')
            ->willReturn($idShipmentMethod);

        $this->quoteTransferMock->expects(static::atLeastOnce())
            ->method('getShippingAddress')
            ->willReturn($this->addressTransferMock);

        $this->splitQuoteTransferMock->expects(static::atLeastOnce())
            ->method('setShipment')
            ->willReturn($this->splitQuoteTransferMock);

        $this->shipmentSplitsRestApiToShipmentFacadeInterfaceMock->expects(static::atLeastOnce())
            ->method('findAvailableMethodById')
            ->with($idShipmentMethod, $this->splitQuoteTransferMock)
            ->willReturn(null);

        static::assertEquals(
            $this->splitQuoteTransferMock,
            $this->shipmentSplitQuoteMapper->mapShipmentToQuote(
                $this->restCheckoutRequestAttributesTransferMock,
                $this->quoteCollectionTransferMock,
                $this->splitQuoteTransferMock,
                $this->quoteTransferMock
            )
        );
    }
}
