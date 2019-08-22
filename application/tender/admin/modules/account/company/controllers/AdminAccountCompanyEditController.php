<?php

namespace tender\admin\modules\account\company\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\account\company\models\AdminAccountCompanyEditModel;

class AdminAccountCompanyEditController extends Controller {

	/**
	 * @return AdminAccountCompanyEditModel
	 */
	private function Model() {
		return AdminAccountCompanyEditModel::instance();
	}

	public function actionAddCompanyToPurchaser() {
		$account_id = faf::router()->matches['account-id'];
		$account_profile = $this->Model()->accountTypeGet($account_id);
		$this->Model()->addValidator('company_id[]', function () {
			if (faf::request()->post('company_id') === NULL) {
				return 'please enter company';
			} else {
				return TRUE;
			}
		})->validate();
		if ($this->Model()->valid === TRUE) {
			if ($account_profile['account_type_name'] === 'purchaser') {
				$company_id = faf::request()->post('company_id');
				$result = $this->Model()->addCompanyToPurchaser($account_id, $company_id);
			} else {
				$result = FALSE;
			}
		} else {
			$result = $this->Model()->errorsToJson();
		}

		return $result;
	}

	public function actionDeleteBindedCompany() {
		$account_id = faf::router()->matches['account-id'];
		$company_id = faf::router()->matches['company-id'];
		$this->Model()->deleteBindedCompany($account_id, $company_id);

		return TRUE;
	}
}
