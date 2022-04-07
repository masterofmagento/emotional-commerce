<?php

namespace Ec\Qr\Controller\Adminhtml\Data;

use Magento\Framework\App\Filesystem\DirectoryList;
use Ec\Qr\Controller\Adminhtml\Action;

class Button extends Action
{
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $configFactory = $this->configFactory->create();
        $collection = $configFactory->getCollection();
        unset($post['form_key']);

        /// $fileup = $this->getRequest()->getFiles('button-banner');
        // if (isset($fileup)) {
        //echo "<pre>"; print_r($_FILES['button-banner']); die;

        if (isset($_FILES['button-banner']) && isset($_FILES['button-banner']['name']) && strlen($_FILES['button-banner']['name'])) {
            try {
                $uploaderFactory = $this->uploaderFactory->create(['fileId' => 'button-banner']);
                $uploaderFactory->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                $fileAdapter = $this->adapterFactory->create();
                $uploaderFactory->setAllowRenameFiles(true);
                $uploaderFactory->setFilesDispersion(true);
                $mediaDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $destinationPath = $mediaDirectory->getAbsolutePath('ec_qr');
                $result = $uploaderFactory->save($destinationPath);
                // print_r($result)
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
        }elseif (isset($post['remove-banner'])) {
            $File_upoad = '';
        }else{
            //Do nothing
        }

        foreach ($collection as $config) {
            if (isset($post[$config->getName()])) {
                $config->setValue($post[$config->getName()]);
                $config->save();
                unset($post[$config->getName()]);
            }
            if ($config->getName() == "button-banner") {
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
                    'value' => $config
                ]
            );
            $configModel->save();
            $configModel->unsetData();
        }
        if (isset($File_upoad)) {
            $configModel->setData(
                [
                    'name' => 'button-banner',
                    'value' => $File_upoad 
                ]
            );
            $configModel->save();
        }
        /*else{
            $configModel->setData(
                [
                    'name' => 'button-banner',
                    'value' => ''
                ]
            );
            $configModel->save();
        }*/

        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl('ecqr/config/button');

        $this->messageManager->addSuccess(__("Button Data Updated Successfully"));
        return $resultRedirect->setPath($url);
    }
}
