<?php

namespace tender\common\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\configurations\AuthenticationHeadConfiguration;
use tender\common\modules\authentication\controllers\AuthenticationController;

class AuthenticationRoutes extends Route {

	public static $map = [
		'/authentication' => [
			'route' => '/authentication',
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputLayout',
				'arguments' => [
					'template' => 'application/tender/common/modules/authentication/templates/authenticationHtml.twig',
					'layout' => [
						'head' => [
							'controller' => Layout::class,
							'action' => 'outputHead',
							'arguments' => [
								'map' => AuthenticationHeadConfiguration::class,
							],
						],
						'body' => [
							'controller' => AuthenticationController::class,
							'action' => 'actionSignIn',
						],
					],
				],
			],
			'children' => [
				'/sign-in' => [
					'route' => '/sign-in',
					'trigger' => [
						'controller' => Layout::class,
						'action' => 'outputLayout',
						'arguments' => [
							'template' => 'application/tender/common/modules/authentication/templates/authenticationHtml.twig',
							'layout' => [
								'head' => [
									'controller' => Layout::class,
									'action' => 'outputHead',
									'arguments' => [
										'map' => AuthenticationHeadConfiguration::class,
									],
								],
								'body' => [
									'controller' => AuthenticationController::class,
									'action' => 'actionSignIn',
								],
							],
						],
					],
				],
				'/sign-out' => [
					'route' => '/sign-out',
					'trigger' => [
						'controller' => AuthenticationController::class,
						'action' => 'actionSignOut',
					],
				],
				'/sign-up' => [
					'route' => '/sign-up',
					'trigger' => [
						'controller' => Layout::class,
						'action' => 'outputLayout',
						'arguments' => [
							'template' => 'application/tender/common/modules/authentication/templates/authenticationHtml.twig',
							'layout' => [
								'head' => [
									'controller' => Layout::class,
									'action' => 'outputHead',
									'arguments' => [
										'map' => AuthenticationHeadConfiguration::class,
									],
								],
								'body' => [
									'controller' => AuthenticationController::class,
									'action' => 'actionSignUpForm',
								],
							],
						],
					],
					'children' => [
						'/request/registration_code' => [
							'route' => '/request/:registration_code',
							'trigger' => [
								'controller' => Layout::class,
								'action' => 'outputLayout',
								'arguments' => [
									'template' => 'application/tender/common/modules/authentication/templates/authenticationHtml.twig',
									'layout' => [
										'head' => [
											'controller' => Layout::class,
											'action' => 'outputHead',
											'arguments' => [
												'map' => AuthenticationHeadConfiguration::class,
											],
										],
										'body' => [
											'controller' => AuthenticationController::class,
											'action' => 'actionSignUpFeedback',
										],
									],
								],
							],
						],
						'/confirm/registration_code' => [
							'route' => '/confirm/:registration_code',
							'trigger' => [
								'controller' => Layout::class,
								'action' => 'outputLayout',
								'arguments' => [
									'template' => 'application/tender/common/modules/authentication/templates/authenticationHtml.twig',
									'layout' => [
										'head' => [
											'controller' => Layout::class,
											'action' => 'outputHead',
											'arguments' => [
												'map' => AuthenticationHeadConfiguration::class,
											],
										],
										'body' => [
											'controller' => AuthenticationController::class,
											'action' => 'actionSignUpConfirm',
										],
									],
								],
							],
						],
					],
				],
				'/reset' => [
					'route' => '/reset',
					'trigger' => [
						'controller' => Layout::class,
						'action' => 'outputLayout',
						'arguments' => [
							'template' => 'application/tender/common/modules/authentication/templates/authenticationHtml.twig',
							'layout' => [
								'head' => [
									'controller' => Layout::class,
									'action' => 'outputHead',
									'arguments' => [
										'map' => AuthenticationHeadConfiguration::class,
									],
								],
								'body' => [
									'controller' => AuthenticationController::class,
									'action' => 'actionResetForm',
								],
							],
						],
					],
					'children' => [
						'/feedback/password_code' => [
							'route' => '/feedback/:password_code',
							'trigger' => [
								'controller' => Layout::class,
								'action' => 'outputLayout',
								'arguments' => [
									'template' => 'application/tender/common/modules/authentication/templates/authenticationHtml.twig',
									'layout' => [
										'head' => [
											'controller' => Layout::class,
											'action' => 'outputHead',
											'arguments' => [
												'map' => AuthenticationHeadConfiguration::class,
											],
										],
										'body' => [
											'controller' => AuthenticationController::class,
											'action' => 'actionResetFeedback',
										],
									],
								],
							],
						],
						'/confirm/password_code' => [
							'route' => '/confirm/:password_code',
							'trigger' => [
								'controller' => Layout::class,
								'action' => 'outputLayout',
								'arguments' => [
									'template' => 'application/tender/common/modules/authentication/templates/authenticationHtml.twig',
									'layout' => [
										'head' => [
											'controller' => Layout::class,
											'action' => 'outputHead',
											'arguments' => [
												'map' => AuthenticationHeadConfiguration::class,
											],
										],
										'body' => [
											'controller' => AuthenticationController::class,
											'action' => 'actionResetConfirm',
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
