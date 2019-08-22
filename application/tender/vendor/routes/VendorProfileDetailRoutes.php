<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorCompanyItemMenu;
use tender\vendor\menus\VendorTopMenu;
use tender\vendor\modules\company\controllers\CompanyIndexController;
use tender\vendor\modules\detail\controllers\DetailEditController;
use tender\vendor\modules\detail\controllers\DetailIndexController;
use tender\vendor\modules\factory\controllers\FactoryIndexController;

class VendorProfileDetailRoutes extends Route {

	public static $map = [
		'/company/company-id/detail' => [
			'route' => '/company/:company/detail',
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
								'template' => 'vendorProfileItemDetailStructure.twig',
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
									'company_detail' => [
										'controller' => DetailIndexController::class,
										'action' => 'actionDetailItem',
									],
									'company_factory' => [
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
						'controller' => DetailIndexController::class,
						'action' => 'actionDetailItem',
					],
				],
				'/get' => [
					'route' => '/get',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => DetailEditController::class,
						'action' => 'actionDetailGet',
					],
				],
				'/add' => [
					'ajax' => TRUE,
					'route' => '/add',
					'trigger' => [
						'controller' => DetailEditController::class,
						'action' => 'actionDetailAdd',
					],
				],
				'/update' => [
					'route' => '/update',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => DetailEditController::class,
						'action' => 'actionDetailUpdate',
					],
				],
			],
		],
	];
}
