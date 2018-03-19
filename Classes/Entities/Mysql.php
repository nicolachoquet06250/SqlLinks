<?php

class Mysql implements IRequest {

	private $mysqli,
			$last_request,
			$request,
			$read=false,
			$write=false;

	/**
	 * {@inheritdoc}
	 */
	public function __construct(RequestConnexion $connexion) {
		if (class_exists('mysqli')) {
			$this->mysqli = new mysqli(
				$connexion->host(),
				$connexion->user(),
				$connexion->password(),
				$connexion->database()
			);
		}
		else {
			throw new Exception('Vous devez installer l\'extension \'php-mysql\' !');
		}
	}

	/**
	 * {@inheritdoc}
	 */
	function write() {
		$this->read = false;
		$this->write = true;
	}

	/**
	 * {@inheritdoc}
	 */
	function read() {
		$this->read = true;
		$this->write = false;
	}

	/**
	 * {@inheritdoc}
	 */
	function is_write():bool {
		return $this->write;
	}

	/**
	 * {@inheritdoc}
	 */
	function is_read():bool {
		return $this->read;
	}

	/**
	 * {@inheritdoc}
	 */
	function select(array $selected = []):IRequest {
		$this->read();

		$this->request = 'SELECT ';
		if(empty($selected)) {
			$this->request .= '* ';
		}
		else {
			$tmp = [];
			foreach ($selected as $key => $select) {
				if(gettype($key) === 'string') {
					$tmp[] = $key.' as '.$select;
				}
				else {
					$tmp[] = $select;
				}
			}
			$this->request .= implode(', ', $tmp).' ';
		}
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function insert():IRequest {
		$this->write();
		$this->request = 'INSERT ';
	}

	/**
	 * {@inheritdoc}
	 */
	function delete(array $to_delete):IRequest {
		$this->write();
		// TODO: Implement delete() method.
	}

	/**
	 * {@inheritdoc}
	 */
	function update(array $to_update):IRequest {
		$this->write();
		// TODO: Implement update() method.
	}

	/**
	 * {@inheritdoc}
	 */
	function show():IRequest {
		$this->read();
		$this->request = 'SHOW ';
	}

	/**
	 * {@inheritdoc}
	 */
	function create($table):IRequest {
		$this->write();
		// TODO: Implement create() method.
	}

	/**
	 * {@inheritdoc}
	 */
	function drop($table):IRequest {
		$this->write();
		// TODO: Implement drop() method.
	}

	/**
	 * {@inheritdoc}
	 */
	function alter($table):IRequest {
		$this->write();
		// TODO: Implement alter() method.
	}

	/**
	 * {@inheritdoc}
	 */
	function into($table):IRequest {
		$this->request .= 'INTO `'.$table.'` ';
	}

	/**
	 * {@inheritdoc}
	 */
	function from($table):IRequest {
		$this->request .= 'FROM '.$table.' ';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function where($where):IRequest {
		$tmp = [];
		foreach ($where as $key => $w) {
			if(gettype($key) === 'string') {
				if (gettype($w) === 'string') {
					$tmp[] = $key.'="'.$w.'"';
				} else {
					$tmp[] = $key.'='.$w;
				}
			}
			else {
				$tmp[] = $w;
			}
		}
		if(!strstr($this->request(),'WHERE')) {
			$this->request .= 'WHERE ';
		}
		$this->request .= implode(', ', $tmp).' ';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function whene():IRequest {
		// TODO: Implement whene() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function on():IRequest {
		// TODO: Implement on() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function in():IRequest {
		// TODO: Implement in() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function inner_join():IRequest {
		// TODO: Implement inner_join() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function left_join():IRequest {
		// TODO: Implement left_join() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function right_join():IRequest {
		// TODO: Implement right_join() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function tables():IRequest {
		// TODO: Implement tables() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function databases($schemas = false):IRequest {
		// TODO: Implement databases() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function columns():IRequest {
		// TODO: Implement columns() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function like():IRequest {
		// TODO: Implement like() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function limit(int $limite):IRequest {
		// TODO: Implement limit() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function has():IRequest {
		// TODO: Implement has() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function order_by():IRequest {
		// TODO: Implement order_by() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function group_by():IRequest {
		// TODO: Implement group_by() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function and ():IRequest {
		$this->request .= 'AND ';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function or ():IRequest {
		$this->request .= 'OR ';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function is_null():IRequest {
		// TODO: Implement is_null() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function is_not_null():IRequest {
		// TODO: Implement is_not_null() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function last_request():string {
		// TODO: Implement last_request() method.
		return $this->last_request;
	}

	/**
	 * {@inheritdoc}
	 */
	function request():string {
		// TODO: Implement request() method.
		return $this->request;
	}

	/**
	 * {@inheritdoc}
	 */
	function query() {
		$this->mysqli->query($this->request);
		$this->last_request = $this->request;
		return true;
	}
}