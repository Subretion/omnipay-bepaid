<?php

namespace Subretion\Omnipay\Bepaid;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Subretion\Omnipay\Bepaid\Message\CTP\PurchaseRequest;
use Subretion\Omnipay\Bepaid\Message\CTP\AcceptNotification;

/**
 * BePaid Gateway provides a wrapper for bePaid API.
 * Please have a look at links below to have a high-level overview and see the API specification
 *
 * @see https://docs.bepaid.by/en/checkout/intro
 *
 * @method RequestInterface purchase(array $options = array())
 * @method RequestInterface completePurchase(array $options = array())
 *
 */
class GatewayCTP extends AbstractGateway
{
    /**
     * Version of our gateway.
     */
    const GATEWAY_VERSION = "2.1";

    /**
     * @return string
     */
    public function getName()
    {
        return 'BePaidCTP';
    }

    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array(
            'shopId' => '',
            'secretKey' => '',
        );
    }

    /**
     * @return string
     */
    public function getShopId()
    {
        return $this->getParameter('shopId');
    }

    /**
     * @param  string $value
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
     * @param  string $value
     * @return $this
     */
    public function setSecretKey($value)
    {
        return $this->setParameter('secretKey', $value);
    }

    /**
     * @param  array $parameters
     * @return PurchaseRequest
     */
    public function purchase(array $parameters = [])
    {
        /** @var PurchaseRequest $request */
        $request = $this->createRequest(PurchaseRequest::class, $parameters);

        return $request;
    }
    
    /**
     * @param  array $parameters
     * @return AcceptNotification
     */
    public function acceptNotification(array $parameters = [])
    {
        /** @var AcceptNotification $request */
        $request = $this->createRequest(AcceptNotification::class, $parameters);

        return $request;
    }

}
