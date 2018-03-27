<?php

class Json implements IRequest
{
	private	$directory_database,
			$request_array = [],
			$last_request_array = [],
			$query_result = [],
			$last_query_result = false;

	private $read = false,
			$write = false;

	/**
	 * @Description : Methods
	 */
	public const CREATE = 'CREATE';
	public const SHOW = 'SHOW';
	public const SELECT = 'SELECT';
	public const INSERT = 'INSERT';
	public const DELETE = 'DELETE';
	public const DROP = 'DROP';
	public const UPDATE = 'UPDATE';
	public const ALTER = 'ALTER';

	/**
	 * @Description : For like() method
	 */
	public const START = 1;
	public const END = 2;
	public const MIDDLE = 3;

	/**
	 * @Description : logic operators
	 */
	public const AND = '&&';
	public const OR = '||';

	/**
	 * @Description : For create() method
	 */
	public const TABLE = 'table';
	public const DATABASE = 'database';

	/**
     * {@inheritdoc}
     */
    public function __construct(RequestConnexion $connexion) {
		$this->directory_database = $connexion->database()[0];

		if(!is_dir($this->directory_database)):
			mkdir($this->directory_database,0777, true);
		endif;
    }

    /**
     * {@inheritdoc}
     */
    function read()
    {
		$this->read = true;
		$this->write = false;
		$this->request_array = [];
    }

    /**
     * {@inheritdoc}
     */
    function write()
    {
        $this->write = true;
        $this->read = false;
        $this->request_array = [];
    }

    /**
     * {@inheritdoc}
     */
    function is_read(): bool
    {
        return $this->read;
    }

    /**
     * {@inheritdoc}
     */
    function is_write(): bool
    {
        return $this->write;
    }

    /**
     * {@inheritdoc}
     */
    function select(array $selected = []): IRequest
    {
    	$this->read();
    	$this->request_array['method'] = self::SELECT;
    	if(empty($selected)) {
    		$selected = '*';
		}
    	$this->request_array['selected'] = $selected;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function insert(): IRequest
    {
		$this->write();
		$this->request_array['method'] = self::INSERT;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function delete(): IRequest
    {
		$this->write();
		$this->request_array['method'] = self::DELETE;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function update(string $table): IRequest
    {
		$this->write();
		$this->request_array['method'] = self::UPDATE;
		$this->request_array['table'] = $table;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function show(): IRequest
    {
		$this->read();
		$this->request_array['method'] = self::SHOW;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function create($type, $name): IRequest
    {
		$this->write();
		$this->request_array['method'] = self::CREATE;
		$this->request_array['selected'] = $type;
		$this->request_array['name_created'] = $name;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function drop($type, $name): IRequest
    {
		$this->read();
		$this->request_array['method'] = self::DROP;
		$this->request_array['type'] = $type;
		$this->request_array['name_droped'] = $name;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function alter($table): IRequest
    {
		$this->read();
		$this->request_array['method'] = self::ALTER;
		$this->request_array['table'] = $table;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function tables(): IRequest
    {
        return $this;
    }

	/**
	 * @param array $array
	 * @return IRequest
	 */
	public function add(array $array) {
		$this->request_array['action'] = 'add';
		$this->request_array['set'] = $array;
		return $this;
	}

    /**
     * {@inheritdoc}
     */
    function databases($schemas = false): IRequest
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function columns(): IRequest
    {
    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    function into($table): IRequest
    {
		if(is_file($this->directory_database.'/'.$table.'.json')) {
			$this->request_array['table'] = $table;
		}
		else {
			throw new Exception('La table `'.$table.'` n\'existe pas.');
		}
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function from($table): IRequest
    {
    	if(is_file($this->directory_database.'/'.$table.'.json')) {
			$this->request_array['table'] = $table;
		}
        else {
			throw new Exception('La table `'.$table.'` n\'existe pas.');
		}
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function where($where): IRequest
    {
        $this->request_array['where'] = $where;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function like(array $array, int $place): IRequest
    {
        $this->request_array['like'] = [
        	$array,
			$place
		];
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function limit(int $limite, int $offset = 0): IRequest
    {
        $this->request_array['limit'] = $limite;
        if($offset !== 0) {
        	$this->request_array['offset'] = $offset;
		}
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function order_by($comumns): IRequest
    {
        $this->request_array['order_by'] = $comumns;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function group_by($comumns): IRequest
    {
        $this->request_array['group_by'] = $comumns;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function and (): IRequest
    {
        $this->request_array['operator'][] = self::AND;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function or (): IRequest
    {
		$this->request_array['operator'][] = self::OR;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function is_null(): IRequest
    {
        $this->request_array['is_null'] = true;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function is_not_null(): IRequest
    {
        $this->request_array['is_null'] = false;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function on($on): IRequest
    {
        $this->request_array['on'] = $on;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function in(array $array): IRequest
    {
        $this->request_array['in'] = $array;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function set(array $to_set): IRequest
    {
        $this->request_array['set'] = $to_set;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function inner_join($table): IRequest
    {
        $this->request_array['join'] = [
        	'table' => $table
		];
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function left_join($table): IRequest
    {
		$this->request_array['join'] = [
			'type' => 'left',
			'table' => $table
		];
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function right_join($table): IRequest
    {
		$this->request_array['join'] = [
			'type' => 'right',
			'table' => $table
		];
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function last_request(): array
    {
		return $this->last_request_array;
    }

    /**
     * {@inheritdoc}
     */
    function request(): array
    {
        return $this->request_array;
    }

    /**
     * {@inheritdoc}
     */
    function query()
    {
    	switch ($this->request_array['method']) {
			case self::ALTER	:
				$all_table = file_get_contents($this->directory_database.'/'.$this->request_array['table'].'.json');
				$all_table = json_decode($all_table);
				$header = $all_table->header;
				if($this->request_array['action'] === 'add') {
					foreach ($this->request_array['set'] as $item => $value) {
						$head = [
							'champ' => $item,
							'type' => $value['type']
						];
						if(isset($value['key'])) {
							$head['key'] = $value['key'];
						}
						if(isset($value['increment'])) {
							$head['autoincrement'] = true;
						}
						else {
							$head['autoincrement'] = false;
						}
						if(isset($value['default'])) {
							$head['default'] = $value['default'];
						}

						$header[] = $head;
					}

					$all_table->header = $header;

					$f = fopen($this->directory_database.'/'.$this->request_array['table'].'.json', 'w+');
					fwrite($f, json_encode($all_table));
					fclose($f);
					return true;
				}
				return false;
			case self::DROP		:
				unlink($this->directory_database.'/'.$this->request_array['name_droped'].'.json');
				if(is_file($this->directory_database.'/'.$this->request_array['name_droped'].'.json')) {
					return false;
				}
				return true;
			case self::CREATE	:
				if($this->request_array['selected'] === self::TABLE) {
					if (!file_exists($this->directory_database.'/'.$this->request_array['name_created'].'.json')) {
						$f = fopen($this->directory_database.'/'.$this->request_array['name_created'].'.json', 'w+');
						$tmp = [];
						foreach ($this->request_array['set'] as $item => $value) {
							$tmp[] = "{ \"champ\": \"{$item}\", \"type\": \"{$value['type']}\"".(isset($value['key']) ? ', "key": "'.$value['key'].'_key"' : '')."".(isset($value['increment']) ? ', "autoincrement": true' : ', "autoincrement": false')."".(isset($value['default']) ? ', "default": "'.$value['default'].'"' : '')." }";
						}

						fwrite($f, '{"header": ['.implode(', ', $tmp).'], "datas": []}');
						fclose($f);
					}
				}
				elseif ($this->request_array['selected'] === self::DATABASE) {
					throw new Exception('Vous utilisez déja une base de données');
				}
				return true;
			case self::INSERT	:
				$all_table = file_get_contents($this->directory_database.'/'.$this->request_array['table'].'.json');
				$all_table = json_decode($all_table);
				$header = $all_table->header;
				$datas = $all_table->datas;
				foreach ($header as $item) {
					if(isset($item->key) && $item->key == 'primary_key') {
						$champ = $item->champ;
						$last_id = $datas[count($datas)-1]->$champ;
						//throw new Exception('Le champ `'.$champ.'` est une clé unique !');
					}
				}
				$data = $this->request_array['values'];
				$datas[] = $data;
				$all_table->datas = $datas;

				$f = fopen($this->directory_database.'/'.$this->request_array['table'].'.json', 'w+');
				fwrite($f, json_encode($all_table));
				fclose($f);

				return true;
			case self::SHOW		:
				$directory = opendir($this->directory_database);
				$tmp = [];
				while (($dir = readdir($directory)) !== false) {
					if($dir != '.' && $dir != '..') {
						$tmp[] = str_replace('.json', '', $dir);
					}
				}

				return $tmp;
			case self::SELECT	:
				$all_table = file_get_contents($this->directory_database.'/'.$this->request_array['table'].'.json');
				$all_table = json_decode($all_table);

				return $all_table->datas;
			case self::DELETE	:
			case self::UPDATE	:
			default:
				break;
		}
    	$this->last_request_array = $this->request_array;
        var_dump($this->request_array);
    }

    /**
     * {@inheritdoc}
     */
    function values(array $values): IRequest
    {
        $this->request_array['values'] = $values;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    function get_last_query_result()
    {
        return $this->last_query_result;
    }

    /**
     * {@inheritdoc}
     */
    function get_query_result(): array
    {
        return $this->query_result;
    }

    /**
     * {@inheritdoc}
     */
    function asc(): IRequest
    {
        $this->request_array['order'] = 'asc';
    }

    /**
     * {@inheritdoc}
     */
    function desc(): IRequest
    {
        $this->request_array['order'] = 'desc';
    }
}