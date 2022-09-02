<?php

namespace Ec\Qr\Block\Adminhtml\Tab;

use Ec\Qr\Block\Adminhtml\Config;

class Qrcode extends Config
{
    public function getImpersonateUrl()
    {
        $impersonateUrl = $this->apiHelper->getImpersonateUrl();
        return $impersonateUrl;
    }

    public function getQrcodeactionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/data/qrcode');
    }
}
