<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorCompanyItemMenu;
use tender\vendor\menus\VendorTopMenu;
use tender\vendor\modules\company\controllers\CompanyIndexController;
use tender\vendor\modules\material\controllers\MaterialEditController as MaterialEditController;
use tender\vendor\modules\material\controllers\MaterialIndexController as MaterialIndexController;

class VendorProfileMaterialRoutes extends Route {

	public static $map = [
		'/company/company-id/material' => [
			'route' => '/company/:company/material',
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
										'controller' => MaterialIndexController::class,
										'action' => 'actionMaterialList',
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
						'controller' => MaterialIndexController::class,
						'action' => 'actionMaterialList',
					],
				],
				'/get/material-id' => [
					'route' => '/get/:material',
					'constraints' => [
						'material' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => MaterialEditController::class,
						'action' => 'actionMaterialGet',
					],
				],
				'/select' => [
					'route' => '/select',
					'constraints' => [
						'bank' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => MaterialEditController::class,
						'action' => 'actionMaterialSelect',
					],
				],
				'/add' => [
					'route' => '/add',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => MaterialEditController::class,
						'action' => 'actionMaterialAdd',
					],
				],
				'/update/material-id' => [
					'route' => '/update/:material',
					'constraints' => [
						'material' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => MaterialEditController::class,
						'action' => 'actionMaterialUpdate',
					],
				],
				'/delete/material-id' => [
					'route' => '/delete/:material',
					'constraints' => [
						'material' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => MaterialEditController::class,
						'action' => 'actionMaterialDelete',
					],
				],
			],
		],
	];
}
