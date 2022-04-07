<?php
namespace Ec\Qr\Model;
use Ec\Qr\Api\PostManagementInterface;
class PostManagement implements PostManagementInterface
{
    /**
     * {@inheritdoc}
     */
    public function orderQrGetMethod($orderid)
    {
        try{
            $response = [
                    'orderid' => $orderid
            ];
        }catch(\Exception $e) {
            $response=['error' => $e->getMessage()];
        }

        return json_encode($response);
    } 
}