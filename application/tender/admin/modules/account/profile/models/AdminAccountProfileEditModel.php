<?php

namespace tender\admin\modules\account\profile\models;

use fa\classes\SqlModel;
use fa\core\faf;
use tender\common\connections\DefaultConnection;

class AdminAccountProfileEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'admin/modules/account/profile/sql/';
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [
			'account_id' => [
				'integer',
			],
			'authentication_active' => [
				'set',
			],
			'authentication_email' => [
				'set',
				'email',
			],
			'authentication_password' => [
				'set',
			],
			'authentication_salt' => [
				'set',
			],
			'authentication_email_key' => [
				'set',
			],
			'account_type_id' => [
				'set',
				'integer',
			],
			'account_name' => [
				'set',
			],
			'account_surname' => [
				'set',
			],
			'account_patronymic' => [
				'any',
			],
		];
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

	public function accountUpdate() {
		$this->loadQuery('modules/account/profile/sql/accountUpdate.sql')->execute();

		return $this->statement;
	}

	public function activeStatusUpdate() {
		$result = $this->loadQuery('modules/account/profile/sql/updateActiveStatus.sql')->execute();

		return $result->statement;
	}

	public function accountAuthorizationUpdate($account_id, $authorization_id) {
		$result = $this->loadQuery('modules/account/profile/sql/accountAuthorizationUpdate.sql')->prepare([
			'account_id' => $account_id,
			'authorization_id' => $authorization_id,
		])->execute();

		return $result->statement;
	}

	public function registeredStatusCheck() {
		$count = $this->loadQuery('modules/account/profile/sql/registeredStatusCheck.sql')->execute()->fetchRow('count');
		if ($count == 1) {
			$result = TRUE;
		} else {
			$result = FALSE;
		}

		return $result;
	}

	public function activeStatusUpdateCheck($account_id) {
		$session_account = faf::session()->get('account');
		if ($account_id != $session_account['id']) {
			$result = TRUE;
		} else {
			$result = FALSE;
		};

		return $result;
	}
}
