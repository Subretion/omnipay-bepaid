<?php

namespace Subretion\Omnipay\Bepaid\Message\CTP;

use DateTimeImmutable;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Subretion\Omnipay\Bepaid\GatewayCTP;

/**
 * Create a payment with the Mollie API.
 *
 * @see https://docs.mollie.com/reference/v2/payments-api/create-payment
 * @method PurchaseResponse send()
 */
abstract class CreateTokenRequest extends AbstractBepaidRequest
{
  
    const TRANSACTION_TYPE_AUTHORIZATION = 'authorization';
    
    const TRANSACTION_TYPE_PAYMENT = 'payment';
    
    const TRANSACTION_TYPE_TOKENIZATION = 'tokenization';

    const TRANSACTION_TYPE_CHARGE = 'charge';


    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->getParameter('trackingId');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setTransactionId($value)
    {
        return $this->setParameter('trackingId', $value);
    }

    /**
     * @return string
     */
    public function getDuplicateCheck()
    {
        return $this->getParameter('duplicateCheck');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setDuplicateCheck($value)
    {
        return $this->setParameter('duplicateCheck', $value);
    }

    /**
     * @return string|null
     */
    public function getDynamicBillingDescriptor()
    {
        return $this->getParameter('dynamicBillingDescriptor');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setDynamicBillingDescriptor($value)
    {
        return $this->setParameter('dynamicBillingDescriptor', $value);
    }
    
    /**
     * @return string|null
     */
    public function getExpiredAt(){
        return $this->getParameter('expiredAt');
    }
    
    /**
     * @param DateTime $value
     * @return $this
     */
    public function setExpiredAt(\DateTimeImmutable $date){
        return $this->setParameter('expiredAt', $date->format(\DateTime::ATOM));
    }

    /**
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * @return array|null
     */
    public function getAdditionalData()
    {
        return $this->getParameter('additionalData');
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setAdditionalData($value)
    {
        return $this->setParameter('additionalData', $value);
    }
    
    /**
     * @return string|null
     */
    public function getDeclineUrl()
    {
        return $this->getParameter('declineUrl');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setDeclineUrl($value)
    {
        return $this->setParameter('declineUrl', $value);
    }
    
    /**
     * @return string|null
     */
    public function getFailUrl()
    {
        return $this->getParameter('failUrl');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setFailUrl($value)
    {
        return $this->setParameter('failUrl', $value);
    }

    /**
     * @return string|null
     */
    public function getVerifyUrl()
    {
        return $this->getParameter('verifyUrl');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setVerifyUrl($value)
    {
        return $this->setParameter('verifyUrl', $value);
    }

    /**
     * @return int
     */
    public function getAutoReturn()
    {
        return $this->getParameter('autoReturn');
    }

    
    /**
     * @param int $value
     * @return $this
     */
    public function setAutoReturn($value)
    {
        return $this->setParameter('autoReturn', $value);
    }
    
    /**
     * @return string
     */
    public function getButtonText()
    {
        return $this->getParameter('buttonText');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setButtonText($value)
    {
        return $this->setParameter('buttonText', $value);
    }
    
    /**
     * @return string
     */
    public function getButtonNextText()
    {
        return $this->getParameter('buttonNextText');
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setButtonNextText($value)
    {
        return $this->setParameter('buttonNextText', $value);
    }
    
    /**
     * @return array
     */
    public function getCustomerFields()
    {
        return $this->getParameter('customerFields');
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setCustomerFields($value)
    {
        return $this->setParameter('customerFields', $value);
    }
    
    /**
     * @return array
     */
    public function getCustomer()
    {
        return $this->getParameter('customer');
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setCustomer($value)
    {
        return $this->setParameter('customer', $value);
    }
    
    /**
     * @return array
     */
    public function getPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }
    
    /**
     * @return array
     */
    public function getTravel()
    {
        return $this->getParameter('travel');
    }

    /**
     * @param array $value
     * @return $this
     */
    public function setTravel($value)
    {
        return $this->setParameter('travel', $value);
    }

    /**
     * @param integer $value
     * @return $this
     */
    public function setAttempts($value)
    {
        $this->setParameter('attempts', $value);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAttempts()
    {
        return $this->getParameter('attempts');
    }

    /**
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('shopId', 'secretKey', 'amount', 'currency', 'description');

        $data = [];
        $checkout = []; $order = []; $settings = [];
        
        $checkout['version'] = GatewayCTP::GATEWAY_VERSION;
        $checkout['transaction_type'] = $this->getTransactionType();
        $checkout['order'] =& $order;
        $checkout['settings'] =& $settings;
        $data['checkout'] =& $checkout;
        
        $order['amount'] = (int) ($this->getAmount() * 100);
        $order['currency'] = $this->getCurrency();
        $order['description'] = $this->getDescription();
        
        if(null !== $this->getTestMode()){
            $checkout['test'] = $this->getTestMode();
        }
        
        if($descriptor = $this->getDynamicBillingDescriptor()){
            $checkout['dynamic_billing_descriptor'] = $descriptor;
        }
        
        if($attempts = $this->getAttempts()){
            $checkout['attempts'] = $attempts;
        }
        
        if($trackingId = $this->getTransactionId()){
            $order['tracking_id'] = $trackingId;
        }
        
        if($expiredAt = $this->getExpiredAt()){
            $order['expired_at'] = $expiredAt;
        }
        
        if($addData = $this->getAdditionalData()){
            $order['additional_data'] = $addData;
        }
        
        if($successUrl = $this->getReturnUrl()){
            $settings['success_url'] = $successUrl;
        }
        
        if($declineUrl = $this->getDeclineUrl()){
            $settings['decline_url'] = $declineUrl;
        }
        
        if($failUrl = $this->getFailUrl()){
            $settings['fail_url'] = $failUrl;
        }
        
        $cancelUrl = $this->getCancelUrl();
        if(null !== $cancelUrl){
            $settings['cancel_url'] = $cancelUrl;
        }
        
        $notifyUrl = $this->getNotifyUrl();
        if(null !== $notifyUrl){
            $settings['notification_url'] = $notifyUrl;
        }

        $verifyUrl = $this->getVerifyUrl();
        if(null !== $verifyUrl){
            $settings['verification_url'] = $verifyUrl;
        }
        
        $autoReturn = $this->getAutoReturn();
        if(null !== $autoReturn){
            $settings['auto_return'] = $autoReturn;
        }
        
        if($buttonText = $this->getButtonText()){
            $settings['button_text'] = $buttonText;
        }
        
        if($buttonNextText = $this->getButtonNextText()){
            $settings['button_next_text'] = $buttonNextText;
        }
        
        if($language = $this->getLanguage()){
            $settings['language'] = $language;
        }
        
        $customerFields = $this->getCustomerFields();
        if(null !== $customerFields){
            $settings['customer_fields'] = $customerFields;
        }
        
        $customer = $this->getCustomer();
        if(null !== $customer){
            $checkout['customer'] = $customer;
        }
        
        $paymentMethod = $this->getPaymentMethod();
        if(null !== $paymentMethod){
            $checkout['payment_method'] = $paymentMethod;
        }
        
        $travel = $this->getTravel();
        if(null !== $travel){
            $checkout['travel'] = $travel;
        }

        return $data;
    }

}
