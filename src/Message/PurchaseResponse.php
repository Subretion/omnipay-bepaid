<?php

namespace Omnipay\Bepaid\Message;

/**
 * @see https://docs.bepaid.by/en/checkout/payment-token
 */
class PurchaseResponse extends FetchTransactionResponse
{
    /**
     * When you do a `purchase` the request is never successful because
     * you need to redirect off-site to complete the purchase.
     *
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return false;
    }
}
