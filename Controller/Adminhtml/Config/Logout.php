<?php

namespace Ec\Qr\Controller\Adminhtml\Config;

use Ec\Qr\Controller\Adminhtml\Action;

class Logout extends Action
{
    public function execute()
    {
        //$names = array('key', 'secret', 'domain', 'email');
        $collections = $this->configFactory->create()->getCollection();
            //->addFieldToFilter('name', ['in' => $names]);
        foreach ($collections as $item) {
            $item->delete();
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl('ecqr/config/index');
        $this->messageManager->addSuccess(__("You have been logged out successfully"));
        return $resultRedirect->setPath($url);
    }
}
