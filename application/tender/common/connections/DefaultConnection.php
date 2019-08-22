<?php

namespace tender\common\connections;

use fa\classes\Connection;
use fa\core\faf;

final class DefaultConnection extends Connection {

	public static $map = [
		'development' => [
			'dms' => 'mysql',
			'connection' => [
//				'hostname' => 'localhost',
				'hostname' => '10.100.73.57',
				'database' => 'tender.foxart.org',
				'username' => 'tender',
				'password' => 'eU5dsg53HxOOIgtIPdaT',
				'charset' => 'utf8',
				'collation' => 'utf8_unicode_ci',
			],
			'options' => [
				'error' => 'warning',
				'fetch' => 'associative',
//				'nulls' => 'natural',
//				'case' => 'upper',
				'prepares' => 'true',
//				'prepares' => 'false',
				'timeout' => 5,
			],
		],
		'production' => [
			'dms' => 'mysql',
			'connection' => [
				'hostname' => 'localhost',
				'database' => 'tender.foxart.org',
				'username' => 'root',
				'password' => 'eU5dsg53HxOOIgtIPdaT',
				'charset' => 'utf8',
				'collation' => 'utf8_unicode_ci',
			],
			'options' => [
				'error' => 'warning',
				'fetch' => 'associative',
//				'nulls' => 'natural',
//				'case' => 'upper',
				'prepares' => 'true',
//				'prepares' => 'false',
				'timeout' => 5,
			],
		],
	];

	public static function get($key = NULL) {
		if (faf::server()->getIp() === '127.0.0.1') {
			$result = parent::get('development');
		} else {
			$result = parent::get('production');
		};

		return $result;
	}
}
