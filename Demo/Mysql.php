<?php
	require 'autoload.php';

	try {

		$cnx = new RequestConnexion([]);
		$cnx->debug();

		$mysql = Request::getIRequest($cnx);
/*		$mysql->select()->from('discussion')
						->where(['id>1'])
						->and()
						->where(['id<12'])
						->or()
						->where(['id' => 50]);*/
        $mysql->insert()->into('discussion')->values([['toto' => 'test', 'id' => 1], ['toto' => 'test 2', 'id' => 2]]);
		echo $mysql->request()."\n";


	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}