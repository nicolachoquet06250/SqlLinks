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
	 * @param array $to_delete
	 * @return IRequest
	 */
	function delete(array $to_delete):IRequest ;

	/**
	 * @param array $to_update
	 * @return IRequest
	 */
	function update(array $to_update):IRequest ;

	/**
	 * @return IRequest
	 */
	function show():IRequest ;

	/**
	 * @param $table
	 * @return IRequest
	 */
	function create($table):IRequest ;

	/**
	 * @param $table
	 * @return IRequest
	 */
	function drop($table):IRequest ;

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
	 * @param $where
	 * @return IRequest
	 */
	function where($where):IRequest ;
	/**
	 * @return IRequest
	 */
	function whene():IRequest ;
	/**
	 * @return IRequest
	 */
	function like():IRequest ;

	/**
	 * @param int $limite
	 * @return IRequest
	 */
	function limit(int $limite):IRequest ;
	/**
	 * @return IRequest
	 */
	function has():IRequest ;
	/**
	 * @return IRequest
	 */
	function order_by():IRequest ;
	/**
	 * @return IRequest
	 */
	function group_by():IRequest ;
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
	 * @return IRequest
	 */
	function on():IRequest ;
	/**
	 * @return IRequest
	 */
	function in():IRequest ;
	/**
	 * @return IRequest
	 */
	function inner_join():IRequest ;
	/**
	 * @return IRequest
	 */
	function left_join():IRequest ;
	/**
	 * @return IRequest
	 */
	function right_join():IRequest ;
	/**
	 * @return string
	 */
	function last_request():string ;
	/**
	 * @return string
	 */
	function request():string ;
	/**
	 * @return array|boolean
	 */
	function query();
}