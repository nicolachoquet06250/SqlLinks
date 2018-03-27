<?php

class PgsqlConnexion implements IRequestConnexion {

	private $host,
			$user,
			$password,
			$port;

	public function __construct(array $idents) {
		foreach ($idents as $key => $ident) {
			$this->$key($ident);
		}
		if(!isset($idents['port'])) {
			$this->port(5433);
		}
	}

	public function host($host=false) {
		if($host) {
			$this->host = $host;
		}
		return $this->host;
	}

	public function user($user=false) {
		if($user) {
			$this->user = $user;
		}
		return $this->user;
	}

	public function password($password=false) {
		if($password) {
			$this->password = $password;
		}
		return $this->password;
	}

	public function port($port=false) {
		if($port) {
			$this->port = $port;
		}
		return $this->port;
	}
}