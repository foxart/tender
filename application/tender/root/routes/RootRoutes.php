<?php

namespace tender\root\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\common\modules\index\controllers\IndexController;
use tender\common\routes\AuthenticationRoutes;
use tender\common\routes\DefaultRoutes;
use tender\root\configurations\DefaultHeadConfiguration;
use tender\root\menus\RootTopMenu;
use tender\root\modules\controllers\ImportController;
use tender\root\modules\controllers\MaintenanceController;

class RootRoutes extends Route {

	public static $map = [
		'/' => [
			'route' => '/',
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
				'arguments' => [
					'template' => 'rootHtml.twig',
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
							'controller' => RootTopMenu::class,
							'action' => 'outputBootstrapMenu',
							'arguments' => [
								'class' => 'nav navbar-nav navbar-right',
							],
						],
						'body' => [
							'controller' => MaintenanceController::class,
							'action' => 'actionHome',
						],
					],
				],
			],
		],
		'/maintenance' => [
			'route' => '/maintenance',
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
				'arguments' => [
					'template' => 'rootHtml.twig',
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
							'controller' => RootTopMenu::class,
							'action' => 'outputBootstrapMenu',
							'arguments' => [
								'class' => 'nav navbar-nav navbar-right',
							],
						],
						'body' => [
							'controller' => MaintenanceController::class,
							'action' => 'actionMaintenance',
						],
					],
				],
			],
			'children' => [
				'/badfiles' => [
					'route' => '/badfiles',
					'trigger' => [
						'controller' => MaintenanceController::class,
						'action' => 'actionBadFiles',
					],
				],
				'/delfiles' => [
					'route' => '/delfiles',
					'trigger' => [
						'controller' => MaintenanceController::class,
						'action' => 'actionRemoveFiles',
					],
				],
				'/emptydirs' => [
					'route' => '/emptydirs',
					'trigger' => [
						'controller' => MaintenanceController::class,
						'action' => 'actionGetEmptyDirs',
					],
				],
				'/deldirs' => [
					'route' => '/deldirs',
					'trigger' => [
						'controller' => MaintenanceController::class,
						'action' => 'actionRemoveEmptyDirs',
					],
				],
			],
		],
		'/import_geo' => [
			'route' => '/import_geo',
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
				'arguments' => [
					'template' => 'rootHtml.twig',
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
							'controller' => RootTopMenu::class,
							'action' => 'outputBootstrapMenu',
							'arguments' => [
								'class' => 'nav navbar-nav navbar-right',
							],
						],
						'body' => [
							'controller' => ImportController::class,
							'action' => 'actionImport',
						],
					],
				],
			],
			'children' => [
				'/compare' => [
					'route' => '/compare',
					'trigger' => [
						'controller' => ImportController::class,
						'action' => 'actionImportContinent',
					],
				],
				'/upload' => [
					'route' => '/upload',
					'trigger' => [
						'controller' => ImportController::class,
						'action' => 'actionImportUploadFile',
					],
				],
				'/stub' => [
					'route' => '/stub',
					'trigger' => [
						'controller' => ImportController::class,
						'action' => 'actionImportEmpty',
					],
				],
			],
		],
		/*
		 *
		 */
		'/404' => [
			'route' => '/:path',
			'constraints' => [
				'path' => '.+',
			],
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
				'arguments' => [
					'template' => 'rootHtml.twig',
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
							'controller' => RootTopMenu::class,
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
