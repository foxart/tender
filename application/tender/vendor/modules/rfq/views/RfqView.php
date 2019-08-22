<?php

namespace tender\vendor\modules\rfq\views;

use fa\classes\View;
use fa\core\faf;

class RfqView extends View {

	public static $instance;
//	private function Model() {
//		return VendorRfqIndexModel::instance();
//	}
	public function renderRfqList($data) {
//		$rfq_id = faf::router()->matches['rfq_id'];
//		dump($data);
		$rfq_list = [];
		foreach ($data as $key => $value) {
			$company_metadata_delete = faf::converter()->arrayToMetadata([
				'title' => 'Remove company',
				'disable' => [],
				'modal' => '#rfq-company-form-delete',
				'container' => '#rfq_company_list',
//				'populate' => faf::router()->urlTo('/rfq/rfq_id/company/get', [
//					'rfq_id' => $rfq_id,
//					'company-id' => $value['company_id'],
//				]),
//				'submit' => faf::router()->urlTo('/rfq/rfq_id/company/delete', [
//					'rfq_id' => $rfq_id,
//					'company-id' => $value['company_id'],
//				]),
//				'reload' => faf::router()->urlTo('/rfq/rfq_id/company/ajax', [
//					'rfq_id' => $rfq_id,
//				]),
			]);
			$company_link_delete = faf::html()->a([
				'title' => 'View',
				'href' => faf::router()->urlTo('/rfq/rfq_id', [
					'rfq_id' => $value['rfq_id'],
					'rfq_cross_vendor_company_id' => NULL,
				]),
			], 'View');
			$rfq_list[] = [
				'№' => $value['row'],
				'Reference №' => $value['rfq_id'],
				'Company' => $value['purchaser_company_name'],
				'Purchase group' => $value['rfq_name'],
				'Quotation submission last date' => $value['rfq_date_quote'],
				'Question submission last date' => $value['rfq_date_question'],
				'Remarks' => $value['rfq_remark'],
				'Terms' => $value['rfq_term'],
				'Status' => $value['rfq_status'],
//				'Company' => $value['company_name'],
				'Action' => $company_link_delete,
			];
		}
//		$rfq_id = faf::router()->matches['rfq_id'];
		$company_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'Assign company',
			'modal' => '#rfq-company-form',
			'container' => '#rfq_company_list',
//			'select' => faf::router()->urlTo('/rfq/rfq_id/company/select', [
//				'rfq_id' => $rfq_id,
//			]),
//			'submit' => faf::router()->urlTo('/rfq/rfq_id/company/add', [
//				'rfq_id' => $rfq_id,
//			]),
//			'reload' => faf::router()->urlTo('/rfq/rfq_id/company/ajax', [
//				'rfq_id' => $rfq_id,
//			]),
		]);

		return $this->template()->load('rfq/vendorRfqList.twig')->set([
			'rfq_list' => faf::table()->arrayToTable($rfq_list),
//			'rfq_list' => faf::table()->arrayToTable($data),
		])->set([//			'company_metadata_add' => $company_metadata_add,
		])->render();
	}

	public function renderRfqListFilter() {
		return $this->template()->load('rfq/vendorRfqListFilter.twig')->set([])->render();
	}

	public function renderRfqItem($data) {
//		return faf::debug()->dump($data, FALSE);
		$rfq_metadata_update = faf::converter()->arrayToMetadata([
			'title' => 'Change RFQ',
			'modal' => '#rfq-form',
//			'disable' => [
//				'rfq_company_id',
//			],
//			'container' => '#rfq_item',
//			'populate' => faf::router()->urlTo('/rfq/rfq_id/get', [
//				'rfq_id' => $data['rfq_id'],
//			]),
//			'submit' => faf::router()->urlTo('/rfq/rfq_id/update', [
//				'rfq_id' => $data['rfq_id'],
//			]),
//			'reload' => faf::router()->urlTo('/rfq/rfq_id/ajax', [
//				'rfq_id' => $data['rfq_id'],
//			]),
		]);

		return $this->template()->load('rfq/vendorRfqItem.twig')->set([
			'rfq_id' => $data['rfq_id'],
			'rfq_status' => $data['rfq_status'],
			'rfq_date_publish' => $data['rfq_date_publish'],
			'rfq_date_question' => $data['rfq_date_question'],
			'rfq_date_quote' => $data['rfq_date_quote'],
			'rfq_name' => $data['rfq_name'],
			'rfq_remark' => nl2br($data['rfq_remark']),
			'rfq_term' => nl2br($data['rfq_term']),
			'company_name' => $data['company_name'],
		])->set([//			'rfq_metadata_update' => $rfq_metadata_update,
		])->render();
	}

	public function renderRfqItemUrlBack() {
		return faf::router()->urlTo('/rfq');
	}

	public function renderRfqCompanyForm() {
//		return $this->template()->load('rfq/purchaserRfqCompanyForm.twig')->set([])->render();
	}

	public function renderRfqCompanyFormDelete() {
//		return $this->template()->load('rfq/purchaserRfqCompanyFormDelete.twig')->set([])->render();
	}
}
