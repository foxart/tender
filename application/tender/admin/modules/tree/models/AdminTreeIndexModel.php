<?php

namespace tender\admin\modules\tree\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AdminTreeIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/account/company/sql/index/';
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [];
	}

	/*
	 * MATERIAL
	 */
	public function materialList() {
		$result = $this->loadQuery('modules/tree/sql/materialList.sql')->execute()->fetchAll();

		return $result;
	}

	/*
	 * MATERIAL GROUP
	 */
	public function materialGroupList() {
		$result = $this->loadQuery('modules/tree/sql/materialGroupList.sql')->execute()->fetchAll();

		return $result;
	}
}
