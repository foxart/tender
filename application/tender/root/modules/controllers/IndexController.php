<?php

namespace tender\root\modules\controllers;

use fa\classes\Controller;
use tender\root\modules\models\MaintenanceModel;
use tender\root\modules\views\IndexView;

class IndexController extends Controller {

	public function View() {
		return IndexView::instance();
	}

	public function Model() {
		return MaintenanceModel::instance();
	}

	public function actionHome() {
		return NULL;
	}
}
