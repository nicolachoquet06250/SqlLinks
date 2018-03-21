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
		//$cnx->debug();

		$mysql = Request::getIRequest($cnx);
/*		$mysql->select()->from('discussion')
						->where(['id>1'])
						->and()
						->where(['id<12'])
						->or()
						->where(['id' => 50]);*/
        $mysql->insert()->into('discussion')->values([['libelle' => 'seconde discussion'], ['libelle' => '3em discussion']]);
		echo $mysql->request()."\n";
		var_dump($mysql->query());


	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}