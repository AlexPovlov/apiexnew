<?php

namespace application\core;

use application\lib\Db;

use application\lib\exchangers\Exchanger1Api;
use application\lib\exchangers\Exchanger2Api;
use application\lib\exchangers\Exchanger3Api;
use application\lib\exchangers\ExApi;


abstract class Controller {

	protected $route;
	protected $model;

	protected $ExExchanger1Api;
	protected $ExExchanger2Api;
	protected $ExExchanger3Api;
	protected $ExApi;


	public function __construct($route) {
		$this->route = $route;
		$this->model = $this->loadModel($route['controller']);
		
		$TOKENS = require 'application/config/tokens.php';

        $this->ExExchanger1cApi = new Exchanger1Api($TOKENS['exchanger1']);
		$this->ExExchanger2Api = new Exchanger2Api($TOKENS['exchanger2']);
		$this->ExExchanger3Api = new Exchanger3Api($TOKENS['exchanger3']);
		$this->ExApi = new ExApi($TOKENS['exchanger4']);
	}

	public function loadModel($name) {
		$path = 'application\models\\'.ucfirst($name);
		if (class_exists($path)) {
			return new $path;
		}
	}


}