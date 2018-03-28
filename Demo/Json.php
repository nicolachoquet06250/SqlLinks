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

		//$jsondb->alter('toto')->add(['ecole' => ['type' => 'TEXT', 'default' => 'CampusID']])->query();

		/*$jsondb->show()->tables();

		var_dump($jsondb->query());*/

		/*var_dump($jsondb->select()->from('toto')->query());*/
		//var_dump($jsondb->drop(Json::TABLE, 'toto')->query());

		/*$jsondb->insert()
			   ->into('toto')
			   ->values([[
			   		'nom' => 'Choquet',
					'prenom' => 'Yann',
					'age' => 20,
					'ecole' => null
				],[
			   		'nom' => 'Loubet',
					'prenom' => 'Karine',
					'age' => 45,
					'ecole' => null
				], [
				   'nom' => 'Choquet',
				   'prenom' => 'Nicolas',
				   'age' => 22,
				   'ecole' => 'CampusID'
			   ]]);
		$jsondb->query();*/

		//$jsondb->delete()->from('toto')->where(['id' => 0, 'nom' => 'Choquet']);

		/*$jsondb->update('toto')->set(['prenom' => 'André'])->where(['nom' => 'Loubet']);
		$jsondb->query();*/
		$jsondb->select(['id' => 'id_person', 'nom' => 'nom_person'])->from('toto')->where(['id' => 1]);
		$jsondb->query();
	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}