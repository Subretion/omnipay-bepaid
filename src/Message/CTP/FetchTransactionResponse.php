<?php

namespace Subretion\Omnipay\Bepaid\Message\CTP;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * @see https://docs.bepaid.by/en/gateway/transactions/payment
 */
class FetchTransactionResponse extends AbstractBepaidResponse implements RedirectResponseInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * {@inheritdoc}
     */
    public function isRedirect()
    {
        return isset($this->data['checkout']['redirect_url']);
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectUrl()
    {
        if ($this->isRedirect()) {
            return $this->data['checkout']['redirect_url'];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getRedirectData()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function isSuccessful()
    {
        return parent::isSuccessful();
    }

    /**
     * @return boolean
     */
    /*public function isOpen()
    {
        return isset($this->data['status'])
            && ('open' === $this->data['status'] || 'created' === $this->data['status']);
    }*/

    /**
     * @return boolean
     */
    public function isCancelled()
    {
        return isset($this->data['transaction']['void']['status'])
            && 'successful' === $this->data['transaction']['void']['status'];
    }

    /**
     * @return boolean
     */
    public function isPaid()
    {
        return isset($this->data['transaction']['payment']['status'])
            && 'successful' === $this->data['transaction']['payment']['status'];
    }

    /**
     * @return boolean
     */
    public function isAuthorized()
    {
        return isset($this->data['transaction']['authorization']['status'])
            && 'successful' === $this->data['transaction']['authorization']['status'];
    }

    /**
     * @return boolean
     */
    /*public function isPaidOut()
    {
        return isset($this->data['_links']['settlement']);
    }*/

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return isset($this->data['transaction']['status'])
               || isset($this->data['expired']) && $this->data['expired'] 
               || 'expired' === $this->data['transaction']['status'];
    }

    public function isRefunded()
    {
        return isset($this->data['transaction']['refund']['status'])
            && 'successful' === $this->data['transaction']['refund']['status'];
    }

    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        if (isset($this->data['transaction']['tracking_id'])) {
            return $this->data['transaction']['tracking_id'];
        } elseif(isset($this->data['order']['tracking_id'])) {
            return $this->data['order']['tracking_id'];
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getTransactionId()
    {
        if (isset($this->data['transaction']['uid'])) {
            return $this->data['transaction']['uid'];
        } elseif(isset($this->data['uid'])){
            return $this->data['uid'];
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        if (isset($this->data['status'])) {
            return $this->data['status'];
        } elseif(isset($this->data['transaction']['status'])){
            return $this->data['transaction']['status'];
        } elseif(isset($this->data['checkout']['status'])){
            return $this->data['checkout']['status'];
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getAmount()
    {
        if (isset($this->data['transaction']['amount'])){
            return $this->data['transaction']['amount'];
        }

        return null;
    }

    public function getCurrency()
    {
        if (isset($this->data['transaction']['currency'])) {
            return $this->data['transaction']['currency'];
        }

        return null;
    }

    /**
     * @return array|null
     */
    public function getToken()
    {
        if (isset($this->data['checkout']['token'])) {
            return $this->data['checkout']['token'];
        }

        return null;
    }
}
