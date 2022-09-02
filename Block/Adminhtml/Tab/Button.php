<?php

namespace Ec\Qr\Block\Adminhtml\Tab;

use Ec\Qr\Block\Adminhtml\Config;

class Button extends Config
{
    /**
     * Returns the form action url
     *
     * @return array
     */
    public function getButtonActionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/data/button');
    }
}
