<?php

class Json implements IRequest
{
	private	$directory_database,
			$request_array = [];

	private $read = false,
			$write = false;
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
        // TODO: Implement columns() method.
    }

    /**
     * {@inheritdoc}
     */
    function into($table): IRequest
    {
        // TODO: Implement into() method.
    }

    /**
     * {@inheritdoc}
     */
    function from($table): IRequest
    {
    	if(is_file($this->directory_database.'/'.$table)) {
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
        // TODO: Implement where() method.
    }

    /**
     * {@inheritdoc}
     */
    function like(array $array, int $place): IRequest
    {
        // TODO: Implement like() method.
    }

    /**
     * {@inheritdoc}
     */
    function limit(int $limite, int $offset = 0): IRequest
    {
        // TODO: Implement limit() method.
    }

    /**
     * {@inheritdoc}
     */
    function order_by($comumns): IRequest
    {
        // TODO: Implement order_by() method.
    }

    /**
     * {@inheritdoc}
     */
    function group_by($comumns): IRequest
    {
        // TODO: Implement group_by() method.
    }

    /**
     * {@inheritdoc}
     */
    function and (): IRequest
    {
        // TODO: Implement and() method.
    }

    /**
     * {@inheritdoc}
     */
    function or (): IRequest
    {
        // TODO: Implement or() method.
    }

    /**
     * {@inheritdoc}
     */
    function is_null(): IRequest
    {
        // TODO: Implement is_null() method.
    }

    /**
     * {@inheritdoc}
     */
    function is_not_null(): IRequest
    {
        // TODO: Implement is_not_null() method.
    }

    /**
     * {@inheritdoc}
     */
    function on($on): IRequest
    {
        // TODO: Implement on() method.
    }

    /**
     * {@inheritdoc}
     */
    function in(array $array): IRequest
    {
        // TODO: Implement in() method.
    }

    /**
     * {@inheritdoc}
     */
    function set(array $to_set): IRequest
    {
        // TODO: Implement set() method.
    }

    /**
     * {@inheritdoc}
     */
    function inner_join($table): IRequest
    {
        // TODO: Implement inner_join() method.
    }

    /**
     * {@inheritdoc}
     */
    function left_join($table): IRequest
    {
        // TODO: Implement left_join() method.
    }

    /**
     * {@inheritdoc}
     */
    function right_join($table): IRequest
    {
        // TODO: Implement right_join() method.
    }

    /**
     * {@inheritdoc}
     */
    function last_request(): string
    {
        // TODO: Implement last_request() method.
    }

    /**
     * {@inheritdoc}
     */
    function request(): string
    {
        // TODO: Implement request() method.
    }

    /**
     * {@inheritdoc}
     */
    function query()
    {
        var_dump($this->request_array);
    }

    /**
     * {@inheritdoc}
     */
    function values(array $values): IRequest
    {
        // TODO: Implement values() method.
    }

    /**
     * {@inheritdoc}
     */
    function get_last_query_result()
    {
        // TODO: Implement get_last_query_result() method.
    }

    /**
     * {@inheritdoc}
     */
    function get_query_result(): array
    {
        // TODO: Implement get_query_result() method.
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