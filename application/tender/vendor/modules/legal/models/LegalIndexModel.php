<?php

namespace tender\vendor\modules\legal\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class LegalIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/legal/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function legalList($account_id, $company_id) {
		return $this->loadQuery('modules/legal/sql/legalList.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchAll();
	}
}
