<?php

namespace tender\admin\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\admin\configurations\DefaultHeadConfiguration;
use tender\admin\menus\AdminTopMenu;
use tender\admin\modules\material\controllers\AdminAccountMaterialEditController;
use tender\admin\modules\material\controllers\AdminAccountMaterialIndexController;
use tender\common\modules\account\controllers\AccountIndexController;

class AdminMaterialRoutes extends Route {

	public static $map = [
		'/materials' => [
			'route' => '/materials',
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
								'template' => 'materialListLayout.twig',
								'layout' => [
									'material_group_list_filter' => [
										'controller' => AdminAccountMaterialIndexController::class,
										'action' => 'actionMaterialGroupListFilter',
									],
									'material_group_list' => [
										'controller' => AdminAccountMaterialIndexController::class,
										'action' => 'actionMaterialGroupList',
									],
									'material_list_filter' => [
										'controller' => AdminAccountMaterialIndexController::class,
										'action' => 'actionMaterialListFilter',
									],
									'material_list' => [
										'controller' => AdminAccountMaterialIndexController::class,
										'action' => 'actionMaterialList',
									],
								],
							],
						],
					],
				],
			],
			'children' => [
				/*
				 * MATERIALS
				 */
				'/material' => [
					'route' => '/material',
					'behaviour' => 'virtual',
					'children' => [
						'/list' => [
							'route' => '/list',
							'trigger' => [
								'controller' => AdminAccountMaterialIndexController::class,
								'action' => 'actionMaterialList',
							],
						],
						'/add' => [
							'route' => '/add',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminAccountMaterialEditController::class,
								'action' => 'actionMaterialAdd',
							],
						],
						'/get' => [
							'route' => '/get/:id',
							'constraints' => [
								'id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminAccountMaterialEditController::class,
								'action' => 'actionMaterialGet',
							],
						],
						'/update' => [
							'route' => '/update/:id',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminAccountMaterialEditController::class,
								'action' => 'actionMaterialUpdate',
							],
						],
						'/delete' => [
							'route' => '/delete/:id',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminAccountMaterialEditController::class,
								'action' => 'actionMaterialDelete',
							],
						],
					],
				],
				/*
				 * GROUPS
				 */
				'/group' => [
					'route' => '/group',
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
										'template' => 'materialListLayout.twig',
										'layout' => [
											'material_group_list_filter' => [
												'controller' => AdminAccountMaterialIndexController::class,
												'action' => 'actionMaterialGroupListFilter',
											],
											'material_group_list' => [
												'controller' => AdminAccountMaterialIndexController::class,
												'action' => 'actionMaterialGroupList',
											],
											'material_list_filter' => [
												'controller' => AdminAccountMaterialIndexController::class,
												'action' => 'actionMaterialListFilter',
											],
											'material_list' => [
												'controller' => AdminAccountMaterialIndexController::class,
												'action' => 'actionMaterialList',
											],
										],
									],
								],
							],
						],
//						'controller' => MaterialIndexController::class,
//						'action' => 'actionMaterialGroupList',
//						'trigger' => [
//							'controller' => AdminMaterialLayout::class,
//							'action' => 'outputIndex',
//							'arguments' => [
//								'map' => AdminLayoutConfiguration::class,
//							],
//						],
					],
					'children' => [
						'/list' => [
							'route' => '/list',
							'trigger' => [
								'controller' => AdminAccountMaterialIndexController::class,
								'action' => 'actionMaterialGroupList',
							],
						],
						'/get' => [
							'route' => '/get/:id',
							'constraints' => [
								'id' => '[0-9]+',
							],
							'trigger' => [
								'controller' => AdminAccountMaterialEditController::class,
								'action' => 'actionMaterialGroupGet',
							],
						],
						'/add' => [
							'route' => '/add',
							'trigger' => [
								'controller' => AdminAccountMaterialEditController::class,
								'action' => 'actionMaterialGroupAdd',
							],
						],
						'/update' => [
							'route' => '/update/:id',
							'trigger' => [
								'controller' => AdminAccountMaterialEditController::class,
								'action' => 'actionMaterialGroupUpdate',
							],
						],
						'/delete' => [
							'route' => '/delete/:id',
							'trigger' => [
								'controller' => AdminAccountMaterialEditController::class,
								'action' => 'actionMaterialGroupDelete',
							],
						],
					],
				],
			],
		],
	];
}
