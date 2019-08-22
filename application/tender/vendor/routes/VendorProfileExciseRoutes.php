<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorCompanyItemMenu;
use tender\vendor\menus\VendorTopMenu;
use tender\vendor\modules\company\controllers\CompanyIndexController;
use tender\vendor\modules\excise\controllers\VendorProfileExciseEditController as ContactEditController;
use tender\vendor\modules\excise\controllers\VendorProfileExciseIndexController;

class VendorProfileExciseRoutes extends Route {

	public static $map = [
		'/company/company-id/excise' => [
			'route' => '/company/:company/excise',
			'constraints' => [
				'company' => '[0-9]+',
			],
			'ajax' => FALSE,
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
										'controller' => VendorProfileExciseIndexController::class,
										'action' => 'actionExcise',
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
						'controller' => VendorProfileExciseIndexController::class,
						'action' => 'actionExcise',
					],
				],
				'/get' => [
					'route' => '/get',
					'ajax' => TRUE,
					'trigger' => [
						'layout' => NULL,
						'controller' => ContactEditController::class,
						'action' => 'actionExciseGet',
					],
				],
				'/add' => [
					'route' => '/add',
					'ajax' => TRUE,
					'trigger' => [
						'layout' => NULL,
						'controller' => ContactEditController::class,
						'action' => 'actionExciseAdd',
					],
				],
				'/update' => [
					'route' => '/update',
					'ajax' => TRUE,
					'trigger' => [
						'layout' => NULL,
						'controller' => ContactEditController::class,
						'action' => 'actionExciseUpdate',
					],
				],
			],
		],
	];
}
