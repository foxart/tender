<?php

namespace tender\purchaser\modules\rfq\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\purchaser\modules\rfq\models\PurchaserRfqQuotationIndexModel;
use tender\purchaser\modules\rfq\views\PurchaserRfqQuotationView;

class PurchaserRfqQuotationIndexController extends Controller {

	private function Model() {
		return PurchaserRfqQuotationIndexModel::instance();
	}

	private function View() {
		return PurchaserRfqQuotationView::instance();
	}

	public function outputRfqQuotationList() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$model = $this->Model()->getRfqQuotationList($account['id'], $rfq_id);

		return $this->View()->renderRfqQuotationList($model);
	}
}
