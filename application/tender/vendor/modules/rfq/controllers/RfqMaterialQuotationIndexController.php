<?php

namespace tender\vendor\modules\rfq\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\rfq\models\RfqMaterialQuotationIndexModel;
use tender\vendor\modules\rfq\views\RfqMaterialQuotationView;

class RfqMaterialQuotationIndexController extends Controller {

	private function Model() {
		return RfqMaterialQuotationIndexModel::instance();
	}

	private function View() {
		return RfqMaterialQuotationView::instance();
	}

	public function outputRfqMaterialList() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches('rfq_id');
		$vendor_company_id = faf::router()->matches('vendor_company_id');
		$model = $this->Model()->getRfqMaterialList($account['id'], $rfq_id, $vendor_company_id);

		return $this->View()->renderRfqMaterialList($model);
	}
}
