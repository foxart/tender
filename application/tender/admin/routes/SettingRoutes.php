<?php

namespace tender\admin\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\admin\configurations\DefaultHeadConfiguration;
use tender\admin\menus\AdminTopMenu;
use tender\admin\menus\SettingsMenu;
use tender\admin\modules\legal\controllers\SettingCompanyEditController;
use tender\admin\modules\legal\controllers\SettingCompanyIndexController;
use tender\admin\modules\role\controllers\AdminAccountAuthorizationEditController;
use tender\admin\modules\role\controllers\AdminAccountAuthorizationIndexController;
use tender\common\modules\account\controllers\AccountIndexController;

class SettingRoutes extends Route {

	public static $map = [
		'/settings/authorization' => [
			'route' => '/settings/roles',
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
								'template' => 'settingLayout.twig',
								'layout' => [
									'tabs' => [
										'controller' => Layout::class,
										'action' => 'outputBootstrapMenu',
										'arguments' => [
											'map' => SettingsMenu::class,
											'class' => 'nav nav-tabs',
										],
									],
									'controller' => [
										'controller' => AdminAccountAuthorizationIndexController::class,
										'action' => 'actionAuthorizationList',
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
						'controller' => AdminAccountAuthorizationIndexController::class,
						'action' => 'actionAuthorizationList',
					],
				],
				'/add' => [
					'route' => '/add',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountAuthorizationEditController::class,
						'action' => 'actionAuthorizationAdd',
					],
				],
			],
		],
		'/settings/authorization/authorization-id' => [
			'route' => '/settings/authorization/:authorization-id',
			'behaviour' => 'virtual',
			'constraints' => [
				'authorization-id' => '[0-9]+',
			],
			'children' => [
				'/get' => [
					'route' => '/get',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountAuthorizationEditController::class,
						'action' => 'actionAuthorizationGet',
					],
				],
				'/update' => [
					'route' => '/update',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountAuthorizationEditController::class,
						'action' => 'actionAuthorizationUpdate',
					],
				],
				'/delete' => [
					'route' => '/delete',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountAuthorizationEditController::class,
						'action' => 'actionAuthorizationDelete',
					],
				],
			],
		],
		'/settings/company' => [
			'route' => '/settings/legal-entity',
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
								'template' => 'settingLayout.twig',
								'layout' => [
									'tabs' => [
										'controller' => Layout::class,
										'action' => 'outputBootstrapMenu',
										'arguments' => [
											'map' => SettingsMenu::class,
											'class' => 'nav nav-tabs',
										],
									],
									'controller' => [
										'controller' => SettingCompanyIndexController::class,
										'action' => 'actionCompanyList',
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
					'ajax' => TRUE,
					'constraints' => [
						'company-id' => '[0-9]+',
					],
					'trigger' => [
						'controller' => SettingCompanyEditController::class,
						'action' => 'actionCompanyGet',
					],
				],
				'/add' => [
					'route' => '/add',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => SettingCompanyEditController::class,
						'action' => 'actionCompanyAdd',
					],
				],
				'/update' => [
					'route' => '/update/:company-id',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => SettingCompanyEditController::class,
						'action' => 'actionCompanyUpdate',
					],
				],
				'/delete' => [
					'route' => '/delete/id-:id',
					'ajax' => TRUE,
					'constraints' => [
						'id' => '[0-9]+',
					],
					'trigger' => [
						'controller' => SettingCompanyEditController::class,
						'action' => 'actionCompanyDelete',
					],
				],
				'/list' => [
					'route' => '/list',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => SettingCompanyIndexController::class,
						'action' => 'actionCompanyList',
					],
				],
			],
		],
	];
}
