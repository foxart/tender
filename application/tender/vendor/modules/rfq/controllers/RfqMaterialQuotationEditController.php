<?php

namespace tender\vendor\modules\rfq\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\rfq\models\RfqMaterialQuotationEditModel;
use tender\vendor\modules\rfq\views\RfqMaterialQuotationView;

class RfqMaterialQuotationEditController extends Controller {

	private function Model() {
		return RfqMaterialQuotationEditModel::instance();
	}

	private function View() {
		return RfqMaterialQuotationView::instance();
	}

	/* output */
	public function outputRfqMaterialForm() {
		return $this->View()->renderRfqMaterialForm();
	}

	/* action */
	public function actionRfqMaterialGet() {
		$account = faf::session()->get('account');

		return json_encode($this->Model()->rfqMaterialGet($account['id'], faf::router()->matches()));
	}

	public function actionRfqMaterialAdd() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->addValidator('rfq_material_fake', function () use ($account) {
			if ($this->Model()->rfqMaterialAddCheck($account['id'], faf::router()->matches()) == 0) {
				return TRUE;
			} else {
				return 'bid already placed';
			}
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->rfqMaterialAdd($account['id'], faf::router()->matches());
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionRfqMaterialDelete() {
		$account = faf::session()->get('account');

		return $this->Model()->rfqMaterialDelete($account['id'], faf::router()->matches());
	}

	public function actionRfqMaterialUpdate() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->rfqMaterialUpdate($account['id'], faf::router()->matches());
		} else {
			return $this->Model()->errorsToJson();
		}
	}
}
