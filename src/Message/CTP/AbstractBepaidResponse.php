<?php

namespace Subretion\Omnipay\Bepaid\Message\CTP;

use Omnipay\Common\Message\AbstractResponse;

class AbstractBepaidResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {        
        if(isset($this->data['transaction']) && $this->data['transaction']['status'] == 'successful'){
            return true;
        }
        
        return false;
    }
    
    /**
     * @return string
     */
    public function getMessage()
    {
        return json_encode($this->data);
    }
}
