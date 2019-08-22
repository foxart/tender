<?php

namespace tender\vendor\modules\detail\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class DetailEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/detail/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			'detail_country' => [
				'set',
			],
			'detail_region' => [
				'set',
			],
			'detail_city' => [
				'set',
			],
			'detail_street' => [
				'set',
			],
			'detail_house' => [
				'set',
			],
			'detail_postal' => [
				'set',
			],
			'detail_email' => [
				'set',
				'email',
			],
			'detail_district' => [
				'set',
			],
			'detail_phone' => [
				'set',
			],
		];
	}

	public function detailGet($account_id, $company_id) {
		return $this->loadQuery('modules/detail/sql/detailGet.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}

	public function detailAdd($account_id, $company_id) {
		return $this->loadQuery('modules/detail/sql/detailAdd.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}

	public function detailUpdate($account_id, $company_id) {
		return $this->loadQuery('modules/detail/sql/detailUpdate.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}
}
