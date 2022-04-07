<?php

namespace Ec\Qr\Controller\Adminhtml\Data;

use Magento\Framework\App\Filesystem\DirectoryList;
use Ec\Qr\Controller\Adminhtml\Action;

class Contact extends Action
{
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $name = $post['name'];
        $email = $post['email'];
        $subject = $post['subject'];
        $message = $post['message'];
        $mailsupport = $this->apiHelper->getContact($name, $email, $subject, $message);

        if (!$mailsupport['success']) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $url = $this->_url->getUrl('ecqr/config/contact');
            $this->messageManager->addError(__("It seems Something went wrong, please try again or contact our support"));
            return $resultRedirect->setPath($url);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $url = $this->_url->getUrl('ecqr/config/contact');
        $this->messageManager->addSuccess(__("Message Sent Successfully"));
        return $resultRedirect->setPath($url);
    }
}
