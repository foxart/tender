<?php

namespace tender\vendor\modules\factory\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class FactoryEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/factory/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			'factory_country' => [
				'set',
			],
			'factory_region' => [
				'set',
			],
			'factory_city' => [
				'set',
			],
			'factory_street' => [
				'set',
			],
			'factory_house' => [
				'set',
			],
			'factory_postal' => [
				'set',
			],
			'factory_email' => [
				'set',
				'email',
			],
			'factory_district' => [
				'set',
			],
			'factory_phone' => [
				'set',
			],
		];
	}

	public function factoryGet($account_id, $company_id) {
		return $this->loadQuery('modules/factory/sql/factoryGet.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}

	public function factoryAdd($account_id, $company_id) {
		return $this->loadQuery('modules/factory/sql/factoryAdd.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}

	public function factoryUpdate($account_id, $company_id) {
		return $this->loadQuery('modules/factory/sql/factoryUpdate.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}
}
