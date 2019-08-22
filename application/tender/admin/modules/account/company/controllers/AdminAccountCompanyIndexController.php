<?php

namespace tender\admin\modules\account\company\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\account\company\models\AdminAccountCompanyIndexModel;
use tender\admin\modules\account\company\views\AdminAccountCompanyView;

class AdminAccountCompanyIndexController extends Controller {

	/**
	 * @return AdminAccountCompanyIndexModel
	 */
	private function Model() {
		return AdminAccountCompanyIndexModel::instance();
	}

	/**
	 * @return AdminAccountCompanyView
	 */
	private function View() {
		return AdminAccountCompanyView::instance();
	}

	public function outputAdminAccountCompanyList() {
		$company = $this->Model()->getPurchaserCompanyBinded(faf::router()->matches['account-id']);

		return $this->View()->renderCompanyList(faf::router()->matches['account-id'], $company);
	}

	public function actionPurchaserCompanyNotBinded() {
		$account_id = faf::router()->matches['account-id'];
		$query = faf::request()->get('query_string');
		$model = $this->Model()->getPurchaserCompanyNotBinded($account_id, $query);

		return json_encode([
			'items' => $model,
		]);
	}

	public function getFormCompanyAdd() {
		return $this->View()->renderCompanyAddform();
	}

	public function getFormCompanyDelete() {
		return $this->View()->renderCompanyDeleteform();
	}
}
