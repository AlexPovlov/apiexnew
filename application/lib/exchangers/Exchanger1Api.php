<?php

namespace application\lib\exchangers;

class Exchanger1Api {

    private $url = "";
    private $apiKey ;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    private function query($metod,$param=null){

        $head = array("Content-Type: application/x-www-form-urlencoded","Authorization: Api-Key ".$this->apiKey);

        $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $this->url.$metod."/");
            curl_setopt($handle, CURLOPT_HEADER, 0);
            curl_setopt($handle, CURLOPT_POST, 1);
            curl_setopt($handle, CURLOPT_HTTPHEADER, $head);   
            
            if($param != null){
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($param));
            }
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
                
            $result = curl_exec($handle);
            $results = json_decode($result,true);
            
            foreach($results as $key => $res){
                if ($res == "success" or $res == "Не работает") {
                    unset($results[$key]);
                 }
            }
           
            curl_close($handle);

            
            return $results;
            
    }

    public function client_payment_types(){
        return $this->query("client_payment_types");
    }

    public function create_order($rub_sum,$wallet)
    {
        $param = ['payment_type' => 'tinkoff', 'rub_sum' => $rub_sum ,'cryptocurrency'=>'BTC', 'cryptocurrency_wallet'=>$wallet];
        return $this->query(__FUNCTION__,$param);
    }

    public function ballance()
    {
        return $this->query("ballance");
    }

    public function orders()
    {
        $do = date("d.m.y", mktime(0, 0, 0, date('m'), date('d') - 1, date('y')))."00:00:00";
        $today = date("d.m.y")." 23:00:00";
        $param = ['start_datetime' => "01.06.2021 00:00:00"  , 'end_datetime'=> "01.10.2021 00:00:00" ];
        return $this->query(__FUNCTION__,$param);
    }

    
}






