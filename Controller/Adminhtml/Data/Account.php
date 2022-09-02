<?php

namespace Ec\Qr\Controller\Adminhtml\Data;

use Ec\Qr\Controller\Adminhtml\Action;

class Account extends Action
{
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $configFactory = $this->configFactory->create();
        $collection = $configFactory->getCollection();
        unset($post['form_key']);

        if (isset($post['price'])) {
            $ecProduct = $this->productRepository->get('ec-qr-product');
            $ecProduct->setPrice($post['price']);
            $this->productRepository->save($ecProduct);
        }

        foreach ($collection as $config) {
            if (isset($post[$config->getName()])) {
                $config->setValue($post[$config->getName()]);
                $config->save();
                unset($post[$config->getName()]);
            }
        }

        $configModel = $this->configFactory->create();
        foreach ($post as $key => $config) {
            $configModel->setData(
                [
                    'name' => $key,
                    'value' => $config
                ]
            );
            $configModel->save();
            $configModel->unsetData();
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl('ecqr/config/account');

        $this->messageManager->addSuccess(__("Account Data Updated"));
        return $resultRedirect->setPath($url);
    }
}
