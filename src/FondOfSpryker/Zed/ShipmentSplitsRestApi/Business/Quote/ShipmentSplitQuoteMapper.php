<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\Quote;

use FondOfSpryker\Shared\ShipmentSplitsRestApi\ShipmentSplitsRestApiConstants;
use FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface;
use Generated\Shared\Transfer\ExpenseTransfer;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Generated\Shared\Transfer\ShipmentMethodTransfer;
use Generated\Shared\Transfer\ShipmentTransfer;

class ShipmentSplitQuoteMapper implements ShipmentSplitQuoteMapperInterface
{
    /**
     * @var \FondOfSpryker\Zed\ShipmentSplitsRestApi\Dependency\Facade\ShipmentSplitsRestApiToShipmentFacadeInterface
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
        if (
            !$restCheckoutRequestAttributesTransfer->getShipment()
            || !$restCheckoutRequestAttributesTransfer->getShipment()->getIdShipmentMethod()
        ) {
            return $quoteTransferSplit;
        }

        $shipmentTransfer = (new ShipmentTransfer())
            ->setShippingAddress($quoteTransfer->getShippingAddress());

        $idShipmentMethod = $restCheckoutRequestAttributesTransfer->getShipment()->getIdShipmentMethod();

        $shipmentMethodTransfer = $this->getShipmentMethodTransfer(
            $quoteTransferSplit->setShipment($shipmentTransfer),
            $idShipmentMethod
        );

        if ($shipmentMethodTransfer === null) {
            return $quoteTransferSplit;
        }

        $shipmentTransfer->setMethod($shipmentMethodTransfer)
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
            ->setType(ShipmentSplitsRestApiConstants::SHIPMENT_EXPENSE_TYPE)
            ->setUnitNetPrice($shipmentMethodTransfer->getStoreCurrencyPrice())
            ->setUnitGrossPrice($shipmentMethodTransfer->getStoreCurrencyPrice())->setQuantity(1);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransferSplit
     * @param int $idShipmentMethod
     *
     * @return \Generated\Shared\Transfer\ShipmentMethodTransfer|null
     */
    protected function getShipmentMethodTransfer(
        QuoteTransfer $quoteTransferSplit,
        int $idShipmentMethod
    ): ?ShipmentMethodTransfer {
        return $this->shipmentFacade->findAvailableMethodById(
            $idShipmentMethod,
            $quoteTransferSplit
        );
    }
}
