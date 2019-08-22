<?php

namespace tender\vendor\modules\factory\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class FactoryIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/factory/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function factoryItem($account_id, $company_id) {
		return $this->loadQuery('modules/factory/sql/factoryItem.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}
}
