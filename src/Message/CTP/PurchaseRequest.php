<?php

namespace Subretion\Omnipay\Bepaid\Message\CTP;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Create a payment with the Mollie API.
 *
 * @see https://docs.mollie.com/reference/v2/payments-api/create-payment
 * @method PurchaseResponse send()
 */
class PurchaseRequest extends CreateTokenRequest
{
    /**
     * @return array
     */
    public function getTransactionType()
    {
        return self::TRANSACTION_TYPE_PAYMENT;
    }
    
        
    /**
     * @param array $data
     * @return ResponseInterface|PurchaseResponse
     */
    public function sendData($data)
    {
        $response = $this->sendRequest(self::POST, '/payments', $data);

        return $this->response = new PurchaseResponse($this, $response);
    }
}
