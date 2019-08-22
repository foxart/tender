<?php

namespace tender\common\modules\account\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AccountIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'common/modules/account/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function profile($account_id) {
		return $this->loadQuery("application/tender/common/modules/account/sql/account.sql")->prepare([
			'account_id' => $account_id,
		])->execute()->fetchRow();
	}
}
