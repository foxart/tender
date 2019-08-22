<?php

namespace tender\vendor\modules\factory\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\modules\geo\models\GeoModel;
use tender\vendor\modules\factory\models\FactoryEditModel;

class FactoryEditController extends Controller {

	/**
	 * @return \modules\common\geo\models\CommonGeoModel
	 */
	private function GeoModel() {
		return GeoModel::instance();
	}

	/**
	 * @return \modules\tender\vendor\profile\factory\models\EditModel
	 */
	private function Model() {
		return FactoryEditModel::instance();
	}

	/*
	 * COMPANY
	 */
	public function actionFactoryGet() {
		$account = faf::session()->get('account');

		return json_encode($this->Model()->factoryGet($account['id'], faf::router()->matches['company']));
	}

	public function actionFactoryAdd() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->addValidator('factory_country', function () {
			return $this->GeoModel()->countryCheck(faf::request()->post('factory_country'));
		})->addValidator('factory_region', function () {
			return $this->GeoModel()->regionCheck(faf::request()->post('factory_country'), faf::request()->post('factory_region'));
		})->addValidator('factory_city', function () {
			return $this->GeoModel()->cityCheck(faf::request()->post('factory_country'), faf::request()->post('factory_region'),
				faf::request()->post('factory_city'));
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->factoryAdd($account['id'], faf::router()->matches['company']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionFactoryUpdate() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->addValidator('factory_country', function () {
			return $this->GeoModel()->countryCheck(faf::request()->post('factory_country'));
		})->addValidator('factory_region', function () {
			return $this->GeoModel()->regionCheck(faf::request()->post('factory_country'), faf::request()->post('factory_region'));
		})->addValidator('factory_city', function () {
			return $this->GeoModel()->cityCheck(faf::request()->post('factory_country'), faf::request()->post('factory_region'),
				faf::request()->post('factory_city'));
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->factoryUpdate($account['id'], faf::router()->matches['company']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}
}
