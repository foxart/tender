<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorCompanyItemMenu;
use tender\vendor\menus\VendorCompanyListMenu;
use tender\vendor\menus\VendorTopMenu;
use tender\vendor\modules\bank\controllers\BankEditController;
use tender\vendor\modules\bank\controllers\BankIndexController;
use tender\vendor\modules\company\controllers\CompanyIndexController;

class VendorProfileBankRoutes extends Route {

	public static $map = [
		'/company/company-id/bank' => [
			'route' => '/company/:company/bank',
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
								'template' => 'vendorProfileItemStructure.twig',
								'layout' => [
//									'company_list_menu' => [
//										'controller' => CompanyIndexController::class,
//										'action' => 'companyListMenu',
//									],
									'company_list_menu' => [
										'controller' => VendorCompanyListMenu::class,
										'action' => 'outputBootstrapMenu',
										'arguments' => [
											'class' => 'nav nav-pills nav-stacked',
										],
									],
									'company_item_menu' => [
										'controller' => VendorCompanyItemMenu::class,
										'action' => 'outputBootstrapMenu',
										'arguments' => [
											'class' => 'nav nav-tabs',
										],
									],
									'company_item' => [
										'controller' => BankIndexController::class,
										'action' => 'actionBankList',
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
						'controller' => BankIndexController::class,
						'action' => 'actionBankList',
					],
				],
				'/get/bank-id' => [
					'route' => '/get/:bank',
					'constraints' => [
						'bank' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => BankEditController::class,
						'action' => 'actionBankGet',
					],
				],
				'/add' => [
					'route' => '/add',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => BankEditController::class,
						'action' => 'actionBankAdd',
					],
				],
				'/update/bank-id' => [
					'route' => '/update/:bank',
					'constraints' => [
						'bank' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => BankEditController::class,
						'action' => 'actionBankUpdate',
					],
				],
				'/delete/bank-id' => [
					'route' => '/delete/:bank',
					'constraints' => [
						'bank' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => BankEditController::class,
						'action' => 'actionBankDelete',
					],
				],
			],
		],
	];
}
