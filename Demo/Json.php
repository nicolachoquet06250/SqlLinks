<?php
	require_once 'autoload.php';

	try {
		$cnx = new RequestConnexion(['database' => './database'], 'json');

		/**
		 * @var Json $jsondb
		 */
		$jsondb = Request::getIRequest($cnx, 'json');
		/**
		 * @Description: Install de la base de données de test
		 */
		$jsondb->create(Json::TABLE, 'toto')
			   ->set([
					'id' => [
						'type' 		=> 'INT',
						'key' 		=> 'primary',
						'increment' => 'auto'
					],
					'nom' => [
						'type'		=> 'TEXT'
					],
					'prenom' => [
						'type' 		=> 'TEXT'
					],
					'age' => [
						'type' 		=> 'INT'
					]
				]);
		$jsondb->query();

		$jsondb->alter('toto')->add(['ecole' => ['type' => 'TEXT', 'default' => 'CampusID']])->query();
		var_dump($jsondb->decode('{"test": "voila"}'));

		/*$jsondb->show()->tables();

		var_dump($jsondb->query());*/

		/*var_dump($jsondb->select()->from('toto')->query());*/
		//var_dump($jsondb->drop(Json::TABLE, 'toto')->query());

		/*$jsondb->insert()
			   ->into('toto')
			   ->values([
			   		'id' => 2,
					'nom' => 'Choquet',
					'prenom' => 'Yann',
					'age' => 20
				]);
		$jsondb->query();*/
		/*$jsondb->select()->from('toto')->where(['id' => 0]);
		$jsondb->query();*/
	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}