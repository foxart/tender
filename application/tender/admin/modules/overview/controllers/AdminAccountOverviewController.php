<?php

namespace tender\admin\modules\overview\controllers;

use fa\classes\Controller;
use tender\admin\modules\overview\views\OverviewView;

class AdminAccountOverviewController extends Controller {

//	private function Model() {
//		return AccountModel::instance();
//	}
	private function View() {
		return OverviewView::instance();
	}

	public function actionOverview() {
		return $this->View()->renderIndexPage();
	}
}
