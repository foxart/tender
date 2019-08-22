<?php

namespace tender\vendor\modules\company\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class CompanyEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/company/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			'company_title_id' => [
				'set',
				'integer',
			],
			'company_type_id' => [
				'set',
				'integer',
			],
			'company_name' => [
				'set',
			],
		];
	}

	public function companyGet($account_id, $company_id) {
		return $this->loadQuery('modules/company/sql/companyGet.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}

	public function companyAdd($account_id) {
		return $this->loadQuery('modules/company/sql/companyAdd.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->statement;
	}

	public function companyAddCheck($account_id, $company_name) {
		return $this->loadQuery('modules/company/sql/companyAddCheck.sql')->prepare([
			'account_id' => $account_id,
			'company_name' => $company_name,
		])->execute()->fetchRow('count');
	}

	public function companyUpdate($account_id, $company_id) {
		return $this->loadQuery('modules/company/sql/companyUpdate.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}

	public function companyUpdateCheck($account_id, $company_id, $company_name) {
		return $this->loadQuery('modules/company/sql/companyUpdateCheck.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
			'company_name' => $company_name,
		])->execute()->fetchRow('count');
	}

	public function companyDelete($account_id, $company_id) {
		return $this->loadQuery('modules/company/sql/companyDelete.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}
}
