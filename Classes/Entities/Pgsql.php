<?php

class Pgsql implements IRequest {

	public function __construct(RequestConnexion $connexion) {
		echo 'je suis dans la classe Pgsql'."\n";
	}

	function select(array $selected=[]) {
		// TODO: Implement select() method.
	}

	function insert() {
		// TODO: Implement insert() method.
	}

	function delete(array $to_delete) {
		// TODO: Implement delete() method.
	}

	function update(array $to_update) {
		// TODO: Implement update() method.
	}

	function show() {
		// TODO: Implement show() method.
	}

	function from($table) {
		// TODO: Implement from() method.
	}

	function where($where) {
		// TODO: Implement where() method.
	}

	function whene() {
		// TODO: Implement whene() method.
	}

	function on() {
		// TODO: Implement on() method.
	}

	function in() {
		// TODO: Implement in() method.
	}

	function inner_join() {
		// TODO: Implement inner_join() method.
	}

	function left_join() {
		// TODO: Implement left_join() method.
	}

	function right_join() {
		// TODO: Implement right_join() method.
	}

	function tables() {
		// TODO: Implement tables() method.
	}

	function databases($schemas = false) {
		// TODO: Implement databases() method.
	}

	function columns() {
		// TODO: Implement columns() method.
	}

	function like() {
		// TODO: Implement like() method.
	}

	function limit(int $limite) {
		// TODO: Implement limit() method.
	}

	function has() {
		// TODO: Implement has() method.
	}

	function order_by() {
		// TODO: Implement order_by() method.
	}

	function group_by() {
		// TODO: Implement group_by() method.
	}

	function and () {
		// TODO: Implement and() method.
	}

	function or () {
		// TODO: Implement or() method.
	}

	function is_null() {
		// TODO: Implement is_null() method.
	}

	function is_not_null() {
		// TODO: Implement is_not_null() method.
	}

	function last_request() {
		// TODO: Implement last_request() method.
	}

	function request() {
		// TODO: Implement request() method.
	}

	function query() {
		// TODO: Implement query() method.
	}

	/**
	 * @param $table
	 * @return mixed
	 */
	function create($table) {
		// TODO: Implement create() method.
	}

	/**
	 * @param $table
	 * @return mixed
	 */
	function drop($table) {
		// TODO: Implement drop() method.
	}

	/**
	 * @param $table
	 * @return mixed
	 */
	function alter($table) {
		// TODO: Implement alter() method.
	}

	/**
	 * @param $table
	 * @return mixed
	 */
	function into($table) {
		// TODO: Implement into() method.
	}

	/**
	 * @return mixed
	 */
	function read() {
		// TODO: Implement read() method.
	}

	/**
	 * @return mixed
	 */
	function write() {
		// TODO: Implement write() method.
	}

	/**
	 * @return mixed
	 */
	function is_read() {
		// TODO: Implement is_read() method.
	}

	/**
	 * @return mixed
	 */
	function is_write() {
		// TODO: Implement is_write() method.
	}
}