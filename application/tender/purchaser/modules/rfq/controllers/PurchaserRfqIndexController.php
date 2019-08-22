<?php

namespace tender\purchaser\modules\rfq\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\purchaser\modules\rfq\models\PurchaserRfqIndexModel;
use tender\purchaser\modules\rfq\views\PurchaserRfqView;

class PurchaserRfqIndexController extends Controller {

	private function Model() {
		return PurchaserRfqIndexModel::instance();
	}

	private function View() {
		return PurchaserRfqView::instance();
	}

	public function outputRfqList() {
		$account = faf::session()->get('account');
		$model = $this->Model()->getRfqList($account['id']);

		return $this->View()->renderRfqList($model);
	}

	public function outputRfqListFilter() {
		return $this->View()->renderRfqListFilter();
	}

	public function outputRfqItem() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$model = $this->Model()->getRfqItem($account['id'], $rfq_id);

		return $this->View()->renderRfqItem($model);
	}


	public function outputRfqItemUpdateLink() {
		return $this->View()->renderRfqItemUpdateLink();
	}

	public function outputRfqItemUrlBack() {
		return $this->View()->renderRfqItemUrlBack();
	}
}
