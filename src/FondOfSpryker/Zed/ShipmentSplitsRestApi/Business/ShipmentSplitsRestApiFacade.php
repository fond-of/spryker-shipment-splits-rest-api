<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Business;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiBusinessFactory getFactory()
 */
class ShipmentSplitsRestApiFacade extends AbstractFacade implements ShipmentSplitsRestApiFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
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
        return $this->getFactory()->createShipmentQuoteMapper()
            ->mapShipmentToQuote(
                $restCheckoutRequestAttributesTransfer,
                $quoteCollectionTransfer,
                $quoteTransferSplit,
                $quoteTransfer
            );
    }
}
