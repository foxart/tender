<?php

namespace tender\admin\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\admin\configurations\DefaultHeadConfiguration;
use tender\admin\menus\AdminTopMenu;
use tender\admin\modules\account\user\controllers\AdminAccountUserEditController as AccountListEditController;
use tender\admin\modules\account\user\controllers\AdminAccountUserIndexController as AccountListIndexController;
use tender\common\modules\account\controllers\AccountIndexController;

class AccountRoutes extends Route {

	public static $map = [
		'/users' => [
			'route' => '/users',
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
									'user_filter_form' => [
										'controller' => AccountListIndexController::class,
										'action' => 'filterForm',
									],
									'controller' => [
										'controller' => AccountListIndexController::class,
										'action' => 'actionUserList',
									],
								],
							],
						],
					],
				],
			],
			'children' => [
				'/list' => [
					'route' => '/list',
					'trigger' => [
						'controller' => AccountListIndexController::class,
						'action' => 'actionUserList',
					],
				],
				'/ajax' => [
					'route' => '/:account-id',
					'constraints' => [
						'account-id' => '[0-9]+',
					],
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AccountListEditController::class,
						'action' => 'actionAccountGet',
					],
				],
				'/add' => [
					'route' => '/add',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => AccountListEditController::class,
						'action' => 'actionAddAccount',
					],
				],
				'/delete' => [
					'route' => '/:account-id/delete',
					'constraints' => [
						'accont-id' => '[0-9]+',
					],
					'trigger' => [
						'controller' => AccountListEditController::class,
						'action' => 'actionDeleteAccount',
					],
				],
			],
		],
	];
}
