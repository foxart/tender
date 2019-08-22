<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorCompanyItemMenu;
use tender\vendor\menus\VendorTopMenu;
use tender\vendor\modules\company\controllers\CompanyIndexController;
use tender\vendor\modules\factory\controllers\FactoryEditController;
use tender\vendor\modules\factory\controllers\FactoryIndexController;

class VendorProfileFactoryRoutes extends Route {

	public static $map = [
		'/company/company-id/factory' => [
			'route' => '/company/:company/factory',
			'ajax' => FALSE,
			'constraints' => [
				'company' => '[0-9]+',
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
							'controller' => Layout::class,
							'action' => 'outputBootstrapMenu',
							'arguments' => [
								'map' => VendorTopMenu::class,
								'class' => 'nav navbar-nav navbar-right',
							],
						],
						'body' => [
							'controller' => Layout::class,
							'action' => 'outputLayout',
							'arguments' => [
								'template' => 'vendorProfileItemStructure.twig',
								'layout' => [
									'company_list_menu' => [
										'controller' => CompanyIndexController::class,
										'action' => 'companyListMenu',
									],
									'company_item_menu' => [
										'controller' => Layout::class,
										'action' => 'outputBootstrapMenu',
										'arguments' => [
											'map' => VendorCompanyItemMenu::class,
											'class' => 'nav nav-tabs',
										],
									],
									'company_item' => [
										'controller' => FactoryIndexController::class,
										'action' => 'actionFactoryItem',
									],
								],
							],
						],
					],
				],
			],
			'children' => [
				'/ajax' => [
					'route' => '',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => FactoryIndexController::class,
						'action' => 'actionFactoryItem',
					],
				],
				'/get' => [
					'route' => '/get',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => FactoryEditController::class,
						'action' => 'actionFactoryGet',
					],
				],
				'/add' => [
					'ajax' => TRUE,
					'route' => '/add',
					'trigger' => [
						'controller' => FactoryEditController::class,
						'action' => 'actionFactoryAdd',
					],
				],
				'/update' => [
					'route' => '/update',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => FactoryEditController::class,
						'action' => 'actionFactoryUpdate',
					],
				],
			],
		],
	];
}
