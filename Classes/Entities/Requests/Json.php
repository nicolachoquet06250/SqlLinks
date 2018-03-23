<?php

class Json implements IRequest
{

    /**
     * {@inheritdoc}
     */
    public function __construct(RequestConnexion $connexion)
    {
        parent::__construct($connexion);
    }

    /**
     * {@inheritdoc}
     */
    function read()
    {
        // TODO: Implement read() method.
    }

    /**
     * {@inheritdoc}
     */
    function write()
    {
        // TODO: Implement write() method.
    }

    /**
     * {@inheritdoc}
     */
    function is_read(): bool
    {
        // TODO: Implement is_read() method.
    }

    /**
     * {@inheritdoc}
     */
    function is_write(): bool
    {
        // TODO: Implement is_write() method.
    }

    /**
     * {@inheritdoc}
     */
    function select(array $selected = []): IRequest
    {
        // TODO: Implement select() method.
    }

    /**
     * {@inheritdoc}
     */
    function insert(): IRequest
    {
        // TODO: Implement insert() method.
    }

    /**
     * {@inheritdoc}
     */
    function delete(): IRequest
    {
        // TODO: Implement delete() method.
    }

    /**
     * {@inheritdoc}
     */
    function update(string $table): IRequest
    {
        // TODO: Implement update() method.
    }

    /**
     * {@inheritdoc}
     */
    function show(): IRequest
    {
        // TODO: Implement show() method.
    }

    /**
     * {@inheritdoc}
     */
    function create($type, $name): IRequest
    {
        // TODO: Implement create() method.
    }

    /**
     * {@inheritdoc}
     */
    function drop($type, $name): IRequest
    {
        // TODO: Implement drop() method.
    }

    /**
     * {@inheritdoc}
     */
    function alter($table): IRequest
    {
        // TODO: Implement alter() method.
    }

    /**
     * {@inheritdoc}
     */
    function tables(): IRequest
    {
        // TODO: Implement tables() method.
    }

    /**
     * {@inheritdoc}
     */
    function databases($schemas = false): IRequest
    {
        // TODO: Implement databases() method.
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
        // TODO: Implement from() method.
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
        // TODO: Implement query() method.
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
        // TODO: Implement asc() method.
    }

    /**
     * {@inheritdoc}
     */
    function desc(): IRequest
    {
        // TODO: Implement desc() method.
    }
}