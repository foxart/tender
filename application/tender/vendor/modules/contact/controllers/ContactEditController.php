<?php

namespace tender\vendor\modules\contact\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\contact\models\ContactEditModel;

class ContactEditController extends Controller {

	private function Model() {
		return ContactEditModel::instance();
	}

	public function actionContactGet() {
		$account = faf::session()->get('account');

		return json_encode($this->Model()->contactGet($account['id'], faf::router()->matches['company']));
	}

	public function actionContactAdd() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->contactAdd($account['id'], faf::router()->matches['company']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionContactUpdate() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->contactUpdate($account['id'], faf::router()->matches['company']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}
}
