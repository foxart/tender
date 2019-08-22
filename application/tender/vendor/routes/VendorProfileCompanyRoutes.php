<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorCompanyItemMenu;
use tender\vendor\menus\VendorTopMenu;
use tender\vendor\modules\company\controllers\CompanyEditController;
use tender\vendor\modules\company\controllers\CompanyIndexController;

class VendorProfileCompanyRoutes extends Route {

	public static $map = [
		'/company' => [
			'route' => '/company',
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
							'controller' => VendorTopMenu::class,
							'action' => 'outputBootstrapMenu',
							'arguments' => [
								'class' => 'nav navbar-nav navbar-right',
							],
						],
						'body' => [
							'controller' => Layout::class,
							'action' => 'outputLayout',
							'arguments' => [
								'template' => 'vendorProfileListStructure.twig',
								'layout' => [
									'company_form' => [
										'controller' => CompanyIndexController::class,
										'action' => 'outputCompanyForm',
									],
									'company_list' => [
										'controller' => CompanyIndexController::class,
										'action' => 'outputCompanyList',
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
						'controller' => CompanyIndexController::class,
						'action' => 'outputCompanyList',
					],
				],
				'/add' => [
					'ajax' => TRUE,
					'route' => '/add',
					'trigger' => [
						'controller' => CompanyEditController::class,
						'action' => 'actionCompanyAdd',
					],
				],
			],
		],
		'/company/company-id' => [
			'route' => '/company/:company',
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
							'controller' => VendorTopMenu::class,
							'action' => 'outputBootstrapMenu',
							'arguments' => [
								'class' => 'nav navbar-nav navbar-right',
							],
						],
						'body' => [
							'controller' => Layout::class,
							'action' => 'outputLayout',
							'arguments' => [
								'template' => 'vendorProfileItemCompanyStructure.twig',
								'layout' => [
									'company_form' => [
										'controller' => CompanyIndexController::class,
										'action' => 'outputCompanyForm',
									],
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
										'controller' => CompanyIndexController::class,
										'action' => 'actionCompanyItem',
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
						'controller' => CompanyIndexController::class,
						'action' => 'actionCompanyItem',
					],
				],
				'/get' => [
					'route' => '/get',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => CompanyEditController::class,
						'action' => 'actionCompanyGet',
					],
				],
				'/delete' => [
					'route' => '/delete',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => CompanyEditController::class,
						'action' => 'actionCompanyDelete',
					],
				],
				'/update' => [
					'route' => '/update',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => CompanyEditController::class,
						'action' => 'actionCompanyUpdate',
					],
				],
			],
		],
	];
}


