<?php

$config = require_once(APP_PATH . '/_conf/config.php');

switch($config['bdd']['sgbd']):

	default:
	case('mysql'):
	
		return new PDO('mysql:host='. $config['bdd']['host'] . ';dbname=' . $config['bdd']['name'], $config['bdd']['user'], $config['bdd']['pass']);
		
	break;

endswitch;