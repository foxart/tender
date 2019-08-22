<?php

namespace tender\purchaser\modules\rfq\views;

use fa\classes\View;
use fa\core\faf;

class PurchaserRfqQuotationView extends View {

	public static $instance;

	public function renderRfqQuotationList($data) {
		$material_list = [];
		foreach ($data as $key => $value) {

			$rfq_link_vendor = faf::html()->a([
				'class' => 'fa-js-blank',
				'style'=>'display: inline-block; word-break: break-all;',
				'title' => 'Change',
				'href' => faf::router()->urlTo('/profile/purchaser_company_id/vendor_company_id', [
					'purchaser_company_id' => $value['purchaser_company_id'],
					'vendor_company_id' => $value['vendor_company_id'],
				]),
			], $value['vendor_company_name']);

			$rfq_metadata_update = faf::converter()->arrayToMetadata([
				'title' => 'Change material',
				'disable' => [
					'material_name',
				],
				'modal' => '#rfq-material-form',
				'container' => '#rfq_material_list',
				'populate' => faf::router()->urlTo('/rfq/rfq_id/change/material/get', [
					'rfq_id' => $value['rfq_id'],
					'material-id' => $value['material_id'],
				]),
				'submit' => faf::router()->urlTo('/rfq/rfq_id/change/material/update', [
					'rfq_id' => $value['rfq_id'],
					'material-id' => $value['material_id'],
				]),
				'reload' => faf::router()->urlTo('/rfq/rfq_id/change/material/ajax', [
					'rfq_id' => $value['rfq_id'],
				]),
			]);
			$rfq_link_update = faf::html()->a([
				'class' => 'glyphicon glyphicon-pencil bs-modal-link ' . $rfq_metadata_update,
				'title' => 'Change',
				'href' => '#',
			], '');
			$rfq_metadata_delete = faf::converter()->arrayToMetadata([
				'title' => 'Detach material',
				'disable' => [],
				'modal' => '#rfq-material-form',
				'container' => '#rfq_material_list',
				'populate' => faf::router()->urlTo('/rfq/rfq_id/change/material/get', [
					'rfq_id' => $value['rfq_id'],
					'material-id' => $value['material_id'],
				]),
				'submit' => faf::router()->urlTo('/rfq/rfq_id/change/material/delete', [
					'rfq_id' => $value['rfq_id'],
					'material-id' => $value['material_id'],
				]),
				'reload' => faf::router()->urlTo('/rfq/rfq_id/change/material/ajax', [
					'rfq_id' => $value['rfq_id'],
				]),
			]);
			$rfq_link_delete = faf::html()->a([
				'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $rfq_metadata_delete,
				'title' => 'Delete',
				'href' => '#',
			], '');
			$material_list[] = [
				'№' => $value['row'],
//				'Reference №' => $value['rfq_id'],
				'material code' => $value['material_id'],
//				'group' => $value['material_group_name'],
				'material name' => faf::html()->span([
					'style'=>'display: inline-block; word-break: break-all;'
				],$value['material_name']),
				'material uom' => $value['material_uom_name'],
				'material quatity' => $value['rfq_cross_material_quantity'],
				'delivery date' => $value['rfq_quotation_delivery_date'],
				'delivery cost' => $value['rfq_quotation_delivery_cost'],
				'quantity' => $value['rfq_quotation_quantity'],
				'tax cost' => $value['rfq_quotation_tax_cost'],
				'total cost' => $value['rfq_quotation_total_cost'],
				'unit cost' => $value['rfq_quotation_unit_cost'],
				'vendor' => $rfq_link_vendor,
//				'po' => nl2br($value['material_po']),
				'action' => $rfq_link_update . '&nbsp;' . $rfq_link_delete,
			];
		}
		$rfq_id = faf::router()->matches['rfq_id'];
//		$rfq_metadata_add = faf::converter()->arrayToMetadata([
//			'title' => 'Attach material',
//			'modal' => '#rfq-material-form-add',
//			'container' => '#rfq_material_list',
//			'select' => faf::router()->urlTo('/rfq/rfq_id/change/material/select', [
//				'rfq_id' => $rfq_id,
//			]),
//			'submit' => faf::router()->urlTo('/rfq/rfq_id/change/material/add', [
//				'rfq_id' => $rfq_id,
//			]),
//			'reload' => faf::router()->urlTo('/rfq/rfq_id/change/material/ajax', [
//				'rfq_id' => $rfq_id,
//			]),
//		]);

		return $this->template()->load('rfq/purchaserRfqQuotationList.twig')->set([
			'rfq_quotation_list' => faf::table()->arrayToTable($material_list, [
//			'rfq_quotation_list' => faf::table()->arrayToTable($data, [
				'class' => 'table table-bordered table-condensed table-hover table-striped',
			]),
		])->set([
//			'rfq_item_material_metadata_add' => $rfq_metadata_add,
		])->render();
	}

	public function renderRfqMaterialForm() {
		return $this->template()->load('rfq/purchaserRfqMaterialFormAdd.twig')->set([])->render();
	}

	public function renderRfqMaterialFormDelete() {
		return $this->template()->load('rfq/purchaserRfqMaterialForm.twig')->set([])->render();
	}
}
