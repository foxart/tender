<?php

namespace tender\purchaser\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\common\modules\index\controllers\IndexController;
use tender\common\routes\AccountRoutes;
use tender\common\routes\AuthenticationRoutes;
use tender\common\routes\DefaultRoutes;
use tender\purchaser\configurations\DefaultHeadConfiguration;
use tender\purchaser\menus\PurchaserTopMenu;

class Routes extends Route {

	public static $map = [
		'/404' => [
			'route' => '/:path',
			'constraints' => [
				'path' => '.+',
			],
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
				'arguments' => [
					'template' => 'purchaserHtml.twig',
					'layout' => [
						'head' => [
							'controller' => Layout::class,
							'action' => 'outputHead',
							'arguments' => [
								'map' => DefaultHeadConfiguration::class,
							],
						],
						'account_badge' => [
							'controller' => AccountIndexController::class,
							'action' => 'outputAccountBadge',
						],
						'menu' => [
							'controller' => Layout::class,
							'action' => 'outputBootstrapMenu',
							'arguments' => [
								'map' => PurchaserTopMenu::class,
								'class' => 'nav navbar-nav navbar-right',
							],
						],
						'body' => [
							'controller' => IndexController::class,
							'action' => 'output404',
						],
					],
				],
			],
		],
	];

	public static function get($key = NULL) {
		$routes = [
			DefaultRoutes::class,
			AccountRoutes::class,
			AuthenticationRoutes::class,
			/* */
			PurchaserOverviewRoutes::class,
			PurchaserPoRoutes::class,
			PurchaserProfileRoutes::class,
			PurchaserRfqRoutes::class,
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
