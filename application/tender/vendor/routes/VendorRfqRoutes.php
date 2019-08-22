<?php

namespace tender\vendor\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\vendor\configurations\DefaultHeadConfiguration;
use tender\vendor\menus\VendorTopMenu;
use tender\vendor\modules\rfq\controllers\RfqIndexController;
use tender\vendor\modules\rfq\controllers\RfqMaterialQuotationEditController;
use tender\vendor\modules\rfq\controllers\RfqMaterialQuotationIndexController;

class VendorRfqRoutes extends Route {

	public static $map = [
		'/rfq' => [
			'route' => '/rfq',
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
								'template' => 'vendorRfqListStructure.twig',
								'layout' => [
//									'rfq_form' => [
//										'controller' => PurchaserRfqEditController::class,
//										'action' => 'outputRfqForm',
//									],
									'rfq_list_filter' => [
										'controller' => RfqIndexController::class,
										'action' => 'outputRfqListFilter',
									],
									'rfq_list' => [
										'controller' => RfqIndexController::class,
										'action' => 'outputRfqList',
									],
								],
							],
						],
					],
				],
			],
		],
		'/rfq/rfq_id/vendor_company_id' => [
			'route' => '/rfq/:rfq_id/:vendor_company_id',
			'ajax' => FALSE,
			'constraints' => [
				'rfq_id' => '[0-9]+',
				'rfq_cross_vendor_company_id' => '[0-9]+',
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
								'template' => 'vendorRfqItemStructure.twig',
								'layout' => [
									'rfq_material_form' => [
										'controller' => RfqMaterialQuotationEditController::class,
										'action' => 'outputRfqMaterialForm',
									],
									'rfq_material_list' => [
										'controller' => RfqMaterialQuotationIndexController::class,
										'action' => 'outputRfqMaterialList',
									],
									'rfq_item' => [
										'controller' => RfqIndexController::class,
										'action' => 'outputRfqItem',
									],
									'rfq_vendor_company_menu' => [
										'controller' => RfqIndexController::class,
										'action' => 'outputRfqVendorCompanyMenu',
									],
									'rfq_item_url_back' => [
										'controller' => RfqIndexController::class,
										'action' => 'outputRfqItemUrlBack',
									],
								],
							],
						],
					],
				],
			],
			'children' => [
				'' => [
					'route' => '',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => RfqMaterialQuotationIndexController::class,
						'action' => 'outputRfqMaterialList',
					],
				],
			],
		],
		'/rfq/rfq_id' => [
			'route' => '/rfq/:rfq_id',
			'ajax' => FALSE,
			'constraints' => [
				'rfq_id' => '[0-9]+',
				'rfq_cross_vendor_company_id' => '[0-9]+',
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
								'template' => 'vendorRfqItemStructure.twig',
								'layout' => [
									'rfq_material_form' => [
										'controller' => RfqMaterialQuotationEditController::class,
										'action' => 'outputRfqMaterialForm',
									],
									'rfq_material_list' => [
										'controller' => RfqMaterialQuotationIndexController::class,
										'action' => 'outputRfqMaterialList',
									],
									'rfq_item' => [
										'controller' => RfqIndexController::class,
										'action' => 'outputRfqItem',
									],
									'rfq_vendor_company_menu' => [
										'controller' => RfqIndexController::class,
										'action' => 'outputRfqVendorCompanyMenu',
									],
									'rfq_item_url_back' => [
										'controller' => RfqIndexController::class,
										'action' => 'outputRfqItemUrlBack',
									],
								],
							],
						],
					],
				],
			],
			'children' => [
				'' => [
					'route' => '',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => RfqMaterialQuotationIndexController::class,
						'action' => 'outputRfqMaterialList',
					],
				],
				'/get' => [
					'route' => '/get/:rfq_cross_material_id/:rfq_cross_vendor_company_id',
					'ajax' => TRUE,
					'constraints' => [
						'rfq_cross_material_id' => '[0-9]+',
						'rfq_cross_vendor_company_id' => '[0-9]+',
					],
					'trigger' => [
						'controller' => RfqMaterialQuotationEditController::class,
						'action' => 'actionRfqMaterialGet',
					],
				],
				'/add' => [
					'route' => '/add/:rfq_cross_material_id/:rfq_cross_vendor_company_id',
					'ajax' => TRUE,
					'constraints' => [
						'rfq_cross_material_id' => '[0-9]+',
						'rfq_cross_vendor_company_id' => '[0-9]+',
					],
					'trigger' => [
						'controller' => RfqMaterialQuotationEditController::class,
						'action' => 'actionRfqMaterialAdd',
					],
				],
				'/delete' => [
					'route' => '/delete/:rfq_cross_material_id/:rfq_cross_vendor_company_id',
					'ajax' => TRUE,
					'constraints' => [
						'rfq_cross_material_id' => '[0-9]+',
						'rfq_cross_vendor_company_id' => '[0-9]+',
					],
					'trigger' => [
						'controller' => RfqMaterialQuotationEditController::class,
						'action' => 'actionRfqMaterialDelete',
					],
				],
				'/update' => [
					'route' => '/update/:rfq_cross_material_id/:rfq_cross_vendor_company_id',
					'ajax' => TRUE,
					'constraints' => [
						'rfq_cross_material_id' => '[0-9]+',
						'rfq_cross_vendor_company_id' => '[0-9]+',
					],
					'trigger' => [
						'controller' => RfqMaterialQuotationEditController::class,
						'action' => 'actionRfqMaterialUpdate',
					],
				],
			],
		],
	];
}
