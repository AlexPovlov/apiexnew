<?php

namespace application\models;

use application\core\Model;


class Cron extends Model
{
    public function GetAllProcessingPayIdExchanger1()
    {
        return $this->db->GetAllSqlRequest("SELECT `order_id`,`date` FROM `payments` WHERE `exchanger_name`='exchanger1' AND `status`='processing' ",[]);
    }

    public function GetAllProcessingPayIdEx()
    {
        return $this->db->GetAllSqlRequest("SELECT `order_id`,`date` FROM `payments` WHERE `exchanger_name`='exchanger' AND `status`='processing' ",[]);
    }

    public function UpdateTimeOutFromId($id)
    {
        $this->db->SendSqlRequest("UPDATE `payments` SET `status`='timeout' WHERE `order_id`=:id AND `status`='processing' ",['id'=>$id]);
    }

}
