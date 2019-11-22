<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Business;

use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestOrderRequestAttributesTransfer;

interface ShipmentSplitsRestApiFacadeInterface
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
    ): QuoteTransfer;

}
