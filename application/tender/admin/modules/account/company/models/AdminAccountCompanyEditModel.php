<?php

namespace tender\admin\modules\account\company\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AdminAccountCompanyEditModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [];
	}

	public function accountTypeGet($account_id) {
		$result = $this->loadQuery('modules/account/company/sql/getAccountType.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchRow();

		return $result;
	}

	public function addCompanyToPurchaser($account_id, $company_id) {
		$result = FALSE;
//		$material_id_array = faf::request()->post('company_id');
		if (is_array($company_id) === TRUE) {
			foreach ($company_id as $value) {
				$this->loadQuery('modules/account/company/sql/addCompanyToPurchaser.sql')->prepare([
					'account_id' => $account_id,
					'company_id' => $value,
				])->execute();
			}
			$result = $this->statement;
		}

		return $result;
	}

	public function deleteBindedCompany($account_id, $company_id) {
		$this->loadQuery('modules/account/company/sql/deleteBindedCompany.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute();
	}
}
