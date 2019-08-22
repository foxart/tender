<?php

namespace tender\vendor\modules\bank\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\bank\models\BankIndexModel;
use tender\vendor\modules\bank\views\BankIndexView;

class BankIndexController extends Controller {

	private function Model() {
		return BankIndexModel::instance();
	}

	private function View() {
		return BankIndexView::instance();
	}

	public function actionBankList() {
		$account = faf::session()->get('account');
		$data = $this->Model()->bank($account['id'], faf::router()->matches['company']);

		return $this->View()->renderBankList($data);
	}
}
