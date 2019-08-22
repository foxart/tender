<?php

namespace tender\purchaser\modules\rfq\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\purchaser\modules\rfq\models\PurchaserRfqCompanyEditModel;
use tender\purchaser\modules\rfq\views\PurchaserRfqVendorCompanyView;

class PurchaserRfqVendorCompanyEditController extends Controller {

	private function Model() {
		return PurchaserRfqCompanyEditModel::instance();
	}

	private function View() {
		return PurchaserRfqVendorCompanyView::instance();
	}

	public function actionRfqCompanySelect() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$company_name = faf::request()->get('query_string');
		$data = $this->Model()->rfqVendorCompanySelect($account['id'], $rfq_id, $company_name);

		return json_encode([
			'items' => $data,
		]);
	}

	public function actionRfqCompanyGet() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$company_id = faf::router()->matches['company-id'];

		return json_encode($this->Model()->rfqVendorCompanyGet($account['id'], $rfq_id, $company_id));
	}

	public function actionRfqCompanyAdd() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$company_id_array = faf::request()->post('company_id');
		$this->Model()->addValidator('company_id[]', function () {
			if (faf::request()->post('company_id') === NULL) {
				return 'please enter company';
			} else {
				return TRUE;
			}
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->rfqVendorCompanyAdd($account['id'], $rfq_id, $company_id_array);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionRfqCompanyDelete() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$company_id = faf::router()->matches['company-id'];

		return $this->Model()->rfqCompanyDelete($account['id'], $rfq_id, $company_id);
	}

	public function outputRfqCompanyForm() {
		return $this->View()->renderRfqVendorCompanyForm();
	}

	public function outputRfqCompanyFormDelete() {
		return $this->View()->renderRfqVendorCompanyFormDelete();
	}
}
