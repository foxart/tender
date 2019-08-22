<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorCompanyItemMenu;
use tender\vendor\menus\VendorTopMenu;
use tender\vendor\modules\company\controllers\CompanyIndexController;
use tender\vendor\modules\contact\controllers\ContactEditController as ContactEditController;
use tender\vendor\modules\contact\controllers\ContactIndexController as ContactIndexController;

class VendorProfileContactRoutes extends Route {

	public static $map = [
		'/company/company-id/contact' => [
			'route' => '/company/:company/contact',
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
										'controller' => ContactIndexController::class,
										'action' => 'actionContact',
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
						'controller' => ContactIndexController::class,
						'action' => 'actionContact',
					],
				],
				'/get' => [
					'route' => '/get',
					'ajax' => TRUE,
					'trigger' => [
						'layout' => NULL,
						'controller' => ContactEditController::class,
						'action' => 'actionContactGet',
					],
				],
				'/add' => [
					'route' => '/add',
					'ajax' => TRUE,
					'trigger' => [
						'layout' => NULL,
						'controller' => ContactEditController::class,
						'action' => 'actionContactAdd',
					],
				],
				'/update' => [
					'route' => '/update',
					'ajax' => TRUE,
					'trigger' => [
						'layout' => NULL,
						'controller' => ContactEditController::class,
						'action' => 'actionContactUpdate',
					],
				],
			],
		],
	];
}
