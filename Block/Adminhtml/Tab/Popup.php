<?php

namespace Ec\Qr\Block\Adminhtml\Tab;

use Ec\Qr\Block\Adminhtml\Config;

class Popup extends Config
{
    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getPopupactionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/data/popup');
    }
}
