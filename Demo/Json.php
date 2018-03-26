<?php
	require_once 'autoload.php';

	try {
		$cnx = new RequestConnexion(['file' => './database'], 'json');
		$json = Request::getIRequest($cnx, 'json');
		$json->select();
		$json->query();
	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}