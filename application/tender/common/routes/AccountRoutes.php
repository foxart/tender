<?php

namespace tender\common\routes;

use fa\classes\Layout;
use fa\classes\Route;
use fa\core\faf;
use tender\admin\configurations\DefaultHeadConfiguration as AdminDefaultHeadConfiguration;
use tender\admin\menus\AdminTopMenu;
use tender\common\modules\account\controllers\AccountEditController;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\purchaser\configurations\DefaultHeadConfiguration as PurchaserDefaultHeadConfiguration;
use tender\purchaser\menus\PurchaserTopMenu;
use tender\root\configurations\DefaultHeadConfiguration as RootDefaultHeadConfiguration;
use tender\root\menus\RootTopMenu;
use tender\vendor\configurations\DefaultHeadConfiguration as VendorDefaultHeadConfiguration;
use tender\vendor\menus\VendorTopMenu;

class AccountRoutes extends Route {

	public static $map = [
		'/account' => [
			'route' => '/account',
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
				'arguments' => [
					'template' => NULL,
					'layout' => [
						'head' => [
							'controller' => Layout::class,
							'action' => 'outputHead',
							'arguments' => [
								'map' => NULL,
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
								'map' => NULL,
								'class' => 'nav navbar-nav navbar-right',
							],
						],
						'body' => [
							'controller' => Layout::class,
							'action' => 'outputLayout',
							'arguments' => [
								'template' => 'application/tender/common/modules/account/templates/accountLayout.twig',
								'layout' => [
									'account' => [
										'controller' => AccountIndexController::class,
										'action' => 'actionAccount',
									],
								],
							],
						],
					],
				],
			],
		],
		'/account/ajax' => [
			'route' => '/ajax',
			'ajax' => TRUE,
			'trigger' => [
				'controller' => AccountIndexController::class,
				'action' => 'actionAccount',
			],
		],
		'/account/get' => [
			'route' => '/get',
			'trigger' => [
				'controller' => AccountEditController::class,
				'action' => 'actionAccountGet',
			],
		],
		'/account/add' => [
			'route' => '/add',
			'trigger' => [
				'controller' => AccountEditController::class,
				'action' => 'actionAccountAdd',
			],
		],
		'/account/update' => [
			'route' => '/update',
			'trigger' => [
				'controller' => AccountEditController::class,
				'action' => 'actionAccountUpdate',
			],
		],
	];

	public static function get($key = NULL) {
		$routes = self::$map;
		$session = faf::session()->get('account');
		if ($session['type'] === 'root') {
			$routes['/account']['trigger']['arguments']['template'] = 'rootHtml.twig';
			$routes['/account']['trigger']['arguments']['layout']['menu']['arguments']['map'] = RootTopMenu::class;
			$routes['/account']['trigger']['arguments']['layout']['head']['arguments']['map'] = RootDefaultHeadConfiguration::class;
		} elseif ($session['type'] === 'admin') {
			$routes['/account']['trigger']['arguments']['template'] = 'adminHtml.twig';
			$routes['/account']['trigger']['arguments']['layout']['menu']['arguments']['map'] = AdminTopMenu::class;
			$routes['/account']['trigger']['arguments']['layout']['head']['arguments']['map'] = AdminDefaultHeadConfiguration::class;
		} elseif ($session['type'] === 'purchaser') {
			$routes['/account']['trigger']['arguments']['template'] = 'purchaserHtml.twig';
			$routes['/account']['trigger']['arguments']['layout']['menu']['arguments']['map'] = PurchaserTopMenu::class;
			$routes['/account']['trigger']['arguments']['layout']['head']['arguments']['map'] = PurchaserDefaultHeadConfiguration::class;
		} elseif ($session['type'] === 'vendor') {
			$routes['/account']['trigger']['arguments']['template'] = 'vendorHtml.twig';
			$routes['/account']['trigger']['arguments']['layout']['menu']['arguments']['map'] = VendorTopMenu::class;
			$routes['/account']['trigger']['arguments']['layout']['head']['arguments']['map'] = VendorDefaultHeadConfiguration::class;
		}
//		dump($session);
//		dump($routes);
//		exit;
		return $routes;
	}
}
