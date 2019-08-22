<?php

namespace tender\common\modules\account\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AccountEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'common/modules/account/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			'account_surname' => [
				'set',
			],
			'account_name' => [
				'set',
			],
			'account_patronymic' => [
				'set',
			],
		];
	}

	public function accountGet($account_id) {
		return $this->loadQuery('application/tender/common/modules/account/sql/accountGet.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchRow();
	}

	public function accountUpdate($account_id) {
		return $this->loadQuery('application/tender/common/modules/account/sql/accountUpdate.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->statement;
	}
}
