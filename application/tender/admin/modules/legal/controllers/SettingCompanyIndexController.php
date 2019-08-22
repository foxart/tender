<?php

namespace tender\admin\modules\legal\controllers;

use fa\classes\Controller;
use tender\admin\modules\legal\models\SettingCompanyIndexModel;
use tender\admin\modules\legal\views\SettingCompanyView;

class SettingCompanyIndexController extends Controller {

	/**
	 * @return SettingCompanyIndexModel
	 */
	private function IndexModel() {
		return SettingCompanyIndexModel::instance();
	}

	/**
	 * @return SettingCompanyView
	 */
	private function View() {
		return SettingCompanyView::instance();
	}

	public function actionCompanyList() {
		$company_list = $this->IndexModel()->getCompanyList();

		return $this->View()->renderIndexPage($company_list);
	}
}
