<?php
	require_once 'autoload.php';

	try {
		$cnx = new RequestConnexion([
			'database' => __DIR__.'/database'
		], 'json');

		/**
		 * @var Json $jsondb
		 */
		$jsondb = Request::getIRequest($cnx, 'json');
		/**
		 * @Description: Install de la base de données de test
		 */
		$jsondb->create(Json::TABLE, 'user')
			   ->set([
					'id' => [
						'type' 		=> 'INT',
						'key' 		=> 'primary',
						'increment' => 'auto',
					],
					'nom' => [
						'type'		=> 'TEXT',
					],
					'prenom' => [
						'type' 		=> 'TEXT',
					],
					'age' => [
						'type' 		=> 'INT',
					],
					'ecole' => [
						'type'		=> 'TEXT',
						'default'	=> 'CampusID',
					],
				])->query();

		$jsondb->insert()
			   ->into('user')
			   ->values([[
			   		'nom' => 'Guignard',
					'prenom' => 'Jess',
					'age' => 20,
					'ecole' => null
				],[
				   'nom' => 'Choquet',
				   'prenom' => 'Nicolas',
				   'age' => 22,
				   'ecole' => 'CampusID'
			   ],[
			   		'nom' => 'Desplang',
					'prenom' => 'Christopher',
					'age' => 20,
					'ecole' => 'CampusID'
				]])->query();

		$result = $jsondb->select([
			'prenom' => 'prenom_person',
			'nom' => 'nom_person'
		])->from('user')->where(['ecole' => 'CampusID'])->query();

		var_dump($result);

		$response = $jsondb->drop(Json::TABLE, 'test')->query();

		if($response) {
			echo "ok\n";
		}
		else {
			echo "error\n";
		}
	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}