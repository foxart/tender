<?php

namespace tender\admin\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\admin\configurations\DefaultHeadConfiguration;
use tender\admin\menus\AdminTopMenu;
use tender\admin\modules\tree\controllers\AdminTreeEditController;
use tender\admin\modules\tree\controllers\AdminTreeIndexController;
use tender\common\modules\account\controllers\AccountIndexController;

class TreeRoutes extends Route {

	public static $map = [
		'/jstree_materials' => [
			'route' => '/jstree-materials',
			'ajax' => FALSE,
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
								'template' => 'accountListLayout.twig',
								'layout' => [
									'controller' => [
										'controller' => AdminTreeIndexController::class,
										'action' => 'actionMaterialList',
									],
								],
							],
						],
					],
				],
			],
			'children' => [
				'/material' => [
					'route' => '/material',
					'behaviour' => 'virtual',
					'children' => [
						'/save_all' => [
							'route' => '/save-all',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeEditController::class,
								'action' => 'actionMaterialTreeSave',
							],
						],
						'/save_node' => [
							'route' => '/save-node',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeEditController::class,
								'action' => 'actionMaterialNodeSave',
							],
						],

						'/list' => [
							'route' => '/list',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeIndexController::class,
								'action' => 'actionMaterialList',
							],
						],
						'/jstree_list' => [
							'route' => '/jstree-list',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeIndexController::class,
								'action' => 'actionMaterialTreeList',
							],
						],
						'/add' => [
							'route' => '/add',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeEditController::class,
								'action' => 'actionMaterialAdd',
							],
						],
						'/get' => [
							'route' => '/get/:material-id',
							'constraints' => [
								'material-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeEditController::class,
								'action' => 'actionMaterialGet',
							],
						],
						'/update' => [
							'route' => '/update/:material-id',
							'constraints' => [
								'material-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeEditController::class,
								'action' => 'actionMaterialUpdate',
							],
						],
						'/delete' => [
							'route' => '/delete/:material-id',
							'constraints' => [
								'material-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeEditController::class,
								'action' => 'actionMaterialDelete',
							],
						],
					],
				],
				'/group' => [
					'route' => '/group',
					'behaviour' => 'virtual',
					'children' => [
						'/add' => [
							'route' => '/add',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeEditController::class,
								'action' => 'actionMaterialGroupAdd',
							],
						],
						'/get' => [
							'route' => '/get/:material-id',
							'constraints' => [
								'material-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeEditController::class,
								'action' => 'actionMaterialGroupGet',
							],
						],
						'/update' => [
							'route' => '/update/:material-id',
							'constraints' => [
								'material-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeEditController::class,
								'action' => 'actionMaterialGroupUpdate',
							],
						],
						'/delete' => [
							'route' => '/delete/:material-id',
							'constraints' => [
								'material-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => AdminTreeEditController::class,
								'action' => 'actionMaterialGroupDelete',
							],
						],
					],
				],
			],
		],
	];
}
