<?php

namespace tender\admin\modules\account\profile\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AdminAccountProfileIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/account/profile/sql/';
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [];
	}

	public function account($id) {
		$result = $this->loadQuery('modules/account/profile/sql/account.sql')->prepare([
			'account_id' => $id,
		])->execute()->fetchRow();

		return $result;
	}

	/**
	 * Get one admin account by account id
	 *
	 * @param $id int
	 *
	 * @return array|false|null
	 */
	public function accountGet($id) {
		$result = $this->loadQuery('modules/account/profile/sql/accountGet.sql')->prepare([
			'account_id' => $id,
		])->execute()->fetchRow();

		return $result;
	}

	public function accountAuthorizationListGet($account_type_id) {
		$result = $this->loadQuery('modules/account/profile/sql/accountAuthorizationListGet.sql')->prepare([
			'authorization_account_type_id' => $account_type_id,
		])->execute()->fetchAll();

		return $result;
	}

	public function accountTypeIdGet($account_type_name) {
		$result = $this->loadQuery('modules/account/profile/sql/accountTypeIdGet.sql')->prepare([
			'account_type_name' => $account_type_name,
		])->execute()->fetchRow('account_type_id');

		return $result;
	}

	public function accountAuthorizationIdGet($account_id) {
		$result = $this->loadQuery('modules/account/profile/sql/accountAuthorizationIdGet.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchRow();

		return $result;
	}

	public function accountTypeByAccountId($account_id) {
		return $this->loadQuery('modules/account/profile/sql/accountTypeByAccountId.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchRow('account_type_name');
	}

	public function accountNameByAccountId($account_id) {
		return $this->loadQuery('modules/account/profile/sql/accountNameByAccountId.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchRow('account_name');
	}
}
