<?php

class Auto {
	private function load($path = '.') {
		require_once $path.'/Interfaces/IRequest.php';
		require_once $path.'/Interfaces/IRequestConnexion.php';
		require_once $path.'/Classes/Factorys/RequestConnexion.php';
		require_once $path.'/Classes/Factorys/Request.php';
	}
}