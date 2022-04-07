<?php
namespace Ec\Qr\Model;

/**
 * Filters info model
 */
class EcOrder extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Ec\Qr\Model\ResourceModel\EcOrder');
    }
}
