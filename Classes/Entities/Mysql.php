<?php

class Mysql implements IRequest {

	/**
	 * @var mysqli $mysqli
     * @var array $query_result
     * @var array$last_query_result
	 */
	private $mysqli,
			$last_request,
			$request,
			$read=false,
			$write=false,
			$cnx,
            $query_result,
            $last_query_result=false;

    public const START = 1;
	public const END = 2;
	public const MIDDLE = 3;

	public const TABLE = 1;
	public const DATABASE = 2;

    /**
     * {@inheritdoc}
     * @throws Exception
     */
	public function __construct(RequestConnexion $connexion) {
		$this->cnx = $connexion;
		if (class_exists('mysqli')) {
		    $is_debug = $connexion->is_debug();
		    if(!$is_debug) {
                $this->mysqli = new mysqli(
                    $connexion->host(),
                    $connexion->user(),
                    $connexion->password(),
                    $connexion->database()
                );
            }
            else {
		        $this->mysqli = false;
            }
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
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function delete():IRequest {
		$this->write();
		$this->request = 'DELETE ';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function update(string $table):IRequest {
		$this->write();
		$this->request = "UPDATE {$table} ";
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function show():IRequest {
		$this->read();
		$this->request = 'SHOW ';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function create($table):IRequest {
		$this->write();
		// TODO: Implement create() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function drop($table):IRequest {
		$this->write();
		// TODO: Implement drop() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function alter($table):IRequest {
		$this->write();
		// TODO: Implement alter() method.
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function into($table):IRequest {
		$this->request .= 'INTO `'.$table.'` ';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function from($table):IRequest {
	    if(gettype($table) === 'array') {
	        $tmp = [];
            foreach ($table as $item => $value) {
                if(gettype($item) === 'string') {
                    $tmp[] = "{$item} {$value}";
                }
                else {
                    $tmp[] = $value;
                }
	        }
	        $table = implode(', ', $tmp);
        }
		$this->request .= 'FROM '.$table.' ';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function where($where=''):IRequest {
        if(gettype($where) === 'array' || gettype($where) === 'object') {
            $tmp = [];
            foreach ($where as $key => $w) {
                if (gettype($key) === 'string') {
                    if (gettype($w) === 'string') {
                        $tmp[] = $key . '="' . $w . '"';
                    } else {
                        $tmp[] = $key . '=' . $w;
                    }
                } else {
                    $tmp[] = $w;
                }
            }
            if (!strstr($this->request(), 'WHERE')) {
                $this->request .= 'WHERE ';
            }
            $this->request .= implode(', ', $tmp) . ' ';
        }
        else {
            if (!strstr($this->request(), 'WHERE')) {
                $this->request .= 'WHERE ';
            }
            $this->request .= $where;
        }
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
	function set(array $to_set): IRequest
    {
        $tmp = [];
        foreach ($to_set as $item => $value) {
            $value = gettype($value) === 'string' ? "'{$value}'" : $value;

            $tmp[] = "`{$item}`={$value}";
        }
        $this->request .= 'SET '.implode(', ', $tmp).' ';
        return $this;
    }

    /**
	 * {@inheritdoc}
	 */
	function on($on):IRequest {
	    if(gettype($on) === 'array') {
            foreach ($on as $item => $value) {
                $on = "{$item} = {$value}";
                break;
	        }
        }
		$this->request .= "ON {$on} ";
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
	function inner_join($table):IRequest {
	    $this->request .= $this->join($table);
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function left_join($table):IRequest {
		$this->request .= $this->join($table, 'left');
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function right_join($table):IRequest {
        $this->request .= $this->join($table, 'right');
		return $this;
	}

    /**
     * @param $table
     * @param string $sence
     * @return string
     */
	private function join($table, $sence='inner') {
        if(gettype($table) === 'array') {
            foreach ($table as $item => $value) {
                $table = "{$item} {$value}";
                break;
            }
        }
	    $sence = strtoupper($sence);
	    return "{$sence} JOIN {$table} ";
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
	function like(array $array, int $place = self::MIDDLE):IRequest {
	    $champ = '';
	    $valeur = '';
        foreach ($array as $item => $value) {
            $champ = $item;
            $valeur = $value;
            break;
        }

	    $this->request .= "{$champ} LIKE ";

		switch ($place) {
            case self::START:
                $this->request .= "'{$valeur}%'";
                break;
            case self::MIDDLE:
                $this->request .= "'%{$valeur}%'";
                break;
            case self::END:
                $this->request .= "'%{$valeur}'";
                break;
            default:
                $this->request .= "'%{$valeur}%'";
                break;
        }
        $this->request .= ' ';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function limit(int $limite, int $offset=0):IRequest {
	    $this->request .= 'LIMIT ';
        if($offset !== 0) {
            $this->request .= $offset.', ';
        }
        $this->request .= $limite;
        return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function has($name, int $type = self::TABLE):bool{
		// TODO: Implémenter la méthode has() pour faire en sorte de savoir si une table ou une base de donnée existe.
	    return true;
	}

	/**
	 * {@inheritdoc}
	 */
	function order_by($columns):IRequest {
		if(gettype($columns) === 'array' || gettype($columns) === 'object') {
		    $columns = implode(', ', $columns);
        }
        if (!strstr($this->request(), 'ORDER BY')) {
            $this->request .= 'ORDER BY ';
        }
        else {
		    $this->request .= ', ';
        }
        $this->request .= $columns.' ';
        return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function group_by($columns):IRequest {
        if(gettype($columns) === 'array' || gettype($columns) === 'object') {
            $columns = implode(', ', $columns);
        }
        if (!strstr($this->request(), 'GROUP BY')) {
            $this->request .= 'GROUP BY ';
        }
        else {
            $this->request .= ', ';
        }
        $this->request .= $columns.' ';
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
        $this->request .= 'IS NULL';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function is_not_null():IRequest {
		$this->request .= 'IS NOT NULL';
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	function last_request():string {
		return $this->last_request;
	}

	/**
	 * {@inheritdoc}
	 */
	function request():string {
		return $this->request;
	}

	/**
	 * {@inheritdoc}
	 */
	function query() {
		$is_debug = $this->cnx->is_debug();
		if($is_debug) {
			return false;
		}
		if($this->is_read()) {
		    $req = $this->mysqli->query($this->request());
		    $result = [];
		    while ($data = $req->fetch_assoc()) {
		        $result[] = $data;
            }

            if($this->query_result === false) {
                $this->query_result = $result;
		    }
            else {
                $this->last_query_result = $this->query_result;
                $this->query_result = $result;
            }

		    return $this->query_result;
		}
		$this->last_request = $this->request;
		return $this->mysqli->query($this->request);
	}

    /**
     * {@inheritdoc}
     */
	function get_last_query_result() {
	    return $this->last_query_result;
    }

    /**
     * {@inheritdoc}
     */
    function get_query_result() :array {
	    return $this->query_result;
    }

	/**
     * {@inheritdoc}
     */
	function values(array $values): IRequest
    {
        $str = '(';
        $tmp = [];
        foreach ($values as $key => $val) {
            if(gettype($val) == 'array') {
            	foreach ($val as $item => $value) {
                    $tmp[] = '`'.$item.'`';
                }
                break;
            }
            else {
                $tmp[] = '`'.$key.'`';
            }

        }
        $str .= implode(', ', $tmp);
        $str .= ')';
        $str .= ' VALUES ';
        $tmp = [];
        $step1 = true;
        foreach ($values as $key => $val) {
            if(gettype($val) == 'array') {
                $step1 = true;
                $tmp2 = [];
                foreach ($val as $item => $value) {
                	$tmp2[] = gettype($value) == 'string' ? '"'.$value.'"' : $value;
                }
                $tmp[] = '('.implode(', ', $tmp2).')';
            }
            else {
                $step1 = false;
                $tmp[] = gettype($val) == 'string' ? '"'.$val.'"' : $val;
            }

        }
        if($step1) {
            $str .= ''.implode(', ', $tmp).'';
        }
        else {
            $str .= '('.implode(', ', $tmp).')';
        }

        $str .= '';
        $this->request .= $str;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function asc(): IRequest
    {
        $this->request .= 'ASC ';
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function desc(): IRequest
    {
        $this->request .= 'DESC ';
        return $this;
    }

    /**
     * @param $chaine
     * @return IRequest
     */
    public function md5($chaine):IRequest {
	    $this->request .= "MD5({$chaine}) ";
    }

    /**
     * @param $chaine
     * @return IRequest
     */
    public function sha1($chaine):IRequest {
        $this->request .= "SHA1({$chaine}) ";
    }
}