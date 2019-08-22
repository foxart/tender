<?php

namespace tender\admin\modules\account\user\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AdminAccountUserEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'admin/modules/account/user/sql/';
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
			'account_surname' => [
				'set',
			],
			'account_name' => [
				'set',
			],
			'account_patronymic' => [
				'any',
			],
			'account_name_filter' => [
				'any',
			],
			'account_type_id_filter' => [
				'any',
			],
		];
	}

	public function accountTypeByAccountId($account_id) {
		return $this->loadQuery('modules/account/user/sql/accountTypeByAccountId.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchRow('account_type_name');
	}

	public function accountNameByAccountId($account_id) {
		return $this->loadQuery('modules/account/user/sql/accountNameByAccountId.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchRow('account_name');
	}

	/**
	 * Get all admin user
	 *
	 * @return array|null
	 */
	public function getUserList() {
		$result = $this->loadQuery('modules/account/user/sql/accounts.sql')->execute()->fetchAll();

		return $result;
	}

	public function getAccountTypeList() {
		$result = $this->loadQuery('modules/account/user/sql/getAccountTypeList.sql')->execute()->fetchAll();

		return $result;
	}

	/*
	 * Get one admin account by account id
	 *
	 * @param $id int
	 *
	 * @return array|false|null
	 */
	/**
	 * @param integer $id
	 *
	 * @return mixed|null
	 */
	public function accountGet($id) {
		$result = $this->loadQuery('modules/account/user/sql/accountGet.sql')->prepare([
			'account_id' => $id,
		])->execute()->fetchRow();

		return $result;
	}

	public function updateAccount() {
		$this->loadQuery('modules/account/user/sql/accountUpdate.sql')->execute();

		return $this->statement;
	}

	public function addAccountCheck() {
		$this->loadQuery('modules/account/user/sql/accountAddCheck.sql')->execute()->fetchRow();
		if ($this->count === 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
