<?php

namespace Subretion\Omnipay\Bepaid\Message\CTP;

use \Omnipay\Common\ItemBag;
use \Omnipay\Common\Message\AbstractRequest;
use \Subretion\Omnipay\Bepaid\GatewayCTP;

/**
 * This class holds all the common things for all of Bepaid requests.
 *
 * @see https://docs.mollie.com/index
 */
abstract class AbstractBepaidRequest extends AbstractRequest
{
    const POST = 'POST';
    const GET = 'GET';
    
    protected $baseUrl = 'https://checkout.bepaid.by/ctp/api';

    /**
     * @return string
     */
    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setShopId($value)
    {
        return $this->setParameter('shopId', $value);
    }
    
    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->getParameter('secretKey');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setBaseUrl($value)
    {
        return $this->setParameter('baseUrl', $value);
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function getBaseUrl()
    {
        return $this->getParameter('baseUrl');
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $data
     * @return array
     */
    protected function sendRequest($method, $endpoint, array $data = null)
    {
        $versions = [
            'Omnipay-bePaidCTP/' . GatewayCTP::GATEWAY_VERSION,
            'PHP/' . phpversion(),
        ];
        
        $basicString = base64_encode($this->getShopId() . ':' . $this->getSecretKey());

        $headers = [
            'Accept' => "application/json",
            'Content-Type' => "application/json",
            'Authorization' => 'Basic ' . $basicString,
            'User-Agent' => implode(' ', $versions),
            'X-API-Version' => '2'
        ];

        if (function_exists("php_uname")) {
            $headers['X-Bepaid-Client-Info'] = php_uname();
        }

        $baseUrl = (null !== $this->getBaseUrl()) ? $this->getBaseUrl() : $this->baseUrl;

        $response = $this->httpClient->request(
            $method,
            $baseUrl . $endpoint,
            $headers,
            ($data === null || $data === []) ? null : json_encode($data)
        );

        return json_decode($response->getBody(), true);
    }

}
