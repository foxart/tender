<?php

namespace tender\vendor\modules\bank\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class BankIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/bank/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function bank($account_id, $company_id) {
		return $this->loadQuery('modules/bank/sql/bankList.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchAll();
	}
}
