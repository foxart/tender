<?php

namespace tender\admin\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\admin\configurations\DefaultHeadConfiguration;
use tender\admin\menus\AccountMaterialMenu;
use tender\admin\menus\AccountPurchaserMenu;
use tender\admin\menus\AdminTopMenu;
use tender\admin\modules\account\company\controllers\AdminAccountCompanyEditController;
use tender\admin\modules\account\company\controllers\AdminAccountCompanyIndexController;
use tender\admin\modules\account\material\controllers\MaterialEditController;
use tender\admin\modules\account\material\controllers\MaterialIndexController;
use tender\admin\modules\account\profile\controllers\AdminAccountProfileIndexController;
use tender\common\modules\account\controllers\AccountIndexController;

class AccountPurchaserCompanyRoutes extends Route {

	public static $map = [
		'/users/purchaser/account-id/company' => [
			'route' => '/users/purchaser/:account-id/company',
			'ajax' => FALSE,
			'constraints' => [
				'account-id' => '[0-9]+',
			],
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
				'arguments' => [
					'template' => 'adminHtml.twig',
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
								'map' => AdminTopMenu::class,
								'class' => 'nav navbar-nav navbar-right',
							],
						],
						'body' => [
							'controller' => Layout::class,
							'action' => 'outputLayout',
							'arguments' => [
								'template' => 'accountProfileLayout.twig',
								'layout' => [
									'account_type' => [
										'controller' => AdminAccountProfileIndexController::class,
//										'controller' => AdminAccountProfileEditController::class,
										'action' => 'accountTypeGet',
									],
									'account_name' => [
										'controller' => AdminAccountProfileIndexController::class,
										'action' => 'accountNameGet',
									],
									'tabs' => [
										'controller' => Layout::class,
										'action' => 'outputBootstrapMenu',
										'arguments' => [
											'map' => AccountPurchaserMenu::class,
											'class' => 'nav nav-tabs',
										],
									],
									'controller' => [
										'controller' => AdminAccountCompanyIndexController::class,
										'action' => 'outputAdminAccountCompanyList',
									],
								],
							],
						],
					],
				],
			],
			'children' => [
				'/company-id' => [
					'route' => '/:company-id',
					'behaviour' => 'virtual',
					'constraints' => [
						'company-id' => '[0-9]+',
					],
					'children' => [
						'/material' => [
							'route' => '/material',
							'trigger' => [
								'controller' => Layout::class,
								'action' => 'outputLayout',
								'arguments' => [
									'template' => 'adminHtml.twig',
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
												'map' => AdminTopMenu::class,
												'class' => 'nav navbar-nav navbar-right',
											],
										],
										'body' => [
											'controller' => Layout::class,
											'action' => 'outputLayout',
											'arguments' => [
												'template' => 'accountProfileMaterialLayout.twig',
												'layout' => [
													'account_type' => [
														'controller' => AdminAccountProfileIndexController::class,
														'action' => 'accountTypeGet',
													],
													'account_name' => [
														'controller' => AdminAccountProfileIndexController::class,
														'action' => 'accountNameGet',
													],
													'tabs' => [
														'controller' => Layout::class,
														'action' => 'outputBootstrapMenu',
														'arguments' => [
															'map' => AccountMaterialMenu::class,
															'class' => 'nav nav-tabs',
														],
													],
													'company_list_menu' => [
														'controller' => MaterialIndexController::class,
														'action' => 'companyMenu',
													],
													'controller' => [
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
									'route' => '/ajax',
									'ajax' => TRUE,
									'trigger' => [
										'controller' => MaterialIndexController::class,
										'action' => 'actionMaterialList',
									],
								],
								'/select' => [
									'route' => '/select',
									'trigger' => [
										'controller' => MaterialEditController::class,
										'action' => 'actionMaterialSelect',
									],
								],
								'/add' => [
									'route' => '/material/add',
									'trigger' => [
										'controller' => MaterialEditController::class,
										'action' => 'actionMaterialAdd',
									],
								],
								'/material-id' => [
									'route' => '/:material-id',
									'behaviour' => 'virtual',
									'constraints' => [
										'material-id' => '[0-9]+',
									],
									'children' => [
										'/get' => [
											'route' => '/get',
											'ajax' => TRUE,
											'trigger' => [
												'controller' => MaterialEditController::class,
												'action' => 'actionMaterialGet',
											],
										],
										'/update' => [
											'route' => '/update',
											'ajax' => TRUE,
											'trigger' => [
												'controller' => MaterialEditController::class,
												'action' => 'actionMaterialUpdate',
											],
										],
										'/delete' => [
											'route' => '/delete',
											'ajax' => TRUE,
											'trigger' => [
												'controller' => MaterialEditController::class,
												'action' => 'actionMaterialDelete',
											],
										],
									],
								],
							],
						],
					],
				],
				'/list' => [
					'route' => '/list',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountCompanyIndexController::class,
						'action' => 'outputAdminAccountCompanyList',
					],
				],
				'/add' => [
					'route' => '/add',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountCompanyEditController::class,
						'action' => 'actionAddCompanyToPurchaser',
					],
				],
				'/delete' => [
					'route' => '/delete/:company-id',
					'constraints' => [
						'company-id' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountCompanyEditController::class,
						'action' => 'actionDeleteBindedCompany',
					],
				],
				'/list_not_binded' => [
					'route' => '/company-list',
					'trigger' => [
						'controller' => AdminAccountCompanyIndexController::class,
						'action' => 'actionPurchaserCompanyNotBinded',
					],
				],
			],
//		],
//	],
		],
	];
}
