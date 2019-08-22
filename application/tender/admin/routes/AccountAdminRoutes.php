<?php

namespace tender\admin\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\admin\configurations\DefaultHeadConfiguration;
use tender\admin\menus\AccountAdminMenu;
use tender\admin\menus\AdminTopMenu;
use tender\admin\modules\account\profile\controllers\AdminAccountProfileEditController;
use tender\admin\modules\account\profile\controllers\AdminAccountProfileIndexController;
use tender\common\modules\account\controllers\AccountIndexController;

class AccountAdminRoutes extends Route {

	public static $map = [
		'/users/admin/account-id' => [
			'route' => '/users/admin/:account-id',
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
										'action' => 'accountTypeGet',
									],
									'tabs' => [
										'controller' => Layout::class,
										'action' => 'outputBootstrapMenu',
										'arguments' => [
											'map' => AccountAdminMenu::class,
											'class' => 'nav nav-tabs',
										],
									],
									'account_name' => [
										'controller' => AdminAccountProfileIndexController::class,
										'action' => 'accountNameGet',
									],
									'controller' => [
										'controller' => AdminAccountProfileIndexController::class,
										'action' => 'actionAccountProfile',
									],
								],
							],
						],
					],
				],
			],
			'children' => [
				'/active_status' => [
					'route' => '/active-status',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountProfileEditController::class,
						'action' => 'actionActiveStatusAccount',
					],
				],
				'/ajax' => [
					'route' => '/ajax',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountProfileIndexController::class,
						'action' => 'actionAccountProfile',
					],
				],
				'/get' => [
					'route' => '/get',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountProfileEditController::class,
						'action' => 'actionAccountGet',
					],
				],
				'/update' => [
					'route' => '/update',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountProfileEditController::class,
						'action' => 'actionAccountUpdate',
					],
				],
				'/get_authorization' => [
					'route' => '/get-authorization',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountProfileIndexController::class,
						'action' => 'actionAccountAuthorizationGet',
					],
				],
				'/update_authorization' => [
					'route' => '/update-authorization',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountProfileEditController::class,
						'action' => 'accountAuthorizationUpdate',
					],
				],
				'/reset_password' => [
					'route' => '/reset-password',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AdminAccountProfileEditController::class,
						'action' => 'actionResetPassword',
					],
				],
			],
		],
	];
}
