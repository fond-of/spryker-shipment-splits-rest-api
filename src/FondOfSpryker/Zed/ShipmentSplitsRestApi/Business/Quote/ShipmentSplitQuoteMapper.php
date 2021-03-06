<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote;

use FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface;
use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;
use Spryker\Shared\Shipment\ShipmentConstants;

class ShipmentSplitQuoteMapper implements ShipmentSplitQuoteMapperInterface
{
    /**
     * @var \Spryker\Zed\ShipmentsRestApi\Dependency\Facade\ShipmentsRestApiToShipmentFacadeInterface
     */
    protected $shipmentFacade;

    /**
     * @param \FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface $shipmentFacade
     */
    public function __construct(ShipmentSplitsRestApiToShipmentFacadeInterface $shipmentFacade)
    {
        $this->shipmentFacade = $shipmentFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\QuoteCollectionTransfer $quoteCollectionTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransferSplit
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function mapShipmentToQuote(
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer,
        QuoteCollectionTransfer $quoteCollectionTransfer,
        QuoteTransfer $quoteTransferSplit,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        if (!$restCheckoutRequestAttributesTransfer->getShipment()
            || !$restCheckoutRequestAttributesTransfer->getShipment()->getIdShipmentMethod()
        ) {
            return $quoteTransferSplit;
        }

        $idShipmentMethod = $restCheckoutRequestAttributesTransfer->getShipment()->getIdShipmentMethod();

        $shipmentMethodTransfer = $this->getShipmentMethodTransfer(
            $quoteCollectionTransfer,
            $quoteTransferSplit,
            $quoteTransfer,
            $idShipmentMethod
        );

        if ($shipmentMethodTransfer === null) {
            return $quoteTransferSplit;
        }

        $shipmentTransfer = (new ShipmentTransfer())
            ->setMethod($shipmentMethodTransfer)
            ->setShipmentSelection((string)$idShipmentMethod);

        $quoteTransferSplit->setShipment($shipmentTransfer);

        $expenseTransfer = $this->createShippingExpenseTransfer($shipmentMethodTransfer);

        $quoteTransferSplit->addExpense($expenseTransfer);

        return $quoteTransferSplit;
    }

    /**
     * @param \Generated\Shared\Transfer\ShipmentMethodTransfer $shipmentMethodTransfer
     *
     * @return \Generated\Shared\Transfer\ExpenseTransfer
     */
    protected function createShippingExpenseTransfer(ShipmentMethodTransfer $shipmentMethodTransfer): ExpenseTransfer
    {
        return (new ExpenseTransfer())
            ->fromArray($shipmentMethodTransfer->toArray(), true)
            ->setType(ShipmentConstants::SHIPMENT_EXPENSE_TYPE)
            ->setUnitNetPrice($shipmentMethodTransfer->getStoreCurrencyPrice())
            ->setUnitGrossPrice($shipmentMethodTransfer->getStoreCurrencyPrice())->setQuantity(1);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteCollectionTransfer $quoteCollectionTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransferSplit
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param int $idShipmentMethod
     *
     * @return \Generated\Shared\Transfer\ShipmentMethodTransfer|null
     */
    protected function getShipmentMethodTransfer(
        QuoteCollectionTransfer $quoteCollectionTransfer,
        QuoteTransfer $quoteTransferSplit,
        QuoteTransfer $quoteTransfer,
        int $idShipmentMethod
    ): ?ShipmentMethodTransfer {
        if ($quoteCollectionTransfer->getQuotes()->offsetGet(0)->getIdQuote() === $quoteTransferSplit->getIdQuote()) {
            return $this->shipmentFacade->findAvailableMethodById($idShipmentMethod, $quoteTransfer);
        }

        $shipmentMethodTransfer = $this->shipmentFacade->findAvailableMethodById(
            $idShipmentMethod,
            $quoteTransferSplit
        );

        if ($shipmentMethodTransfer !== null) {
            $shipmentMethodTransfer->setStoreCurrencyPrice(0);
        }

        return $shipmentMethodTransfer;
    }
}
