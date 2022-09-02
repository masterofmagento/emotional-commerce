<?php

namespace Ec\Qr\Controller\Adminhtml\Config;

use Ec\Qr\Controller\Adminhtml\Action;

class Button extends Action
{
    public function execute()
    {
        return $resultPage = $this->resultPageFactory->create();
    }
}
