<?php

namespace FondOfSpryker\Zed\ShipmentSplitsRestApi\Communication\Plugin\CheckoutRestApi;

use FondOfSpryker\Zed\CheckoutRestApiExtension\Dependency\Plugin\ChildQuoteMapperPluginInterface;
use Generated\Shared\Transfer\QuoteCollectionTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\RestCheckoutRequestAttributesTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\ShipmentSplitsRestApi\Business\ShipmentSplitsRestApiFacadeInterface getFacade()
 */
class ShipmentSplitQuoteMapperPlugin extends AbstractPlugin implements ChildQuoteMapperPluginInterface
{
    /**
     * {@inheritdoc}
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
    public function map(
        RestCheckoutRequestAttributesTransfer $restCheckoutRequestAttributesTransfer,
        QuoteCollectionTransfer $quoteCollectionTransfer,
        QuoteTransfer $quoteTransferSplit,
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        return $this->getFacade()->mapShipmentToQuote(
            $restCheckoutRequestAttributesTransfer,
            $quoteCollectionTransfer,
            $quoteTransferSplit,
            $quoteTransfer
        );
    }
}
