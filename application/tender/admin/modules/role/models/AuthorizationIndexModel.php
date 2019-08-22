<?php

namespace tender\admin\modules\role\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AuthorizationIndexModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [];
	}

	public function getAuthorizationList() {
		$result = $this->loadQuery('modules/role/sql/authorizationListGet.sql')->execute()->fetchAll();

		return $result;
	}

	public function getAccountTypeList() {
		$result = $this->loadQuery('modules/role/sql/getAccountTypeList.sql')->execute()->fetchAll();

		return $result;
	}
}
