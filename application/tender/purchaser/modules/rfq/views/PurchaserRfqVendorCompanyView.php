<?php

namespace tender\purchaser\modules\rfq\views;

use fa\classes\View;
use fa\core\faf;

class PurchaserRfqVendorCompanyView extends View {

	public static $instance;

	public function renderRfqVendorCompanyList($data) {

//		dump($data);
//			exit;

		$rfq_id = faf::router()->matches['rfq_id'];
		$company_list = [];
		foreach ($data as $key => $value) {
			$company_metadata_delete = faf::converter()->arrayToMetadata([
				'title' => 'Remove company',
				'disable' => [],
				'modal' => '#rfq-company-form-delete',
				'container' => '#rfq_company_list',
				'populate' => faf::router()->urlTo('/rfq/rfq_id/change/company/get', [
					'rfq_id' => $rfq_id,
					'company-id' => $value['vendor_company_id'],
				]),
				'submit' => faf::router()->urlTo('/rfq/rfq_id/change/company/delete', [
					'rfq_id' => $rfq_id,
					'company-id' => $value['vendor_company_id'],
				]),
				'reload' => faf::router()->urlTo('/rfq/rfq_id/change/company/ajax', [
					'rfq_id' => $rfq_id,
				]),
			]);
			$company_link_delete = faf::html()->a([
				'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $company_metadata_delete,
				'title' => 'Change',
				'href' => '#',
			], '');
			$company_list[] = [
				'№' => $value['row'],
				'code' => $value['vendor_company_id'],
//				'name' => $value['vendor_company_name'],
				'name' => faf::html()->a([
					'class'=>'fa-js-blank',
					'href'=>faf::router()->urlTo('/profile/purchaser_company_id/vendor_company_id',[
						'vendor_company_id'=>$value['vendor_company_id']
					])
				], $value['vendor_company_name']),
				'title' => $value['vendor_company_title_name'],
				'type' => $value['vendor_company_type_name'],
				'action' => $company_link_delete,
			];
		}
		$rfq_id = faf::router()->matches['rfq_id'];
		$company_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'Assign company',
			'modal' => '#rfq-company-form',
			'container' => '#rfq_company_list',
			'select' => faf::router()->urlTo('/rfq/rfq_id/change/company/select', [
				'rfq_id' => $rfq_id,
			]),
			'submit' => faf::router()->urlTo('/rfq/rfq_id/change/company/add', [
				'rfq_id' => $rfq_id,
			]),
			'reload' => faf::router()->urlTo('/rfq/rfq_id/change/company/ajax', [
				'rfq_id' => $rfq_id,
			]),
		]);

		return $this->template()->load('rfq/purchaserRfqCompanyList.twig')->set([
			'company_list' => faf::table()->arrayToTable($company_list, [
				'class' => 'table table-bordered table-condensed table-hover table-striped',
			]),
//			'company_list' => faf::table()->arrayToTable($data),
		])->set([
			'company_metadata_add' => $company_metadata_add,
		])->render();
	}

	public function renderRfqVendorCompanyForm() {
		return $this->template()->load('rfq/purchaserRfqCompanyForm.twig')->set([])->render();
	}

	public function renderRfqVendorCompanyFormDelete() {
		return $this->template()->load('rfq/purchaserRfqCompanyFormDelete.twig')->set([])->render();
	}
}
