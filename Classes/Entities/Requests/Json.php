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
     * {@inheritdoc}
     */
    public function __construct(RequestConnexion $connexion) {
		$this->directory_database = $connexion->file()[0];

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
    	$this->request_array['method'] = 'SELECT';
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
		$this->request_array['method'] = 'INSERT';
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function delete(): IRequest
    {
		$this->write();
		$this->request_array['method'] = 'DELETE';
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function update(string $table): IRequest
    {
		$this->write();
		$this->request_array['method'] = 'UPDATE';
		$this->request_array['table'] = $table;
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function show(): IRequest
    {
		$this->read();
		$this->request_array['method'] = 'SHOW';
		return $this;
    }

    /**
     * {@inheritdoc}
     */
    function create($type, $name): IRequest
    {
		$this->write();
		$this->request_array['method'] = 'CREATE';
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
		$this->request_array['method'] = 'DROP';
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
		$this->request_array['method'] = 'ALTER';
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
    }

    /**
     * {@inheritdoc}
     */
    function where($where): IRequest
    {
        $this->request_array['where'] = $where;
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
    }

    /**
     * {@inheritdoc}
     */
    function order_by($comumns): IRequest
    {
        $this->request_array['order_by'] = $comumns;
    }

    /**
     * {@inheritdoc}
     */
    function group_by($comumns): IRequest
    {
        $this->request_array['group_by'] = $comumns;
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
    	$this->last_request_array = $this->request_array;
        var_dump($this->request_array);
    }

    /**
     * {@inheritdoc}
     */
    function values(array $values): IRequest
    {
        $this->request_array['values'] = $values;
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