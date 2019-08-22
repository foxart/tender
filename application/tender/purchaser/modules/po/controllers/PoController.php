<?php

namespace tender\purchaser\modules\po\controllers;

use fa\classes\Controller;
use tender\purchaser\modules\po\models\PoModel;
use tender\purchaser\modules\po\views\PoView;

class PoController extends Controller {

	private function Model() {
		return PoModel::instance();
	}

	private function View() {
		return PoView::instance();
	}

	public function actionPo() {
		return $this->View()->renderPo();
	}

	public function actionDelivery() {
		return $this->View()->renderDelivery();
	}

	public function actionDispatch() {
		return $this->View()->renderDispatch();
	}
}
