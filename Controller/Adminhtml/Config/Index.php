<?php

namespace Ec\Qr\Controller\Adminhtml\Config;

use Ec\Qr\Controller\Adminhtml\Action;

class Index extends Action
{
    public function execute()
    {
        $configModel = $this->configFactory->create();
        $collection = $configModel->getCollection();
        foreach ($collection as $item) {
            if ($item->getName() == 'key') {
                $resultRedirect = $this->resultRedirectFactory->create();
                $url = $this->_url->getUrl('ecqr/config/config');
                $this->messageManager->addSuccess(__("you are already LoggedIn"));
                return $resultRedirect->setPath($url);
            }
        }
        $configValue = $this->apiHelper->getConfig();

        if (isset($configValue['email']) && isset($configValue['domain'])) 
        {
            $resultRedirect = $this->resultRedirectFactory->create();
            $url = $this->_url->getUrl('ecqr/config/setprice');
            $this->messageManager->addNoticeMessage(__("Please set rate and confirm account"));
            return $resultRedirect->setPath($url);
        }
        return $resultPage = $this->resultPageFactory->create();
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Ec_Qr::config_child_admin');
    }
}
