<?php

namespace Omnipay\Bepaid\Message;

/**
 * @see https://docs.mollie.com/reference/v2/payments-api/get-payment
 */
class CompletePurchaseResponse extends FetchTransactionResponse
{
    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return parent::isSuccessful() && $this->isPaid();
    }
}
