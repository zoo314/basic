<?php

spl_autoload_register(function($class) {
	include_once(APP_PATH . '/_classes/' . $class . '.php');
});