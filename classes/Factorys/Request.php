<?php

namespace sql_links\factories;

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
		if(is_file('../classes/Entities/Requests/'.$classe.'.php')) {
			require_once '../classes/Entities/Requests/'.$classe.'.php';
			if (class_exists($classe)) {
				self::$request = new $classe($connexion);
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