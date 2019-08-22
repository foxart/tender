<?php

namespace tender\vendor\modules\detail\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class DetailIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/detail/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function detailItem($account_id, $company_id) {
		return $this->loadQuery('modules/detail/sql/detailItem.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}
}
