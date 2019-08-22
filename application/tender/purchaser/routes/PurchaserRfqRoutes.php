<?php

namespace tender\purchaser\routes;

use fa\classes\Layout;
use fa\classes\Route;
use tender\common\modules\account\controllers\AccountIndexController;
use tender\purchaser\configurations\DefaultHeadConfiguration;
use tender\purchaser\menus\PurchaserTopMenu;
use tender\purchaser\modules\rfq\controllers\PurchaserRfqEditController;
use tender\purchaser\modules\rfq\controllers\PurchaserRfqIndexController;
use tender\purchaser\modules\rfq\controllers\PurchaserRfqMaterialEditController;
use tender\purchaser\modules\rfq\controllers\PurchaserRfqMaterialIndexController;
use tender\purchaser\modules\rfq\controllers\PurchaserRfqQuotationIndexController;
use tender\purchaser\modules\rfq\controllers\PurchaserRfqVendorCompanyEditController;
use tender\purchaser\modules\rfq\controllers\PurchaserRfqVendorCompanyIndexController;

class PurchaserRfqRoutes extends Route {

	public static $map = [
		'/rfq' => [
			'route' => '/rfq',
			'ajax' => FALSE,
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
								'template' => 'purchaserRfqListStructure.twig',
								'layout' => [
									'rfq_form' => [
										'controller' => PurchaserRfqEditController::class,
										'action' => 'outputRfqForm',
									],
									'rfq_list_filter' => [
										'controller' => PurchaserRfqIndexController::class,
										'action' => 'outputRfqListFilter',
									],
									'rfq_list' => [
										'controller' => PurchaserRfqIndexController::class,
										'action' => 'outputRfqList',
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
						'controller' => PurchaserRfqIndexController::class,
						'action' => 'outputRfqList',
					],
				],
				'/add' => [
					'route' => '/add',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => PurchaserRfqEditController::class,
						'action' => 'actionRfqAdd',
					],
				],
			],
		],
		'/rfq/rfq_id/change' => [
			'route' => '/rfq/:rfq_id/change',
			'ajax' => FALSE,
			'constraints' => [
				'rfq_id' => '[0-9]+',
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
								'template' => 'purchaserRfqItemChangeStructure.twig',
								'layout' => [
									'rfq_form' => [
										'controller' => PurchaserRfqEditController::class,
										'action' => 'outputRfqForm',
									],
									'rfq_item_change_url_back' => [
										'controller' => PurchaserRfqIndexController::class,
										'action' => 'outputRfqItemUrlBack',
									],
									'rfq_item' => [
										'controller' => PurchaserRfqIndexController::class,
										'action' => 'outputRfqItem',
									],
									'rfq_item_update_link' => [
										'controller' => PurchaserRfqIndexController::class,
										'action' => 'outputRfqItemUpdateLink',
									],
									/* material */
									'rfq_material_form' => [
										'controller' => PurchaserRfqMaterialEditController::class,
										'action' => 'outputRfqMaterialForm',
									],
									'rfq_material_form_delete' => [
										'controller' => PurchaserRfqMaterialEditController::class,
										'action' => 'outputRfqMaterialFormDelete',
									],
									'rfq_material_list' => [
										'controller' => PurchaserRfqMaterialIndexController::class,
										'action' => 'outputRfqMaterialList',
									],
									/* company */
									'rfq_company_form' => [
										'controller' => PurchaserRfqVendorCompanyEditController::class,
										'action' => 'outputRfqCompanyForm',
									],
									'rfq_company_form_delete' => [
										'controller' => PurchaserRfqVendorCompanyEditController::class,
										'action' => 'outputRfqCompanyFormDelete',
									],
									'rfq_company_list' => [
										'controller' => PurchaserRfqVendorCompanyIndexController::class,
										'action' => 'outputRfqCompanyList',
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
						'controller' => PurchaserRfqIndexController::class,
						'action' => 'outputRfqItem',
					],
				],
				'/get' => [
					'route' => '/get',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => PurchaserRfqEditController::class,
						'action' => 'actionRfqGet',
					],
				],
				'/update' => [
					'route' => '/update',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => PurchaserRfqEditController::class,
						'action' => 'actionRfqUpdate',
					],
				],
				'/delete' => [
					'route' => '/delete',
					'ajax' => TRUE,
					'trigger' => [
						'controller' => PurchaserRfqEditController::class,
						'action' => 'actionRfqDelete',
					],
				],

				/* MATERIAL */
				'/material' => [
					'route' => '/material',
					'behaviour' => 'virtual',
					'trigger' => [
						'controller' => PurchaserRfqMaterialIndexController::class,
						'action' => 'outputRfqMaterialList',
					],
					'children' => [
						'/ajax' => [
							'route' => '',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqMaterialIndexController::class,
								'action' => 'outputRfqMaterialList',
							],
						],
						'/select' => [
							'route' => '/select',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqMaterialEditController::class,
								'action' => 'actionRfqMaterialSelect',
							],
						],
						'/get' => [
							'route' => '/get/:material-id',
							'constraints' => [
								'material-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqMaterialEditController::class,
								'action' => 'actionRfqMaterialGet',
							],
						],
						'/add' => [
							'route' => '/add',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqMaterialEditController::class,
								'action' => 'actionRfqMaterialAdd',
							],
						],
						'/update' => [
							'route' => '/update/:material-id',
							'constraints' => [
								'material-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqMaterialEditController::class,
								'action' => 'actionRfqMaterialUpdate',
							],
						],
						'/delete' => [
							'route' => '/delete/:material-id',
							'constraints' => [
								'material-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqMaterialEditController::class,
								'action' => 'actionRfqMaterialDelete',
							],
						],
					],
				],
				/* COMPANY */
				'/company' => [
					'route' => '/company',
					'ajax' => FALSE,
					'trigger' => [
						'controller' => PurchaserRfqVendorCompanyIndexController::class,
						'action' => 'outputRfqCompanyList',
					],
					'children' => [
						'/ajax' => [
							'route' => '',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqVendorCompanyIndexController::class,
								'action' => 'outputRfqCompanyList',
							],
						],
						'/select' => [
							'route' => '/select',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqVendorCompanyEditController::class,
								'action' => 'actionRfqCompanySelect',
							],
						],
						'/add' => [
							'route' => '/add',
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqVendorCompanyEditController::class,
								'action' => 'actionRfqCompanyAdd',
							],
						],
						'/get' => [
							'route' => '/get/:company-id',
							'constraints' => [
								'company-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqVendorCompanyEditController::class,
								'action' => 'actionRfqCompanyGet',
							],
						],
						'/delete' => [
							'route' => '/delete/:company-id',
							'constraints' => [
								'company-id' => '[0-9]+',
							],
							'ajax' => TRUE,
							'trigger' => [
								'controller' => PurchaserRfqVendorCompanyEditController::class,
								'action' => 'actionRfqCompanyDelete',
							],
						],
					],
				],
			],
		],
		/*
		 * QUOTATION
		 */

//		'/quotation' => [
//			'route' => '/quotation',
//			'ajax' => FALSE,
//			'trigger' => [
//				'controller' => PurchaserRfqQuotationIndexController::class,
//				'action' => 'outputRfqQuotationList',
//			],
//		],
		'/rfq/rfq_id/quotation' => [
			'route' => '/rfq/:rfq_id/quotation',
			'constraints' => [
				'rfq_id' => '[0-9]+',
			],
			'ajax' => FALSE,
			'trigger' => [
//				'controller' => PurchaserRfqQuotationIndexController::class,
//				'action' => 'outputRfqQuotationList',
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
								'template' => 'purchaserRfqItemQuotationStructure.twig',
								'layout' => [
//									'rfq_form' => [
//										'controller' => PurchaserRfqEditController::class,
//										'action' => 'outputRfqForm',
//									],
									'rfq_item_quotation_url_back' => [
										'controller' => PurchaserRfqIndexController::class,
										'action' => 'outputRfqItemUrlBack',
									],
									'rfq_item' => [
										'controller' => PurchaserRfqIndexController::class,
										'action' => 'outputRfqItem',
									],
									/*
									 * MATERIAL
									 */
//									'rfq_material_form' => [
//										'controller' => PurchaserRfqMaterialEditController::class,
//										'action' => 'outputRfqMaterialForm',
//									],
//									'rfq_material_form_delete' => [
//										'controller' => PurchaserRfqMaterialEditController::class,
//										'action' => 'outputRfqMaterialFormDelete',
//									],
									'rfq_quotation_list' => [
										'controller' => PurchaserRfqQuotationIndexController::class,
										'action' => 'outputRfqQuotationList',
									],
									/*
									 * COMPANY
									 */
//									'rfq_company_form' => [
//										'controller' => PurchaserRfqVendorCompanyEditController::class,
//										'action' => 'outputRfqCompanyForm',
//									],
//									'rfq_company_form_delete' => [
//										'controller' => PurchaserRfqVendorCompanyEditController::class,
//										'action' => 'outputRfqCompanyFormDelete',
//									],
//									'rfq_company_list' => [
//										'controller' => PurchaserRfqVendorCompanyIndexController::class,
//										'action' => 'outputRfqCompanyList',
//									],
								],
							],
						],
					],
					],
			],
		],
	];
}
