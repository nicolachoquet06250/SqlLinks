<?php
	require 'autoload.php';

	try {

		$cnx = new RequestConnexion([
				'host' => 'mysql-nicolas-choquet.alwaysdata.net',
				'user' => '143175',
				'password' => '2669NICOLAS2107',
				'database' => 'nicolas-choquet_sociallinks'
			]);
		//$cnx->debug();

		$mysql = Request::getIRequest($cnx);

        $mysql->select()->from(['discussion' => 'd'])
                        ->left_join(['message' => 'm'])
                            ->on(['d.id' => 'm.id_discussion'])
                        ->where('')
                        ->like(['m.text' => 'co'], Mysql::START)
                        ->limit(1);

        echo $mysql->request()."\n";

        $mysql->query();

        var_dump($mysql->get_query_result());


	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}