<?php

namespace tender\admin\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\admin\configurations\DefaultHeadConfiguration;
use tender\admin\menus\AdminTopMenu;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\common\modules\index\controllers\IndexController;
use tender\common\routes\AuthenticationRoutes;
use tender\common\routes\DefaultRoutes;

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
					'template' => 'adminHtml.twig',
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
								'map' => AdminTopMenu::class,
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
			\tender\common\routes\AccountRoutes::class,
			AuthenticationRoutes::class,
			/* */
			AdminMaterialRoutes::class,
			OverviewRoutes::class,
			SettingRoutes::class,
			AccountRoutes::class,
			AccountAdminRoutes::class,
			AccountPurchaserRoutes::class,
			AccountPurchaserCompanyRoutes::class,
			AccountVendorRoutes::class,
			TreeRoutes::class,
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
