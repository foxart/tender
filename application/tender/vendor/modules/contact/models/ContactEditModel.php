<?php

namespace tender\vendor\modules\contact\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class ContactEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/contact/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			'contact_person' => [
				'set',
			],
			'contact_title' => [
				'set',
			],
			'contact_position' => [
				'set',
			],
			'contact_email' => [
				'set',
				'email',
			],
			'contact_phone' => [
				'set',
			],
		];
	}

	public function contactGet($account_id, $company_id) {
		return $this->loadQuery('modules/contact/sql/contactGet.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}

	public function contactAdd($account_id, $company_id) {
		return $this->loadQuery('modules/contact/sql/contactAdd.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}

	public function contactUpdate($account_id, $company_id) {
		return $this->loadQuery('modules/contact/sql/contactUpdate.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}
}
