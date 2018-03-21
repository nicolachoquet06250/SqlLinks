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

		/*$mysql->select()->from('discussion')
						->where(['id>1'])
						->and()
						->where(['id<12']);

		echo $mysql->request()."\n";

        $mysql->query();

        var_dump('resultat 1');
        var_dump($mysql->get_query_result());

        $mysql->select(['libelle' => 'l'])->from('discussion')
              ->where(['id=1']);

        echo $mysql->request()."\n";

        $mysql->query();

        var_dump('resultat 2');
        var_dump($mysql->get_query_result());

        var_dump('2em resultat 1');
        var_dump($mysql->get_last_query_result());*/

       /* $mysql->delete()->from('discussion')->where('id > 1');

        echo $mysql->request()."\n";*/

        /*$mysql->update('discussion')->set(['libelle' => 'première discussion'])->where(['id' => 1]);
        echo $mysql->request()."\n";

        var_dump($mysql->query());*/

        //$mysql->select()->from('discussion')->inner_join('message')->on(['discussion.id' => 'message.id_discussion'])->limit(1);

        $mysql->select()->from(['discussion' => 'd'])
                        ->inner_join(['message' => 'm'])
                            ->on(['d.id' => 'm.id_discussion'])
                        ->where('')
                        ->like(['m.text' => 'co'], Mysql::START)
                        ->limit(1);

        echo $mysql->request()."\n";

        //$mysql->query();

        //var_dump($mysql->get_query_result());



	} catch (Exception $e) {
		exit($e->getMessage()."\n");
	}