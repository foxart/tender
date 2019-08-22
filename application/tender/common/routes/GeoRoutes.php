<?php

namespace tender\common\routes;

use fa\classes\Route;
use tender\common\modules\geo\controllers\GeoController;

class GeoRoutes extends Route {

	public static $map = [
		'/geo' => [
			'route' => '/geo',
			'behaviour' => 'virtual',
			'children' => [
				'/country' => [
					'route' => '/country',
					'trigger' => [
						'controller' => GeoController::class,
						'action' => 'actionCountry',
					],
				],
				'/region' => [
					'route' => '/region',
					'trigger' => [
						'controller' => GeoController::class,
						'action' => 'actionRegion',
					],
				],
				'/city' => [
					'route' => '/city',
					'trigger' => [
						'controller' => GeoController::class,
						'action' => 'actionCity',
					],
				],
			],
		],
	];
}
