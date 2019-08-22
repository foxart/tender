<?php

namespace tender\purchaser\modules\rfq\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\purchaser\modules\rfq\models\PurchaserRfqCompanyIndexModel;
use tender\purchaser\modules\rfq\views\PurchaserRfqVendorCompanyView;

class PurchaserRfqVendorCompanyIndexController extends Controller {

	private function Model() {
		return PurchaserRfqCompanyIndexModel::instance();
	}

	private function View() {
		return PurchaserRfqVendorCompanyView::instance();
	}

	public function outputRfqCompanyList() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$model = $this->Model()->getRfqVendorCompanyList($account['id'], $rfq_id);

		return $this->View()->renderRfqVendorCompanyList($model);
	}
}
