<?php

namespace tender\vendor\modules\detail\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\detail\models\DetailIndexModel;
use tender\vendor\modules\detail\views\CompanyDetailIndexView;

class DetailIndexController extends Controller {

	private function Model() {
		return DetailIndexModel::instance();
	}

	private function View() {
		return CompanyDetailIndexView::instance();
	}

	public function actionDetailItem() {
		$account = faf::session()->get('account');
		$detail = $this->Model()->detailItem($account['id'], faf::router()->matches['company']);
		if (empty($detail) === TRUE) {
			return $this->View()->renderDetailItemAdd();
		} else {
			return $this->View()->renderDetailItem($detail);
		}
	}
}
