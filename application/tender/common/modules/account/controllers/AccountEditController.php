<?php

namespace tender\common\modules\account\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\common\modules\account\models\AccountEditModel;

class AccountEditController extends Controller {

	private function Model() {
		return AccountEditModel::instance();
	}

	public function actionAccountGet() {
		$account = faf::session()->get('account');

		return json_encode($this->Model()->accountGet($account['id']));
	}

	public function actionAccountUpdate() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->accountUpdate($account['id']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}
}
