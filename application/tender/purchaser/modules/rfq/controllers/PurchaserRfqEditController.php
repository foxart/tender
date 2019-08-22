<?php

namespace tender\purchaser\modules\rfq\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\purchaser\modules\rfq\models\PurchaserRfqEditModel;
use tender\purchaser\modules\rfq\views\PurchaserRfqView;

class PurchaserRfqEditController extends Controller {

	private function Model() {
		return PurchaserRfqEditModel::instance();
	}

	private function View() {
		return PurchaserRfqView::instance();
	}

	public function outputRfqForm() {
		$account = faf::session()->get('account');
		$company_list = $this->Model()->rfqPurchaserCompanyList($account['id']);

		return $this->View()->renderRfqForm($company_list);
	}

	public function actionRfqGet() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];

		return json_encode($this->Model()->rfqGet($account['id'], $rfq_id));
	}

	public function actionRfqAdd() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->rfqAdd($account['id']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionRfqUpdate() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$data = faf::request()->post();
		$this->Model()->load($data)->addValidator('rfq_company_id', function () use ($account, $rfq_id) {
			$count = $this->Model()->rfqUpdateCheck($account['id'], $rfq_id);
			if ($count == 0) {
				return $this->View()->displayErrorMessage('can`t change company with assigned materials');
			} else {
				return TRUE;
			}
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->rfqUpdate($account['id'], $rfq_id);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionRfqDelete() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];

		return $this->Model()->rfqDelete($account['id'], $rfq_id);
	}
}
