<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorTopMenu;
use tender\vendor\modules\overview\controllers\VendorOverviewIndexController;

class VendorOverviewRoutes extends Route {

	public static $map = [
		'/' => [
			'route' => '/',
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
							'controller' => VendorOverviewIndexController::class,
							'action' => 'actionIndex',
						],
					],
				],
			],
		],
	];
}
