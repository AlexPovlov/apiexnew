<?php

namespace application\lib;

use PDO;

class Db
{
    protected $db;
    private $CHARSET = 'utf8';
    private $PDO_OPTIONS = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];

    function __construct() {
        $config = require 'application/config/db.php';
		$this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['name'].';charset='.$this->CHARSET.'', $config['user'], $config['password'],$this->PDO_OPTIONS);
    }

    private function dbCheckError($query){
        $errInfo = $query->errorInfo();
        if ($errInfo[0] !== PDO::ERR_NONE){
            echo $errInfo[2];
            exit();
        }
        return true;
    }

    public function SendSqlRequest($sql,$params=[])
    {
        $query = $this->db->prepare($sql);

        $result = $query->execute($params);
        $this->dbCheckError($query);
    }

    public function GetAllSqlRequest($sql,$params=[])
    {
        $query = $this->db->prepare($sql);

        $query->execute($params);
        $this->dbCheckError($query);
        
        return $query->fetchAll();
    }

    public function GetOneSqlRequest($sql,$params=[])
    {
        $query = $this->db->prepare($sql);

        $query->execute($params);
        $this->dbCheckError($query);
        return $query->fetch();
    }
}
