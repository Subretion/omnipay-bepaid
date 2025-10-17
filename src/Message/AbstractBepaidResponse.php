<?php

namespace Omnipay\Bepaid\Message;

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
        } else if($this->data['status'] == 'successful')
        
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
