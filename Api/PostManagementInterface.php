<?php
namespace Ec\Qr\Api;
interface PostManagementInterface {
    /**
     * GET for Post api
     * @param string $storeid
     * @param string $name
     * @return string
     */
    public function orderQrGetMethod($orderid);    
}