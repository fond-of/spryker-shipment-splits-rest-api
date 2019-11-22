<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Communication\Plugin\CheckoutRestApi;

use FondOfSpryker\Zed\OrderSplitsRestApiExtension\Dependency\Plugin\QuoteMapperPluginInterface;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestOrderRequestAttributesTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiFacadeInterface getFacade()
 */
class ShipmentSplitQuoteMapperPlugin extends AbstractPlugin implements QuoteMapperPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\RestOrderRequestAttributesTransfer $restOrderRequestAttributesTransfer
     * @param \Generated\Shared\Transfer\QuoteCollectionTransfer $quoteCollectionTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransferSplit
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function map(
        RestOrderRequestAttributesTransfer $restOrderRequestAttributesTransfer,
        QuoteCollectionTransfer $quoteCollectionTransfer,
        QuoteTransfer $quoteTransferSplit,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        return $this->getFacade()->mapShipmentToQuote(
            $restOrderRequestAttributesTransfer,
            $quoteCollectionTransfer,
            $quoteTransferSplit,
            $quoteTransfer
        );
    }
}
