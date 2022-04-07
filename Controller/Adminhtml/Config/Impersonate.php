<?php

namespace Ec\Qr\Controller\Adminhtml\Config;

use Ec\Qr\Controller\Adminhtml\Action;

class Impersonate extends Action
{
    public function execute()
    {
    	$resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath($this->apiHelper->getImpersonateUrl()); 
        
    }
}
