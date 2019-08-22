<?php

namespace tender\vendor\modules\excise\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\excise\models\ExciseEditModel;

class VendorProfileExciseEditController extends Controller {

	/**
	 * @return \modules\tender\vendor\profile\excise\models\VendorProfileExciseEditModel
	 */
	private function Model() {
		return ExciseEditModel::instance();
	}

	public function actionExciseGet() {
		$account = faf::session()->get('account');

		return json_encode($this->Model()->exciseGet($account['id'], faf::router()->matches['company']));
	}

	public function actionExciseAdd() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->exciseAdd($account['id'], faf::router()->matches['company']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionExciseUpdate() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->exciseUpdate($account['id'], faf::router()->matches['company']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}
}
