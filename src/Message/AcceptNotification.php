<?php

namespace Omnipay\Bepaid\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\Common\Message\AbstractRequest;

/**
 * Accept Webhook notifications via bePaid API
 *
 * @see https://docs.bepaid.by/ru/dev_tools/webhooks
 * @method AcceptNotification send()
 */
class AcceptNotification extends AbstractRequest
{
    
    protected $data;
    
    /**
     * @param array $value
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * @param array $data
     * @return ResponseInterface|FetchTransactionResponse
     */
    public function sendData($data)
    {
        return $this->response = new FetchTransactionResponse($this, $data);
    }
}
