<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\common\modules\index\controllers\IndexController;
use tender\common\routes\AccountRoutes;
use tender\common\routes\AuthenticationRoutes;
use tender\common\routes\DefaultRoutes;
use tender\common\routes\GeoRoutes;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorTopMenu;

class Routes extends Route {

	public static $map = [
		'/files/vendor' => [
			'route' => '/files/vendor/:file',
			'constraints' => [
				'file' => '.+[.].{2,3}',
			],
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputFile',
			],
		],
		'/404' => [
			'route' => '/:path',
			'constraints' => [
				'path' => '.+',
			],
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
				'arguments' => [
					'template' => 'vendorHtml.twig',
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
							'controller' => VendorTopMenu::class,
							'action' => 'outputBootstrapMenu',
							'arguments' => [
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
			/* common */
			DefaultRoutes::class,
			AccountRoutes::class,
			AuthenticationRoutes::class,
			GeoRoutes::class,
			/* overview */
			VendorOverviewRoutes::class,
			/* po */
			VendorPoRoutes::class,
			/* rfq */
			VendorRfqRoutes::class,
			/* profile */
			VendorProfileBankRoutes::class,
			VendorProfileCompanyRoutes::class,
			VendorProfileContactRoutes::class,
			VendorProfileDetailRoutes::class,
			VendorProfileExciseRoutes::class,
			VendorProfileFactoryRoutes::class,
			VendorProfileLegalRoutes::class,
			VendorProfileMaterialRoutes::class,
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
