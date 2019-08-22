<?php

namespace tender\vendor\modules\rfq\views;

use fa\classes\View;
use fa\core\faf;

class RfqMaterialQuotationView extends View {

	public static $instance;

	public function renderRfqMaterialList($data) {
		$material_list = [];
		foreach ($data as $key => $value) {
			$rfq_material_metadata_add = faf::converter()->arrayToMetadata([
				'title' => 'Place bid',
				'modal' => '#rfq-material-form',
				'container' => '#rfq_material_list',
				'submit' => faf::router()->urlTo('/rfq/rfq_id/add', [
					'rfq_id' => $value['rfq_id'],
					'rfq_cross_material_id' => $value['rfq_cross_material_id'],
					'rfq_cross_vendor_company_id' => $value['rfq_cross_vendor_company_id'],
				]),
//				'reload' => faf::router()->urlTo('/rfq/rfq_id', [
//					'rfq_id' => $value['rfq_id'],
//				]),
				'reload' => faf::router()->urlTo(faf::router()->route, faf::router()->matches),
			]);
			$rfq_material_metadata_delete = faf::converter()->arrayToMetadata([
				'title' => 'Remove bid',
				'modal' => '#rfq-material-form',
				'container' => '#rfq_material_list',
				'disable' => [],
				'submit' => faf::router()->urlTo('/rfq/rfq_id/delete', [
					'rfq_id' => $value['rfq_id'],
					'rfq_cross_material_id' => $value['rfq_cross_material_id'],
					'rfq_cross_vendor_company_id' => $value['rfq_cross_vendor_company_id'],
				]),
				'populate' => faf::router()->urlTo('/rfq/rfq_id/get', [
					'rfq_id' => $value['rfq_id'],
					'rfq_cross_material_id' => $value['rfq_cross_material_id'],
					'rfq_cross_vendor_company_id' => $value['rfq_cross_vendor_company_id'],
				]),
//				'reload' => faf::router()->urlTo('/rfq/rfq_id', [
//					'rfq_id' => $value['rfq_id'],
//				]),
				'reload' => faf::router()->urlTo(faf::router()->route, faf::router()->matches),
			]);
			$rfq_material_metadata_update = faf::converter()->arrayToMetadata([
				'title' => 'Change bid',
				'modal' => '#rfq-material-form',
				'container' => '#rfq_material_list',
				'submit' => faf::router()->urlTo('/rfq/rfq_id/update', [
					'rfq_id' => $value['rfq_id'],
					'rfq_cross_material_id' => $value['rfq_cross_material_id'],
					'rfq_cross_vendor_company_id' => $value['rfq_cross_vendor_company_id'],
				]),
				'populate' => faf::router()->urlTo('/rfq/rfq_id/get', [
					'rfq_id' => $value['rfq_id'],
					'rfq_cross_material_id' => $value['rfq_cross_material_id'],
					'rfq_cross_vendor_company_id' => $value['rfq_cross_vendor_company_id'],
				]),
//				'reload' => faf::router()->urlTo('/rfq/rfq_id', [
//					'rfq_id' => $value['rfq_id'],
//				]),
				'reload' => faf::router()->urlTo(faf::router()->route, faf::router()->matches),
			]);
			if ($value['rfq_material_quotation_id'] !== NULL) {
				$action = [
					faf::html()->a([
						'class' => [
							'glyphicon glyphicon-pencil bs-modal-link',
							$rfq_material_metadata_update,
						],
						'title' => 'Change bid',
						'href' => '#',
					], ''),
					faf::html()->a([
						'class' => [
							'glyphicon glyphicon-minus-sign bs-modal-link',
							$rfq_material_metadata_delete,
						],
						'title' => 'Remove bid',
						'href' => '#',
					], ''),
				];
			} else {
				$action = [
					faf::html()->a([
						'class' => [
							'glyphicon glyphicon-plus-sign bs-modal-link',
							$rfq_material_metadata_add,
						],
						'title' => 'Place bid',
						'href' => '#',
					], ''),
				];
			};
			$profile_company_link = faf::html()->a([
				'class' => 'fa-js-blank',
				'title' => 'Change',
				'href' => faf::router()->urlTo('/company/company-id', [
					'company' => $value['vendor_company_id'],
				]),
			], $value['vendor_company_name']);
			$material_list[] = [
				'№' => $value['row'],
				'code' => $value['rfq_cross_material_id'],
				'material' => $value['material_name'],
				'material quantity' => $value['rfq_material_quantity'],
				'uom' => $value['material_uom_name'],
				'company' => $profile_company_link,
				'quotation quantity' => faf::html()->span([
					'class' => 'badge',
				], $value['rfq_material_quotation_quantity']),
				'unit price' => $value['rfq_material_quotation_unit_cost'],
				'delivery date' => $value['rfq_material_quotation_delivery_date'],
				'delivery cost' => $value['rfq_material_quotation_delivery_cost'],
				'tax cost' => $value['rfq_material_quotation_tax_cost'],
				'total cost' => $value['rfq_material_quotation_total_cost'],
				'action' => faf::html()->set($action),
			];
		}

		return $this->template()->load('rfq/purchaserRfqMaterialList.twig')->set([
			'rfq_material_list' => faf::table()->arrayToTable($material_list),
		])->set([//			'rfq_item_material_metadata_add' => $rfq_metadata_add,
		])->render();
	}

	public function renderRfqMaterialForm() {
		return $this->template()->load('rfq/purchaserRfqMaterialForm.twig')->set([])->render();
	}
}
