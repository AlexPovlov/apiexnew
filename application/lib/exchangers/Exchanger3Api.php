<?php

namespace application\lib\exchangers;

class Exchanger3Api{
    private $url = "";
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function newOrder($sum,$walet)
    {
        $param = [
            "token"=> $this->token,
            "currency"=> "BTC",
            "category"=>"BUY",
            "address"=> $walet,
            "amount" => $sum
        ];

        return $this->query(__FUNCTION__,$param);
    }

    public function cancelOrder($orderid)
    {
       
        $param = [
            "token"=> $this->token,
            "id"=> $orderid
        ];

        return $this->query(__FUNCTION__,$param);
    }

    public function checkOrders($orderidlist)
    {
    
        $param = [
            "token"=> $this->token,
            "ids"=> $orderidlist
        ];

        return $this->query(__FUNCTION__,$param);
    }

    public function query($method,$param=null){

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $this->url.$method);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);        
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));   
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($param));         
        

        $result = curl_exec($handle);
        $result = json_decode($result,true);

        return $result;
    }
}
