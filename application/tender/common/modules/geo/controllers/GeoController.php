<?php

namespace tender\common\modules\geo\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\common\modules\geo\models\GeoModel;

class GeoController extends Controller {

	private function Model() {
		return GeoModel::instance();
	}

//	private function View() {
//		return GeoView::instance();
//	}
	/*
	 * AJAX
	 */
	public function actionCountry() {
		$limit = 10;
		$company_list = $this->Model()->load(faf::request()->get())->countryList($limit);

		return json_encode($company_list);
	}

	public function actionRegion() {
		$limit = 10;
		$company_list = $this->Model()->load(faf::request()->get())->regionList($limit);

		return json_encode($company_list);
	}

	public function actionCity() {
		$limit = 10;
		$company_list = $this->Model()->load(faf::request()->get())->cityList($limit);

		return json_encode($company_list);
	}
}
