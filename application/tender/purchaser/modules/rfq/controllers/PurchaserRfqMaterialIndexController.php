<?php

namespace tender\purchaser\modules\rfq\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\purchaser\modules\rfq\models\PurchaserRfqMaterialIndexModel;
use tender\purchaser\modules\rfq\views\PurchaserRfqMaterialView;

class PurchaserRfqMaterialIndexController extends Controller {

	private function Model() {
		return PurchaserRfqMaterialIndexModel::instance();
	}

	private function View() {
		return PurchaserRfqMaterialView::instance();
	}

	public function outputRfqMaterialList() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$model = $this->Model()->getRfqMaterialList($account['id'], $rfq_id);

		return $this->View()->renderRfqMaterialList($model);
	}
}
