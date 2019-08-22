<?php

namespace tender\admin\modules\legal\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class SettingCompanyIndexModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [];
	}

	public function getCompanyList() {
		$result = $this->loadQuery('modules/legal/sql/getCompanyList.sql')->execute()->fetchAll();

		return $result;
	}
}
