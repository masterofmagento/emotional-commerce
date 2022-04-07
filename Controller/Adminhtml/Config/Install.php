<?php

namespace Ec\Qr\Controller\Adminhtml\Config;

use Ec\Qr\Controller\Adminhtml\Action;

class Install extends Action
{
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $key = $post['key'];
        $secret = $post['secret'];
        $domain = $post['domain'];
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);
        $domain = str_replace('www.', '', $domain);
        $domain = explode('.', $domain);
        $post['domain'] = $domain[0];
        $keyModel = $this->configFactory->create();
        $keyModel->setData(
            [
                'name' => 'key',
                'value' => $key,
            ]
        );
        $keyModel->save();
        $secretModel = $this->configFactory->create();
        $secretModel->setData(
            [
                'name' => 'secret',
                'value' => $secret,
            ]
        );
        $secretModel->save();
        $domainModel = $this->configFactory->create();
        $domainModel->setData(
            [
                'name' => 'domain',
                'value' => $post['domain'],
            ]
        );
        $domainModel->save();
        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl('ecqr/config');
        $this->messageManager->addSuccess(__("Module Installed"));
        return $resultRedirect->setPath($url);
    }
}
