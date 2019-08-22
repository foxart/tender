<?php

namespace tender\admin\modules\account\profile\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\account\profile\models\AdminAccountProfileIndexModel;
use tender\admin\modules\account\profile\views\AdminAccountProfileView;

class AdminAccountProfileIndexController extends Controller {

	/**
	 * @return AdminAccountProfileIndexModel
	 */
	private function Model() {
		return AdminAccountProfileIndexModel::instance();
	}

	/**
	 * @return AdminAccountProfileView
	 */
	private function View() {
		return AdminAccountProfileView::instance();
	}

	public function actionAccountProfile() {
		$account = $this->Model()->account(faf::router()->matches['account-id']);
		if ($account !== FALSE) {
			$account_type_id = $this->Model()->accountTypeIdGet($account['account_type_name']);
			$authorization_list = $this->Model()->accountAuthorizationListGet($account_type_id);
			$result = $this->View()->renderProfileItem($account, $authorization_list);
		} else {
			$result = $this->View()->renderErrorPage();
		}

		return $result;
	}

	public function actionAccountAuthorizationGet() {
		$authorization_id = $this->Model()->accountAuthorizationIdGet(faf::router()->matches['account-id']);
		if ($authorization_id === NULL) {
			$authorization_id = 0;
		}

		return json_encode($authorization_id);
	}

	public function accountTypeGet() {
		return $this->Model()->accountTypeByAccountId(faf::router()->matches['account-id']);
	}

	public function accountNameGet() {
		return $this->Model()->accountNameByAccountId(faf::router()->matches['account-id']);
	}
}
