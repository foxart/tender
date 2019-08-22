<?php

namespace tender\vendor\modules\detail\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\common\modules\geo\models\GeoModel;
use tender\vendor\modules\detail\models\DetailEditModel;

class DetailEditController extends Controller {

	private function GeoModel() {
		return GeoModel::instance();
	}

	private function Model() {
		return DetailEditModel::instance();
	}

	public function actionDetailGet() {
		$account = faf::session()->get('account');

		return json_encode($this->Model()->detailGet($account['id'], faf::router()->matches['company']));
	}

	public function actionDetailAdd() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->addValidator('detail_country', function () {
			return $this->GeoModel()->countryCheck(faf::request()->post('detail_country'));
		})->addValidator('detail_region', function () {
			return $this->GeoModel()->regionCheck(faf::request()->post('detail_country'), faf::request()->post('detail_region'));
		})->addValidator('detail_city', function () {
			return $this->GeoModel()->cityCheck(faf::request()->post('detail_country'), faf::request()->post('detail_region'),
				faf::request()->post('detail_city'));
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->detailAdd($account['id'], faf::router()->matches['company']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionDetailUpdate() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->addValidator('detail_country', function () {
			return $this->GeoModel()->countryCheck(faf::request()->post('detail_country'));
		})->addValidator('detail_region', function () {
			return $this->GeoModel()->regionCheck(faf::request()->post('detail_country'), faf::request()->post('detail_region'));
		})->addValidator('detail_city', function () {
			return $this->GeoModel()->cityCheck(faf::request()->post('detail_country'), faf::request()->post('detail_region'),
				faf::request()->post('detail_city'));
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->detailUpdate($account['id'], faf::router()->matches['company']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}
}
