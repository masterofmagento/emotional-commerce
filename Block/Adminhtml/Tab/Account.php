<?php

namespace Ec\Qr\Block\Adminhtml\Tab;

use Ec\Qr\Block\Adminhtml\Config;

class Account extends Config
{
    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getAccountActionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/data/account');
    }
    public function getImpersonateUrl()
    {
        $impersonateUrl = $this->apiHelper->getImpersonateUrl();     
        return $impersonateUrl;
    }   
    public function getApiEndPointUrl()
    {
        $apiEndPointUrl = $this->apiHelper->getApiEndPointUrl();     
        return $apiEndPointUrl;
    }   
}
