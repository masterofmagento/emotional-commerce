<?php

namespace Ec\Qr\Controller\Adminhtml\Data;

use Magento\Framework\App\Filesystem\DirectoryList;
use Ec\Qr\Controller\Adminhtml\Action;

class Campaigns extends Action
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $theme['theme_id'] = array($this->getRequest()->getParam('theme')); 
        $defaultTheme = json_encode($theme);

        $configFactory = $this->configFactory->create();
        $collection = $configFactory->getCollection();
        foreach ($collection as $config) {
            if ($config->getName() == "campaign") {
                $config->setValue($id);
                $config->save();
                unset($id);
            }
        }
        // To delete the theme
        $collections = $this->configFactory->create()->getCollection()
            ->addFieldToFilter('name', 'theme_ids');
        foreach ($collections as $item) {
            $item->delete();
        }

        if (isset($id)) {
            $configModel = $this->configFactory->create();
            $configModel->setData(
                [
                    'name' => 'campaign',
                    'value' => $id
                ]
            );
            $configModel->save();
        }
        if(isset($defaultTheme)){
            $configModel = $this->configFactory->create();
            $configModel->setData(
                [
                    'name' => 'theme_ids',
                    'value' => $defaultTheme,
                ]
            );
            $configModel->save();
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl('ecqr/config/campaigns');
        $this->messageManager->addSuccess(__("Campaigns is Set"));
        return $resultRedirect->setPath($url);
    }
}
