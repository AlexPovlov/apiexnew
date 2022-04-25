<?php

namespace application\core;

use application\lib\Db;

abstract class Model{

	protected $db;
	
	public function __construct() {
		$this->db = new Db;
		
	}

    public function query($url,$param = null)
    {
        $head = array("Content-Type: application/json","Authorization: ".$this->key);

        $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_HEADER, 0);
            curl_setopt($handle, CURLOPT_POST, 1);
            curl_setopt($handle, CURLOPT_HTTPHEADER, $head);   
            
            if($param != null){
                $param = json_encode($param);
                curl_setopt($handle, CURLOPT_POSTFIELDS, $param);
            }
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
                
            $result = curl_exec($handle);
            $results = json_decode($result,true);
           
            curl_close($handle);
           
            return $results;
    }

}