<?php

namespace application\models;

use application\core\ModelPartner;
use application\lib\CoinMarketApi;


class Post extends ModelPartner
{
    public function getdetails($exchanger,$amount,$user_id,$url)
    {

            
    }

    public function getavailableexchangers($exchanger)
    {
       return $this->db->GetOneSqlRequest("SELECT * FROM `exchangers` WHERE `title`=:nam AND `on_off`='1' ",['nam'=>$exchanger]);

    }

    public function getpartnerwallet()
    {
        return $this->db->GetOneSqlRequest("SELECT `btc_walet` FROM `partners` WHERE `id`=:id",['id'=>$this->partner_id])['btc_walet'];
    }

    public function InsertPay($user_id,$exchanger_name,$order_id,$amount_rub,$bank,$requisites,$cryptocurrency,$amount_crypto,$url)
    {
        $params = [
            'partner_id'=>$this->partner_id,
            'userid'=>$user_id,
            'exchanger_name'=>$exchanger_name,
            'order_id'=>$order_id,
            'amount_rub'=>$amount_rub,
            'bank'=>$bank,
            'requisites'=>$requisites,
            'cryptocurrency'=>$cryptocurrency,
            'amount_crypto'=>$amount_crypto,
            'urla'=>$url
            ];

        if(!empty($order_id)){
        $this->db->SendSqlRequest("INSERT INTO `payments` (`partner_id`, `user_id`, `exchanger_name`, `order_id`, `amount_rub`, `bank`, `requisites`, `cryptocurrency`, `amount_crypto`, `status`, `url`) 
        VALUES (:partner_id,:userid,:exchanger_name,:order_id,:amount_rub,:bank,:requisites,:cryptocurrency,:amount_crypto,'processing',:urla)",$params);
        }
    }

    private function BtcExchenger4($amount)
    {
        $coinmarketapi = new CoinMarketApi('1ce95cbc-715a-4086-85cd-d00a0700b511');

        $cryptocurrency_data = $coinmarketapi->get_course('BTC','RUB');

        $course = $cryptocurrency_data['data']['BTC']['quote']['RUB']['price'];

        $cryptocurrency_amount = $amount/$course;
        $exchanger_percentage = $cryptocurrency_amount * 0.1;
        $final_amount_cryptocurrency = $cryptocurrency_amount - $exchanger_percentage;

        return $final_amount_cryptocurrency;
    }

    public function set($wallet)
    {
        
        $this->db->SendSqlRequest("UPDATE `partners` SET `btc_walet`=:bwalet WHERE `id`=:id",['bwalet'=>$wallet,'id'=>$this->partner_id]);
        
    }
}
