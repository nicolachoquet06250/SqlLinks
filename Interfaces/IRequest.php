<?php

interface IRequest {
	/**
	 * IRequest constructor.
	 *
	 * @param RequestConnexion $connexion
	 */
	function __construct(RequestConnexion $connexion);

	/**
	 * @return void
	 */
	function read();

	/**
	 * @return void
	 */
	function write();

	/**
	 * @return boolean
	 */
	function is_read():bool ;

	/**
	 * @return boolean
	 */
	function is_write():bool ;

	/**
	 * @param array $selected
	 * @return IRequest
	 */
	function select(array $selected=[]):IRequest ;

	/**
	 * @return IRequest
	 */
	function insert():IRequest ;

	/**
	 * @return IRequest
	 */
	function delete():IRequest ;

	/**
	 * @param string $table
	 * @return IRequest
	 */
	function update(string $table):IRequest ;

	/**
	 * @return IRequest
	 */
	function show():IRequest ;

    /**
     * @param $type
     * @param $name
     * @return IRequest
     */
	function create($type, $name):IRequest ;

    /**
     * @param $type
     * @param $name
     * @return IRequest
     */
	function drop($type, $name):IRequest ;

	/**
	 * @param $table
	 * @return IRequest
	 */
	function alter($table):IRequest ;

	/**
	 * @return IRequest
	 */
	function tables():IRequest ;

	/**
	 * @param bool $schemas
	 * @return IRequest
	 */
	function databases($schemas=false):IRequest ;
	/**
	 * @return IRequest
	 */
	function columns():IRequest ;

	/**
	 * @param $table
	 * @return IRequest
	 */
	function into($table):IRequest ;
	/**
	 * @param $table
	 * @return IRequest
	 */
	function from($table):IRequest ;

	/**
	 * @param string|array|object $where
	 * @return IRequest
	 */
	function where($where):IRequest ;
	/**
     * @param array $array
     * @param int $place
	 * @return IRequest
	 */
	function like(array $array, int $place):IRequest ;

	/**
	 * @param int $limite
     * @param int $offset
	 * @return IRequest
	 */
	function limit(int $limite, int $offset=0):IRequest ;

    /**
     * @param $name
     * @param int $type
     * @return boolean
     */
	//function has($name, int $type):bool ;
	/**
     * @param array|string $comumns
	 * @return IRequest
	 */
	function order_by($comumns):IRequest ;
	/**
     * @param array|string $comumns
	 * @return IRequest
	 */
	function group_by($comumns):IRequest ;
	/**
	 * @return IRequest
	 */
	function and():IRequest ;
	/**
	 * @return IRequest
	 */
	function or():IRequest ;
	/**
	 * @return IRequest
	 */
	function is_null():IRequest ;
	/**
	 * @return IRequest
	 */
	function is_not_null():IRequest ;
	/**
     * @param string|array $on
	 * @return IRequest
	 */
	function on($on):IRequest ;

    /**
     * @param array $array
     * @return IRequest
     */
	function in(array $array):IRequest ;
    /**
     * @param array $to_set
     * @return IRequest
     */
	function set(array $to_set):IRequest;

    /**
     * @param array|string $table
     * @return IRequest
     */
	function inner_join($table):IRequest ;
	/**
     * @param array|string $table
	 * @return IRequest
	 */
	function left_join($table):IRequest ;
	/**
     * @param array|string $table
	 * @return IRequest
	 */
	function right_join($table):IRequest ;
	/**
	 * @return string
	 */
	function last_request() ;
	/**
	 * @return string
	 */
	function request() ;
	/**
	 * @return array|boolean
	 */
	function query();

    /**
     * @param array $values
     * @return IRequest
     */
	function values(array $values):IRequest;

    /**
     * @return array|boolean
     */
	function get_last_query_result() ;

    /**
     * @return array
     */
	function get_query_result():array ;

    /**
     * @return IRequest
     */
	function asc():IRequest;

    /**
     * @return IRequest
     */
	function desc():IRequest;
}