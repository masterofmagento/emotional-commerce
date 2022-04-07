<?php

namespace Ec\Qr\Controller\Adminhtml\Config;

use Ec\Qr\Controller\Adminhtml\Action;

class RegisterConfirm extends Action
{
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        if (isset($post['email']) && isset($post['domain'])) 
        {
            $email = $post['email'];
            $domain = $post['domain'];
            $configValue = $this->apiHelper->getConfig();
            $register = $this->apiHelper->getRegister($email, $domain);        
            
            if (isset($register['errors']['email'])) 
            {
                $resultRedirect = $this->resultRedirectFactory->create();
                $url = $this->_url->getUrl('ecqr/config');
                $this->messageManager->addErrorMessage(__($register['errors']['email'][0]));
                return $resultRedirect->setPath($url);
            }
            
            if (isset($register['errors']['domain'])) 
            {
                $resultRedirect = $this->resultRedirectFactory->create();
                $url = $this->_url->getUrl('ecqr/config');
                $this->messageManager->addErrorMessage(__($register['errors']['domain'][0]));
                return $resultRedirect->setPath($url);
            }
        
            if (isset($register['data']['domain']) && $register['data']['domain']) 
            { 
                $configModel = $this->configFactory->create();
                $configModel->setData(
                    [
                        'name' => 'domain',
                        'value' => $register['data']['domain']
                    ]
                );           
                $configModel->save();
                    
                $configModel->setData(
                    [
                        'name' => 'email',
                        'value' => $email
                    ]
                );           
                $configModel->save();
                
            }
        }
        return $resultPage = $this->resultPageFactory->create();
    }
}
