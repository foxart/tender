<?php

namespace tender\common\configurations;

use fa\classes\Configuration;

class AuthenticationHeadConfiguration extends Configuration {

	public static $map = [
		'css' => [
			'plugins' => [
				'bootstrap/bootstrap.css',
				'fa-bootstrap/bootstrap-theme.css',
				'fa/fa.css',
			],
			'themes' => [
				'css/markup.css',
			],
		],
		'js' => [
			'plugins' => [],
			'themes' => [],
		],
	];
}
