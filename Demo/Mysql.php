<?php
	require 'autoload.php';

	try {

		$cnx = new RequestConnexion(
			[
				'host' => 'mysql-nicolas-choquet.alwaysdata.net',
				'user' => '143175',
				'password' => '2669NICOLAS2107',
				'database' => 'nicolas-choquet_sociallinks'
			]
		);

		$mysql = Request::getIRequest($cnx);
		$mysql->select()->from('discussion')
						->where(['id>1'])
						->and()
						->where(['id<12'])
						->or()
						->where(['id' => 50]);
		echo $mysql->request()."\n";


	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}