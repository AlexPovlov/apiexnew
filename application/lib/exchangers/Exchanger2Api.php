<?php

namespace application\lib\exchangers;

class Exchanger2Api{
    private $url = "";
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function createordercard($chat_id,$rub_sum,$walet,$paymethod)
    {
        $method = "createorder/".$paymethod;

        $param = [
            "key"=> $this->token,
            "currency"=> "RUB",
            "address"=> $walet,
            "sendcrypto" => "1",
            "value" => $rub_sum,
            "idfree"=> $chat_id,
            
        ];

        return $this->query($method,$param);
    }

    public function cancelorder($orderid)
    {
        $method = "cancelorder";

        $param = [
            "key"=> $this->token,
            "orderid"=> $orderid
        ];

        return $this->query($method,$param);
    }

    public function handleorder($orderidlist)
    {
       
        $method = "handleorder";

        $param = [
            "key"=> $this->token,
            "orderids"=> $orderidlist
        ];

        return $this->query($method,$param);
    }

    public function disputeorder($orderid,$reason,$urlphotoinvoice)
    {
        $method = "disputeorder";

        $param = [
            "key"=> $this->token,
            "orderid"=> $orderid,
            "reason"=> $reason,
            "urlphotoinvoice"=> $urlphotoinvoice
        ];

        return $this->query($method,$param);
    }

    public function listdispute()
    {
        $method = "listdispute";

        $param = [
            "key"=> $this->token
        ];

        return $this->query($method,$param);
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
