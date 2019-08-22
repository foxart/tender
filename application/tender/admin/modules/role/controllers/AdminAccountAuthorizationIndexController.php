<?php

namespace tender\admin\modules\role\controllers;

use fa\classes\Controller;
use tender\admin\modules\role\models\AuthorizationIndexModel;
use tender\admin\modules\role\views\AuthorizationView;

class AdminAccountAuthorizationIndexController extends Controller {

	/**
	 * @return AuthorizationIndexModel
	 */
	private function IndexModel() {
		return AuthorizationIndexModel::instance();
	}

	/**
	 * @return AuthorizationView
	 */
	private function View() {
		return AuthorizationView::instance();
	}

	public function actionAuthorizationList() {
		$company_list = $this->IndexModel()->getAuthorizationList();
		$account_type_list = $this->IndexModel()->getAccountTypeList();

		return $this->View()->renderIndexPage($company_list, $account_type_list);
	}
}
