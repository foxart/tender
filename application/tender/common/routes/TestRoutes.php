<?php

namespace tender\common\routes;

use fa\classes\Layout;
use fa\classes\Route;

class TestRoutes extends Route {

	public static $map = [
		'/test' => [
			'route' => '/test',
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
			],
		],
	];
}
