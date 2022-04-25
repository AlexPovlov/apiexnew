<?php

namespace application\core;

use application\lib\Db;

abstract class ModelPartner {

	protected $db;
	protected $access = false;
    protected $partner_id;
	
	public function __construct() {
		$this->db = new Db;
		$headers = getallheaders();
        
        $partners = $this->db->GetAllSqlRequest("SELECT `id`,`token` FROM `partners` ",[]);

        foreach ($partners as $key => $partner) {
           
            if (password_verify($headers['Authorization'],$partner['token'])) {
              
                $this->partner_id = $partner['id'];
                
                break;
            }else {
                $this->partner_id = "";				
            }
        }

        if (empty($this->partner_id)) {
            exit();
        }
	}

}