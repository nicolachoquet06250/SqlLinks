<?php

namespace sql_links\Entities\extended;

use sql_links\interfaces\IRequestConnexion;

class ExtendedRequestConnexion implements IRequestConnexion {

	public function __construct(array $idents) {
		foreach ($idents as $key => $ident) {
			$this->$key($ident);
		}
	}

	/**
	 * @param      $name
	 * @param bool $arguments
	 * @return bool
	 * @throws Exception
	 */
	public function __call($name, $arguments = false) {
		$vars = get_class_vars(get_class($this));
		if(isset($vars[$name])) {
			if(method_exists($this, $name)) {
				$this->$name($arguments);
			}
			else {
				if($arguments) {
					$this->$name = $arguments;
				}
				return $this->$name;
			}
		}
		else {
			if(method_exists($this, $name)) {
				$this->$name($arguments);
			}
			else {
				throw new Exception('Ni une propriété ni une méthode n\'existe de ce nom : '.$name.' !');
			}
		}
		return false;
	}
}