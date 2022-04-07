<?php

namespace Ec\Qr\Block\Adminhtml\Tab;

use Ec\Qr\Block\Adminhtml\Config;

class Theme extends Config
{
    public function getThemes($key, $secret, $domain)
    {
        $themes = $this->apiHelper->getThemes($key, $secret, $domain);
        if (!$themes['success']) {
            return false;
        }
        return $themes;
    }
    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getThemeactionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/data/theme');
    }
    public function getImpersonateUrl()
    {
        $impersonateUrl = $this->apiHelper->getImpersonateUrl();     
        return $impersonateUrl;
    }   

}
