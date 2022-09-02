<?php

namespace Ec\Qr\Controller\Adminhtml\Data;

use Magento\Framework\App\Filesystem\DirectoryList;
use Ec\Qr\Controller\Adminhtml\Action;

class Popup extends Action
{
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $configFactory = $this->configFactory->create();
        $collection = $configFactory->getCollection();
        unset($post['form_key']);

        if (isset($_FILES['popup-banner-logo']) && isset($_FILES['popup-banner-logo']['name']) && strlen($_FILES['popup-banner-logo']['name'])) {

            try {
                $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'popup-banner-logo']);
                $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $fileAdapter = $this->adapterFactory->create();
                $uploaderFactory->setAllowRenameFiles(true);
                $uploaderFactory->setFilesDispersion(true);
                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $destinationPath = $mediaDirectory->getAbsolutePath('ec_qr');
                $result = $uploaderFactory->save($destinationPath);
                if (!$result) {
                    throw new LocalizedException(
                        __('File cannot be saved to path: $1', $destinationPath)
                    );
                }
                // save file path include file name
                $File_upoad = 'ec_qr' . $result['file'];
                $this->messageManager->addSuccess(__('File Uplaoded Successfully'));
            } catch (\Exception $e) {
                $this->messageManager->addError(__('File not Uplaoded, Please try Agrain'));
            }
        } elseif (isset($post['remove-banner'])) {
            $File_upoad = '';
        } else {
            //Do nothing
        }

        foreach ($collection as $config) {
            if (isset($post[$config->getName()])) {
                $config->setValue($post[$config->getName()]);
                $config->save();
                unset($post[$config->getName()]);
            }
            if ($config->getName() == "popup-banner-logo") {
                if (isset($File_upoad)) {
                    $config->delete();
                }
            }
        }
        $configModel = $this->configFactory->create();
        foreach ($post as $key => $config) {
            $configModel->setData(
                [
                    'name' => $key,
                    'value' => $config,
                ]
            );
            $configModel->save();
        }
        if (isset($File_upoad)) {
            $configModel->setData(
                [
                    'name' => 'popup-banner-logo',
                    'value' => $File_upoad
                ]
            );
            $configModel->save();
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl('ecqr/config/popup');

        $this->messageManager->addSuccess(__("Popup Data Updated"));
        return $resultRedirect->setPath($url);
    }
}
