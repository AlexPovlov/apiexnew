<?php

namespace application\lib\exchangers;

class ExApi{
    private $url = "";
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function create_order($chat_id,$rub_sum,$walet)
    {
        $param = [
            "partner_id"=> $this->token,
            "payment_type"=> "CARD",
            "user_id"=> $chat_id,
            "currency" => "RUB",
            "crypto_currency" => "BTC",
            "amount"=> $rub_sum,
            "webhook"=> 'https://'.$_SERVER['HTTP_HOST']."/ex/ex",
            "wallet"=> $walet
        ];

        return $this->query($param);
    }

    public function get_stat()
    {
        $param = [
            'partner_id' => $this->token
        ];

        return $this->query($param);
    }

    private function query($param=null){

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $this->url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($handle, CURLOPT_HEADER, 0);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));   
        if($param != null){
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($param));         
        }

        $result = curl_exec($handle);
        $result = json_decode($result,true);

        foreach($result as $key => $res){
            if ($res === "success" or $res === "Не работает") {
                unset($result[$key]);
             }
        }
       

        curl_close($handle);
        
        return $result;
}
}

