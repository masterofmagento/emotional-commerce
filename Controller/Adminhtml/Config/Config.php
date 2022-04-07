<?php

namespace Ec\Qr\Controller\Adminhtml\Config;

use Ec\Qr\Controller\Adminhtml\Action;

class Config extends Action
{
    public function execute()
    {
        return $resultPage = $this->resultPageFactory->create();
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ec_Qr::config_child_admin');
    }
}
