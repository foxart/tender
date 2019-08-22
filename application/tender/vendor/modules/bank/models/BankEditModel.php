<?php

namespace tender\vendor\modules\bank\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class BankEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/bank/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			'bank_key' => [
				'set',
			],
			'bank_account' => [
				'set',
			],
			'bank_holder' => [
				'set',
			],
		];
	}

	public function bankGet($account_id, $company_id, $bank_id) {
		return $this->loadQuery('modules/bank/sql/bankGet.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
			'bank_id' => $bank_id,
		])->execute()->fetchRow();
	}

	public function bankAdd($account_id, $company_id) {
		return $this->loadQuery('modules/bank/sql/bankAdd.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}

	public function bankUpdate($account_id, $company_id, $bank_id) {
		return $this->loadQuery('modules/bank/sql/bankUpdate.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
			'bank_id' => $bank_id,
		])->execute()->statement;
	}

	public function bankDelete($account_id, $company_id, $bank_id) {
		return $this->loadQuery('modules/bank/sql/bankDelete.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
			'bank_id' => $bank_id,
		])->execute()->statement;
	}
}
