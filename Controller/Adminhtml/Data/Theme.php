<?php

namespace Ec\Qr\Controller\Adminhtml\Data;

use Ec\Qr\Controller\Adminhtml\Action;

class Theme extends Action
{
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        unset($post['form_key']);

        $theme_ids = json_encode($post);

        $collections = $this->configFactory->create()->getCollection()
            ->addFieldToFilter('name', 'theme_ids');
        foreach ($collections as $item) {
            $item->delete();
        }

        $configModel = $this->configFactory->create();
        $configModel->setData(
            [
                'name' => 'theme_ids',
                'value' => $theme_ids,
            ]
        );
        $configModel->save();

        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl('ecqr/config/theme');

        $this->messageManager->addSuccess(__("Themes Data Updated"));
        return $resultRedirect->setPath($url);
    }
}
