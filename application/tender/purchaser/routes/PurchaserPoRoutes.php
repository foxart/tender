<?php

namespace tender\purchaser\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\purchaser\configurations\DefaultHeadConfiguration;
use tender\purchaser\menus\PurchaserTopMenu;
use tender\purchaser\modules\po\controllers\PoController;

class PurchaserPoRoutes extends Route {

	public static $map = [
		'/po' => [
			'route' => '/po',
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
							'controller' => PoController::class,
							'action' => 'actionPo',
						],
					],
				],
			],
			'children' => [
				'/list' => [
					'route' => '/list',
					'trigger' => [
						'controller' => PoController::class,
						'action' => 'actionIndex',
					],
				],
				'/delivery' => [
					'route' => '/delivery',
					'trigger' => [
						'controller' => PoController::class,
						'action' => 'actionDelivery',
					],
				],
				'/dispatch' => [
					'route' => '/dispatch',
					'trigger' => [
						'controller' => PoController::class,
						'action' => 'actionDispatch',
					],
				],
			],
		],
	];
}
