<?php
namespace Ec\Qr\Controller\Image;

use \Magento\Framework\Exception\NotFoundException;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_eqModel;

    protected $_apiHelper;

    protected $_resultRawFactory;
    
    protected $_order;

    public function __construct(
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        \Magento\Framework\App\Action\Context $context,
        \Magento\Sales\Model\Order $order,
        \Ec\Qr\Helper\Api $apiHelper,
        \Ec\Qr\Model\EcOrder $eqModel
    ) {
        $this->_eqModel = $eqModel;
        $this->_order = $order;
        $this->_apiHelper = $apiHelper;
        $this->_resultRawFactory  = $resultRawFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $param = $this->getRequest()->getParams();
        $configValue = $this->_apiHelper->getConfig();
        if ($configValue['token'] == $param['token']) {
            if (isset($param['order'])) {
                $order = $this->_order->loadByIncrementId($param['order']);
                $orderQr = $this->_eqModel->getCollection()->addFieldToFilter(
                    'order_id',
                    ['eq' => $order->getData('entity_id')]
                )->load();

                if (count($orderQr) > 0) {
                    $orderQr = $orderQr->fetchItem();
                    $qr = $orderQr->getQr();
                    $resultRaw = $this->_resultRawFactory->create();
                    $resultRaw->setHeader('Content-type', 'image/jpeg');
                    $resultRaw->setHeader('Content-Length', strlen(file_get_contents($qr)));
                    $resultRaw->setContents(file_get_contents($qr));
                    return $resultRaw;
                }
            }
        }
        throw new NotFoundException(__('Some Exception message.'));
    }
}
