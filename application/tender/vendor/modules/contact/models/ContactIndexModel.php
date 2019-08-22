<?php

namespace tender\vendor\modules\contact\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class ContactIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/contact/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
	}

	public function contact($account_id, $company_id) {
		return $this->loadQuery('modules/contact/sql/contact.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}
}
