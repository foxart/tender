<?php

namespace tender\vendor\modules\material\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class MaterialIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/material/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function materialList($account_id, $company_id) {
		return $this->loadQuery('modules/material/sql/materialList.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchAll();
	}
}
