<?php
namespace Ec\Qr\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class OrderPlaceAfter implements ObserverInterface
{

    protected $checkoutSession;
    protected $ecOrder;
    protected $apiHelper;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Ec\Qr\Model\EcOrderFactory $ecOrder,
        \Ec\Qr\Helper\Api $apiHelper
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->ecOrder = $ecOrder;
        $this->apiHelper = $apiHelper;
    }


    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $incrementId = $order->getIncrementId();
        $orderId = $order->getId();

        $qrFile = $this->checkoutSession->getData('ec_qr');
        

        if (!$qrFile) {
            return;
        }

        $qrData = $this->apiHelper->uploadVideo($qrFile);

        unlink($qrFile);
        $this->checkoutSession->setData('ec_qr', 0);

        if (!$qrData['success']) {
            return;
        }

        $ecOrder = $this->ecOrder->create();
        $ecOrder->setData(
            [
                'url' => $qrData['data']['url'],
                'order_id' => $order->getId(),
                'qr' => $qrData['data']['qr'],
            ]
        );
        $ecOrder->save();
        
        $response = $this->apiHelper->createEvent($ecOrder); //Send order id

        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/custom.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('Text Log'); //Text Log
        $logger->info('Sanjay Gohil'.print_r($response, true)); // Array Log

        if (!$response['success']) {
            return '<p>It seems Something went wrong, please try again or contact our support</p>';
        }
    }
}
