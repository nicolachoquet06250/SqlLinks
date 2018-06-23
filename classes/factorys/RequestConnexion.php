<?php

namespace sql_links\factories;
use \Exception;
use sql_links\interfaces\IRequestConnexion;

class RequestConnexion {
	private $cnx, $debug=false;

	/**
	 * RequestConnexion constructor.
	 *
	 * @param array  $cnx
	 * @param string $type
	 * @throws Exception
	 */
	function __construct(array $cnx, $type='mysql') {
		$classe = ucfirst($type).'Connexion';

		if(is_file('./custom/sql_links/classes/entities/connexions/'.$classe.'.php')) {
			require_once './custom/sql_links/classes/entities/connexions/'.$classe.'.php';
            $classe_to_instenciate = '\\sql_links\\Entities\\connexions\\'.$classe;
			if (class_exists($classe_to_instenciate)) {
				$this->cnx = new $classe_to_instenciate($cnx);
				if (!$this->cnx instanceof IRequestConnexion) {
					throw new Exception(ucfirst($type).' n\'est pas un type accepté.');
				}
			} else {
				throw new Exception('La classe '.$classe.' n\'existe pas.');
			}
		} else {
			throw new Exception('Le fichier '.$classe.'.php n\'existe pas.');
		}
	}

	/**
	 * @param      $name
	 * @param bool $arguments
	 * @return string|integer
	 * @throws Exception
	 */
	function __call($name, $arguments=false) {
	    if($name != 'debug' && $name != 'is_debug') {
            if ($this->cnx->$name()) {
                if ($arguments) {
                    $this->cnx->$name($arguments);
                }
                return $this->cnx->$name();
            }
            throw new Exception('La propriété ' . get_class($this->cnx) . '::$' . $name . ' n\'existe pas !');
        }
        else {
	        $this->$name();
        }
	}

    public function debug()
    {
        $this->debug = true;
    }
    public function is_debug() {
	    return $this->debug;
    }
}