<?php

namespace tender\admin\modules\role\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AuthorizationEditModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [
			'authorization_name' => [
				'set',
			],
			'authorization_account_type_id' => [
				'set',
			],
		];
	}

	public function authorizationGet($authorization_id) {
		$result = $this->loadQuery('modules/role/sql/authorizationGet.sql')->prepare([
			'authorization_id' => $authorization_id,
		])->execute()->fetchRow();

		return $result;
	}

	public function authorizationAdd() {
		$result = $this->loadQuery('modules/role/sql/authorizationAdd.sql')->execute()->statement;

		return $result;
	}

	public function authorizationUpdate($authorization_id) {
		$result = $this->loadQuery('modules/role/sql/authorizationUpdate.sql')->prepare([
			'authorization_id' => $authorization_id,
		])->execute()->statement;

		return $result;
	}

	public function authorizationDelete($authorization_id) {
		$result = $this->loadQuery('modules/role/sql/authorizationDelete.sql')->prepare([
			'authorization_id' => $authorization_id,
		])->execute()->statement;

		return $result;
	}

	/**
	 * @return bool
	 */
	public function authorizationAddCheck() {
		$result = $this->loadQuery('modules/role/sql/authorizationAddCheck.sql')->execute()->fetchRow('count');
		if ($result == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * @param $authorization_id int
	 *
	 * @return bool
	 */
	public function authorizationUpdateCheck($authorization_id) {
		$result = $this->loadQuery('modules/role/sql/authorizationUpdateCheck.sql')->prepare([
			'authorization_id' => $authorization_id,
		])->execute()->fetchRow('count');
		if ($result == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
