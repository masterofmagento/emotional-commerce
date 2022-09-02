<?php

namespace Ec\Qr\Controller\Adminhtml\Config;

use Ec\Qr\Controller\Adminhtml\Action;

class SetPrice extends Action
{
    public function execute()
    {

        $post = $this->getRequest()->getPostValue();
        
        if (isset($post['email']) && isset($post['domain'])) {
            return $this->register($post);
        }
        if (isset($post['email']) && isset($post['password'])) {
            return $this->login($post);
        }
        return $resultPage = $this->resultPageFactory->create();
    }

    public function register($post)
    {
        $email = $post['email'];
        $domain = $post['domain'];

        $configValue = $this->apiHelper->getConfig();

        if (!empty($configValue['email']) && !empty($configValue['domain'])) {
            return $resultPage = $this->resultPageFactory->create();
        }

        $register = $this->apiHelper->getRegister($email, $domain);
        
        if (isset($register['errors']['email'])) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $url = $this->_url->getUrl('ecqr/config');
            $this->messageManager->addErrorMessage(__($register['errors']['email'][0]));
            return $resultRedirect->setPath($url);
        }
        
        if (isset($register['errors']['domain'])) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $url = $this->_url->getUrl('ecqr/config');
            $this->messageManager->addErrorMessage(__($register['errors']['domain'][0]));
            return $resultRedirect->setPath($url);
        }
    
        if (isset($register['data']['domain']) && $register['data']['domain']) {
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

        return $resultPage = $this->resultPageFactory->create();
    }

    public function login($post)
    {
        $email = $post['email'];
        $password = $post['password'];

        $configValue = $this->apiHelper->getConfig();

        if (!empty($configValue['email']) && !empty($configValue['domain']) && !empty($configValue['key']) && !empty($configValue['secret'])) {
            return $resultPage = $this->resultPageFactory->create();
        }
        
        $login = $this->apiHelper->getLogin($email, $password);
        if (isset($login['data'])) {
            if (!$login['data']['domain']) {
                $resultRedirect = $this->resultRedirectFactory->create();
                $url = $this->_url->getUrl('ecqr/config');
                $this->messageManager->addError(__("Invalid Email / Password Entered"));
                return $resultRedirect->setPath($url);
            }
        } else {
            if (isset($login['message'])) {
                $resultRedirect = $this->resultRedirectFactory->create();
                $url = $this->_url->getUrl('ecqr/config/');
                $this->messageManager->addErrorMessage($login['message']);
                return $resultRedirect->setPath($url);
            } else {
                $resultRedirect = $this->resultRedirectFactory->create();
                $url = $this->_url->getUrl('ecqr/config/config');
                $this->messageManager->addErrorMessage(__("something wents wrong while login"));
                return $resultRedirect->setPath($url);
            }
        }
        

        $configModel = $this->configFactory->create();
        $configModel->setData(
            [
                'name' => 'email',
                'value' => $email
            ]
        );
        $configModel->save();
        $configModel->unsetData();
        $configModel->setData(
            [
                'name' => 'key',
                'value' => $login['data']['key']
            ]
        );
        $configModel->save();
        $configModel->unsetData();
        $configModel->setData(
            [
                'name' => 'secret',
                'value' => $login['data']['secret']
            ]
        );
        $configModel->save();
        $configModel->unsetData();
        $configModel->setData(
            [
                'name' => 'domain',
                'value' => $login['data']['domain']
            ]
        );
        $configModel->save();

        return $resultPage = $this->resultPageFactory->create();
    }
}
