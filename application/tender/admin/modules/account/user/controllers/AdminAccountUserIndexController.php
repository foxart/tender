<?php

namespace tender\admin\modules\account\user\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\account\user\models\AdminAccountUserIndexModel;
use tender\admin\modules\account\user\views\AdminAccountUserView;

class AdminAccountUserIndexController extends Controller {

	/**
	 * @return AdminAccountUserIndexModel
	 */
	private function Model() {
		return AdminAccountUserIndexModel::instance();
	}

	/**
	 * @return AdminAccountUserView
	 */
	private function View() {
		return AdminAccountUserView::instance();
	}

	public function actionUserList() {
		$this->Model()->addLoad([
			'account_name_filter' => faf::request()->get('account_name_filter', [
				'empty' => '',
			]),
			'account_type_id_filter' => faf::request()->get('account_type_id_filter', [
				'empty' => '',
			]),
		]);
		$model = $this->Model()->userListGet();
		$account_type = $this->Model()->getAccountTypeList();

		return $this->View()->renderAccountList($model, $account_type);
	}

	public function filterForm() {
		$account_type_list = $this->Model()->getAccountTypeList();

		return $this->View()->renderFormUserListFilter($account_type_list);
	}
}
