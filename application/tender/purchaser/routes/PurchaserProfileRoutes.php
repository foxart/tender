<?php

namespace tender\purchaser\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\purchaser\configurations\DefaultHeadConfiguration;
use tender\purchaser\menus\PurchaserProfileVendorCompanyMenu;
use tender\purchaser\menus\PurchaserTopMenu;
use tender\purchaser\modules\profile\controllers\PurchaserProfileIndexController;

class PurchaserProfileRoutes extends Route {

	public static $map = [
		'/profile' => [
			'route' => '/profile',
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
							'controller' => Layout::class,
							'action' => 'outputLayout',
							'arguments' => [
								'template' => 'purchaserProfileCompanyListStructure.twig',
								'layout' => [
									'purchaser_company_list_menu' => [
										'controller' => PurchaserProfileIndexController::class,
										'action' => 'purchaserCompanyListMenu',
									],
									'vendor_company_list' => [
										'controller' => PurchaserProfileIndexController::class,
										'action' => 'actionVendorCompanyList',
									],
								],
							],
						],
					],
				],
			],
			'children' => [
				'/purchaser_company_id/vendor_company_id' => [
					'route' => '/:purchaser_company_id/:vendor_company_id',
					'constraints' => [
						'purchaser_company_id' => '[0-9]+',
						'vendor_company_id' => '[0-9]+',
					],
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
									'controller' => Layout::class,
									'action' => 'outputLayout',
									'arguments' => [
										'template' => 'purchaserProfileCompanyItemStructure.twig',
										'layout' => [
											'purchaser_company_list_menu' => [
												'controller' => PurchaserProfileIndexController::class,
												'action' => 'purchaserCompanyListMenu',
											],
											'vendor_company_list_menu' => [
												'controller' => PurchaserProfileIndexController::class,
												'action' => 'vendorCompanyListMenu',
											],
											'vendor_company_item_menu' => [
												'controller' => Layout::class,
												'action' => 'outputBootstrapMenu',
												'arguments' => [
													'map' => PurchaserProfileVendorCompanyMenu::class,
													'class' => 'nav nav-tabs',
												],
											],
											'vendor_company_item' => [
												'controller' => PurchaserProfileIndexController::class,
												'action' => 'actionVendorCompany',
											],
										],
									],
								],
							],
						],
					],
					'children' => [
						'/bank' => [
							'route' => '/bank',
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
											'controller' => Layout::class,
											'action' => 'outputLayout',
											'arguments' => [
												'template' => 'purchaserProfileCompanyItemStructure.twig',
												'layout' => [
													'purchaser_company_list_menu' => [
														'controller' => PurchaserProfileIndexController::class,
														'action' => 'purchaserCompanyListMenu',
													],
													'vendor_company_list_menu' => [
														'controller' => PurchaserProfileIndexController::class,
														'action' => 'vendorCompanyListMenu',
													],
													'vendor_company_item_menu' => [
														'controller' => Layout::class,
														'action' => 'outputBootstrapMenu',
														'arguments' => [
															'map' => PurchaserProfileVendorCompanyMenu::class,
															'class' => 'nav nav-tabs',
														],
													],
													'vendor_company_item' => [
														'controller' => PurchaserProfileIndexController::class,
														'action' => 'actionVendorBankList',
													],
												],
											],
										],
									],
								],
							],
						],
						'/materials' => [
							'route' => '/materials',
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
											'controller' => Layout::class,
											'action' => 'outputLayout',
											'arguments' => [
												'template' => 'purchaserProfileCompanyItemStructure.twig',
												'layout' => [
													'purchaser_company_list_menu' => [
														'controller' => PurchaserProfileIndexController::class,
														'action' => 'purchaserCompanyListMenu',
													],
													'vendor_company_list_menu' => [
														'controller' => PurchaserProfileIndexController::class,
														'action' => 'vendorCompanyListMenu',
													],
													'vendor_company_item_menu' => [
														'controller' => Layout::class,
														'action' => 'outputBootstrapMenu',
														'arguments' => [
															'map' => PurchaserProfileVendorCompanyMenu::class,
															'class' => 'nav nav-tabs',
														],
													],
													'vendor_company_item' => [
														'controller' => PurchaserProfileIndexController::class,
														'action' => 'actionVendorMaterialList',
													],
												],
											],
										],
									],
								],
							],
						],
					],
				],
			],
		],
	];
}
