<?php

return [

	'getexchangers' => [
		'controller' => 'get',
		'action' => 'getexchangers',
	],

	'getwallet' => [
		'controller' => 'get',
		'action' => 'getwallet',
	],

	'createpayment' => [
		'controller' => 'post',
		'action' => 'createpayment',
	],

	'setwallet' => [
		'controller' => 'post',
		'action' => 'setw',
	],

	'timeex' => [
		'controller' => 'cron',
		'action' => 'timeex',//по минутный крон сюда 
	],

	'timeexchanger4' => [
		'controller' => 'cron',
		'action' => 'timeexchanger4',//по минутный крон сюда
	],

	'ex/exchanger4' => [
		'controller' => 'exchanger4',
		'action' => 'callback_exchanger4',
	],

    'ex/ex' => [
		'controller' => 'ex',
		'action' => 'callback_ex',
	],

	'ex/exchanger3' => [
		'controller' => 'exchanger3',
		'action' => 'callback_exchanger3',//крон сюда 
	],

	
	'ex/exchanger2' => [
		'controller' => 'exchanger2',
		'action' => 'callback_exchanger2',//крон сюда 
	],

	
	'ex/exchanger2/paid' => [
		'controller' => 'exchanger2',
		'action' => 'setpaid',
	],

    'ex/exchanger1' => [
		'controller' => 'exchanger1',
		'action' => 'callback_exchanger1',
	],
	
];