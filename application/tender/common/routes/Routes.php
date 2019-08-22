<?php

namespace tender\common\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\configurations\DefaultHeadConfiguration;
use tender\common\modules\index\controllers\IndexController;

class Routes extends Route {

	public static $map = [
		/* 403 */
		'/403' => [
			'route' => '/[:path]',
			'constraints' => [
				'path' => '.+',
			],
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
				'arguments' => [
					'template' => 'application/tender/common/modules/authentication/templates/authenticationHtml.twig',
					'layout' => [
						'head' => [
							'controller' => Layout::class,
							'action' => 'outputHead',
							'arguments' => [
								'map' => DefaultHeadConfiguration::class,
							],
						],
						'body' => [
							'controller' => IndexController::class,
							'action' => 'output403',
						],
					],
				],
			],
		],
	];

	public static function get($key = NULL) {
		$routes = [
			DefaultRoutes::class,
			AuthenticationRoutes::class,
		];
		/**
		 * @type Route $route
		 */
		$result = array();
		foreach ($routes as $route) {
			$result = $result + $route::get();
		}
		$result = $result + self::$map;

		return $result;
	}
}
