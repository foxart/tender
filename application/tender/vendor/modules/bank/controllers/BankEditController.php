<?php

namespace tender\vendor\modules\bank\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\bank\models\BankEditModel;

class BankEditController extends Controller {

	private function Model() {
		return BankEditModel::instance();
	}

	public function actionBankGet() {
		$account = faf::session()->get('account');

		return json_encode($this->Model()->bankGet($account['id'], faf::router()->matches['company'], faf::router()->matches['bank']));
	}

	public function actionBankAdd() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->bankAdd($account['id'], faf::router()->matches['company']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionBankUpdate() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->bankUpdate($account['id'], faf::router()->matches['company'], faf::router()->matches['bank']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionBankDelete() {
		$account = faf::session()->get('account');

		return $this->Model()->bankDelete($account['id'], faf::router()->matches['company'], faf::router()->matches['bank']);
	}
}
