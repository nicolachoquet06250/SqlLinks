<?php
	require 'autoload.php';

	try {

		$cnx = new RequestConnexion(
			[
				'host' => 'pgsql-nicolas-choquet.alwaysdata.net',
				'user' => '',
				'password' => '2669NICOLAS2107'
			],
			'pgsql'
		);

		$mysql = Request::getIRequest($cnx, 'pgsql');
		$mysql->select()->from('discussion')->where(['id' => 1]);
		echo $mysql->request()."\n";


	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}