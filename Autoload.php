<?php

class Auto {
	public static function load($path = '.') {
		require_once 'Interfaces/IRequest.php';
		require_once 'Interfaces/IRequestConnexion.php';
		require_once 'Classes/Entities/Extended/ExtendedRequestConnexion.php';
		require_once 'Classes/Entities/Extended/DatabaseFiles.php';
		require_once 'Classes/Factorys/RequestConnexion.php';
		require_once 'Classes/Factorys/Request.php';
	}
}