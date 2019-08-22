<?php

namespace tender\purchaser\modules\overview\controllers;

use fa\classes\Controller;
use tender\purchaser\modules\overview\models\OverviewModel;
use tender\purchaser\modules\overview\views\OverviewView;

class OverviewController extends Controller {

	private function Model() {
		return OverviewModel::instance();
	}

	private function View() {
		return OverviewView::instance();
	}

	public function actionOverview() {
		return $this->View()->renderOverview();
	}
}
