<?php

namespace Omnipay\Bepaid\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Create a payment with the bePaid CTP API.
 *
 * @see https://docs.bepaid.by/en/checkout/payment-token
 * @method PurchaseResponse send()
 */
class CreateCardRequest extends CreateTokenRequest
{
    /**
     * @return array
     */
    public function getTransactionType()
    {
        return self::TRANSACTION_TYPE_TOKENIZATION;
    }
    
        
    /**
     * @param array $data
     * @return ResponseInterface|PurchaseResponse
     */
    public function sendData($data)
    {
        $response = $this->sendRequest(self::POST, '/checkouts', $data);

        return $this->response = new PurchaseResponse($this, $response);
    }
}
