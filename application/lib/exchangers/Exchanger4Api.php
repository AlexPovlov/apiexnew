<?php

namespace application\lib\exchangers;

class Exchanger4Api
{
    private $url = "";
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    private function query($metod,$param=null){

        $head = array("Content-Type: application/x-www-form-urlencoded");

        $handle = curl_init();
        $param = array_merge($param,['token'=>$this->apiKey]);

        $url = $this->url.$metod."?".http_build_query($param);

            curl_setopt($handle, CURLOPT_URL,  $url);
            curl_setopt($handle, CURLOPT_HEADER, 0);
            //curl_setopt($handle, CURLOPT_POST, 1);
            curl_setopt($handle, CURLOPT_HTTPHEADER, $head);  

            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
                
            $result = curl_exec($handle);
            $results = json_decode($result,true);
           
            curl_close($handle);
            //var_dump($result);
            return $results;
            
    }

    public function request($user,$amount)
    {
        $param = ['user'=>$user,'amount'=>$amount];
        $metod = "/Invoice/request";
        return $this->query($metod,$param);
    }

    public function setwebhook($url)
    {
        $param = ['url'=>$url];
        $metod = "/Settings/setwebhook";
        return $this->query($metod,$param);
    }

}
