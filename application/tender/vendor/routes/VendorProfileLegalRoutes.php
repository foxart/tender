<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorCompanyItemMenu;
use tender\vendor\menus\VendorTopMenu;
use tender\vendor\modules\company\controllers\CompanyIndexController as CompanyIndexController;
use tender\vendor\modules\legal\controllers\LegalEditController as LegalEditController;
use tender\vendor\modules\legal\controllers\LegalIndexController as LegalIndexController;

class VendorProfileLegalRoutes extends Route {

	public static $map = [
		'/company/company-id/legal' => [
			'route' => '/company/:company/legal',
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
										'controller' => LegalIndexController::class,
										'action' => 'actionLegalList',
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
						'controller' => LegalIndexController::class,
						'action' => 'actionLegalList',
					],
				],
				'/select' => [
					'route' => '/select',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => LegalEditController::class,
						'action' => 'actionLegalSelect',
					],
				],
				'/get/legal-id' => [
					'route' => '/get/:legal',
					'constraints' => [
						'legal' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => LegalEditController::class,
						'action' => 'actionLegalGet',
					],
				],
				'/add' => [
					'route' => '/add',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => LegalEditController::class,
						'action' => 'actionLegalAdd',
					],
				],
				'/update/legal-id' => [
					'route' => '/update/:legal',
					'constraints' => [
						'legal' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => LegalEditController::class,
						'action' => 'actionLegalUpdate',
					],
				],
				'/delete/legal-id' => [
					'route' => '/delete/:legal',
					'constraints' => [
						'legal' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => LegalEditController::class,
						'action' => 'actionLegalDelete',
					],
				],
			],
		],
	];
}
