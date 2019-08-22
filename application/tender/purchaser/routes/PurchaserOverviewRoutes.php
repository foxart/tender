<?php

namespace tender\purchaser\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\purchaser\configurations\DefaultHeadConfiguration;
use tender\purchaser\menus\PurchaserTopMenu;
use tender\purchaser\modules\overview\controllers\OverviewController;

class PurchaserOverviewRoutes extends Route {

	public static $map = [
		'/' => [
			'route' => '/',
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
							'controller' => OverviewController::class,
							'action' => 'actionOverview',
						],
					],
				],
			],
		],
	];
}
