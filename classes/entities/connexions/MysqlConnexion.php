<?php

namespace sql_links\Entities\connexions;

use \sql_links\Entities\extended\ExtendedRequestConnexion;

class MysqlConnexion extends ExtendedRequestConnexion {

	protected 	$host = '',
				$user = '',
				$password = '',
				$port = 3306,
				$database = '';
}