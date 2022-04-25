<?php

namespace application\models;

use application\core\Model;


class Exchanger1 extends Model
{
    public function GetProcessingPayExchanger1($id)
    {
        return $this->db->GetOneSqlRequest("SELECT * FROM `payments` WHERE `exchanger_name`='exchanger1' AND `order_id`=:id AND `status`='processing' ",['id'=>$id]);
    }

    public function GetPayExchanger1($id)
    {
        return $this->db->GetOneSqlRequest("SELECT * FROM `payments` WHERE `exchanger_name`='exchanger1' AND `order_id`=:id ",['id'=>$id]);
    }

    public function UpdatePayFromId($id)
    {
        $this->db->SendSqlRequest("UPDATE `payments` SET `status`='payment' WHERE `exchanger_name`='exchanger1' AND `order_id`=:id AND `status`='processing' ",['id'=>$id]);
    }

    public function UpdateTimeOutFromId($id)
    {
        $this->db->SendSqlRequest("UPDATE `payments` SET `status`='timeout' WHERE `exchanger_name`='exchanger1' AND `order_id`=:id AND `status`='processing' ",['id'=>$id]);
    }

    public function PayDeliveryStatus($status,$id)
    {
        if ($status=="OK") {
            $this->db->SendSqlRequest("UPDATE `payments` SET `delivery`='delivered' WHERE `exchanger_name`='exchanger1' AND `order_id`=:id AND `delivery`='await' ",['id'=>$id]);
        }else{
            $this->db->SendSqlRequest("UPDATE `payments` SET `delivery`='first_resend' WHERE `exchanger_name`='exchanger1' AND `order_id`=:id AND `delivery`='await' ",['id'=>$id]);
        }
    }
}
