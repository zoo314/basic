<?php

try {
	
	$pdo = include_once(APP_PATH . '/_conf/connector.php');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $pdo;
	
} catch (PDOException $e) {

	die('Connexion échouée : ' . $e->getMessage());
}