<?php

namespace sql_links\factories;

use Exception;
use sql_links\interfaces\IRequest;

class Request {

	private static $request;
	private function __construct() {}

	/**
	 * @param RequestConnexion $connexion
	 * @param string           $type
	 * @return IRequest
	 * @throws Exception
	 */
	public static function getIRequest(RequestConnexion $connexion, $type='mysql') {
		$classe = ucfirst($type);
		if(is_file('./custom/sql_links/classes/entities/requests/'.$classe.'.php')) {
			require_once './custom/sql_links/classes/entities/requests/'.$classe.'.php';
			$classe_to_instenciate = '\\sql_links\\requests\\'.$classe;
			if (class_exists($classe_to_instenciate)) {
				self::$request = new $classe_to_instenciate($connexion);
				if (!self::$request instanceof IRequest) {
					throw new Exception(ucfirst($type).' n\'est pas un type accepté.');
				}
				return self::$request;
			} else {
				throw new Exception('La classe '.$classe.' n\'existe pas.');
			}
		}
		else {
			throw new Exception('Le fichier '.$classe.'.php n\'existe pas.');
		}
	}
}