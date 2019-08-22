<?php

namespace tender\admin\modules\account\company\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AdminAccountCompanyIndexModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [];
	}

	public function getPurchaserCompanyBinded($account_id) {
		$result = $this->loadQuery('modules/account/company/sql/getPurchaserCompanyBinded.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchAll();

		return $result;
	}

	public function getPurchaserCompanyNotBinded($account_id, $query = NULL) {
		$result = $this->loadQuery('modules/account/company/sql/getPurchaserCompanyNotBinded.sql')->prepare([
			'account_id' => $account_id,
			'query_string' => $query,
		])->execute()->fetchAll();

		return $result;
	}
}
