<?php

namespace Ec\Qr\Block\Adminhtml\Tab;

use Ec\Qr\Block\Adminhtml\Config;

class Contact extends Config
{

    /**
     * Returns the conntact form action url
     *
     * @return array
     */
    public function getContactActionUrl()
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/data/contact');
    }
}
