<?php

namespace Omnipay\Bepaid\Message;

use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * @see https://docs.bepaid.by/ru/integration/widget/payment_token
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
        $data = $this->data;
        if(count($data) === 1 && isset($data['transaction'])){
            $data = $data['transaction'];
        }
        return isset($data['void']['status'])
            && 'successful' === $data['void']['status'];
    }

    /**
     * @return boolean
     */
    public function isPaid()
    {
        $data = $this->data;
        if(count($data) === 1 && isset($data['transaction'])){
            $data = $data['transaction'];
        }
        return (isset($data['payment']['status'])
            && 'successful' === $data['payment']['status'])
            || (isset($data['status']) && 'successful' === $data['status']);
    }

    /**
     * @return boolean
     */
    public function isAuthorized()
    {
        $data = $this->data;
        if(count($data) === 1 && isset($data['transaction'])){
            $data = $data['transaction'];
        }
        return isset($data['authorization']['status'])
            && 'successful' === $data['authorization']['status'];
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
        $data = $this->data;
        if(count($data) === 1 && isset($data['transaction'])){
            $data = $data['transaction'];
        }
        return (isset($data['status']) && 'expired' === $data['status'])
               || isset($this->data['expired']) && $this->data['expired'];
    }

    public function isRefunded()
    {
        $data = $this->data;
        if(count($data) === 1 && isset($data['transaction'])){
            $data = $data['transaction'];
        }
        return isset($data['refund']['status'])
            && 'successful' === $data['refund']['status'];
    }

    /**
     * @return string|null
     */
    public function getTransactionReference()
    {
        $data = $this->data;
        if(count($data) === 1 && isset($data['transaction'])){
            $data = $data['transaction'];
        }
        if (isset($data['uid'])) {
            return $data['uid'];
        } elseif(isset($this->data['uid'])){
            return $this->data['uid'];
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getTransactionId()
    {
        $data = $this->data;
        if(count($data) === 1 && isset($data['transaction'])){
            $data = $data['transaction'];
        }
        if (isset($data['tracking_id'])) {
            return $data['tracking_id'];
        } elseif(isset($this->data['order']['tracking_id'])) {
            return $this->data['order']['tracking_id'];
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
        $data = $this->data;
        if(count($data) === 1 && isset($data['transaction'])){
            $data = $data['transaction'];
        }
        if (isset($data['amount'])){
            return $data['amount'];
        }

        return null;
    }

    public function getCurrency()
    {
        $data = $this->data;
        if(count($data) === 1 && isset($data['transaction'])){
            $data = $data['transaction'];
        }
        if (isset($data['currency'])) {
            return $data['currency'];
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
        } elseif ($this->data['token']){
            return $this->data['token'];
        }

        return null;
    }
}
