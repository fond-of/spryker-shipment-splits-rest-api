<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Business;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestOrderRequestAttributesTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiBusinessFactory getFactory()
 */
class ShipmentSplitsRestApiFacade extends AbstractFacade implements ShipmentSplitsRestApiFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderRequestAttributesTransfer $restOrderRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\QuoteCollectionTransfer $quoteCollectionTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransferSplit
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function mapShipmentToQuote(
        RestOrderRequestAttributesTransfer $restOrderRequestAttributesTransfer,
        QuoteCollectionTransfer $quoteCollectionTransfer,
        QuoteTransfer $quoteTransferSplit,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        return $this->getFactory()->createShipmentQuoteMapper()
            ->mapShipmentToQuote(
                $restOrderRequestAttributesTransfer,
                $quoteCollectionTransfer,
                $quoteTransferSplit,
                $quoteTransfer
            );
    }
}
