<?php

namespace tender\guest;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\configurations\AuthenticationHeadConfiguration;
use tender\common\modules\authentication\controllers\AuthenticationController;
use tender\common\routes\AuthenticationRoutes;
use tender\common\routes\DefaultRoutes;

class Routes extends Route {

	public static $map = [
		/* 404 */
		'/404' => [
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
								'map' => AuthenticationHeadConfiguration::class,
							],
						],
						'body' => [
							'controller' => AuthenticationController::class,
							'action' => 'actionSignIn',
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
