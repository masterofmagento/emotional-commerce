<?php

namespace Ec\Qr\Block\Adminhtml\Tab;

use Ec\Qr\Block\Adminhtml\Config;

class Orders extends Config
{
    public function getOrders()
    {
        $collection = $this->_orderCollectionFactory->create();
        $collection->getSelect()->join(array('order_item' => 'sales_order_item'), 'main_table.entity_id = order_item.order_id');
        if ($this->getSearch()) {
            $collection->addFieldToFilter('increment_id', ['like' => "%".$this->getSearch()."%"]);
        }
        $collection->addFieldToFilter('order_item.sku', ['eq' => 'ec-qr-product']);
        
        return $collection;
    }

    public function getOrderViewUrl($id)
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('sales/order/view', ['order_id' => $id]);
    }

    public function getPrintqr($id)
    {
        $url = $this->context->getUrlBuilder();
        return $url->getUrl('ecqr/order/printqr', ['order_id' => $id]);
    }

    /**
     * Get object created at date
     *
     * @param string $createdAt
     * @return \DateTime
     */
    public function getOrderAdminDate($createdAt)
    {
        return $this->_localeDate->date(new \DateTime($createdAt));
    }

    public function getSearch()
    {
        return @$_GET['order-search'];
    }
}
