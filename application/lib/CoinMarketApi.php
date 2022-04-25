<?php

namespace application\lib;

class CoinMarketApi
{

    private $url = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest";
    private $apiKey ;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    private function query($param=null){

        $head = array("Accepts: application/json","X-CMC_PRO_API_KEY: ".$this->apiKey);

        $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $this->url."?".http_build_query($param));
            curl_setopt($handle, CURLOPT_HEADER, 0);
            curl_setopt($handle, CURLOPT_HTTPHEADER, $head);   
            
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
                
            $result = curl_exec($handle);
            $results = json_decode($result,true);

            curl_close($handle);

            return $results;
            
    }

    public function get_course($crypto_currency,$currency){
        $params = ['symbol'=>$crypto_currency,'convert'=>$currency];
        return $this->query($params);
    }
}
