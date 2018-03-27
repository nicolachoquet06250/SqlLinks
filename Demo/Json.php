<?php
	require_once 'autoload.php';

	try {
		$cnx = new RequestConnexion(['database' => './database'], 'json');
		$json = Request::getIRequest($cnx, 'json');
		$json->create(Json::TABLE, 'toto')->set([
			'id' => 'INT',
			'nom' => 'TEXT',
			'prenom' => 'TEXT',
			'age' => 'INT'
		]);
		$json->query();
		$json->select()->from('toto')->where(['id' => 0]);
		$json->query();
	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}