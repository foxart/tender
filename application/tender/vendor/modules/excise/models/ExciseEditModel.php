<?php

namespace tender\vendor\modules\excise\models;

use fa\classes\SqlModel;
use fa\core\faf;
use tender\common\connections\DefaultConnection;

class ExciseEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/excise/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			'excise_basis' => [
				'set',
			],
			'excise_tax' => [
				'set',
			],
			'excise_registration' => [
				'set',
			],
			'excise_registration_number' => [
				function () {
					if ($this->getData('excise_registration') === 'yes') {
						$result = faf::validator()->validateField($this->getData('excise_registration_number'), 'set');
					} else {
						$this->addLoad([
							'excise_registration_number' => NULL,
						]);
						$result = TRUE;
					}

					return $result;
				},
			],
			'excise_service' => [
				'set',
			],
			'excise_service_number' => [
				function () {
					if ($this->getData('excise_service') === 'yes') {
						$result = faf::validator()->validateField($this->getData('excise_service_number'), 'set');
					} else {
						$this->addLoad([
							'excise_service_number' => NULL,
						]);
						$result = TRUE;
					}

					return $result;
				},
			],
			'excise_sales' => [
				'set',
			],
			'excise_sales_number' => [
				function () {
					if ($this->getData('excise_sales') === 'yes') {
						$result = faf::validator()->validateField($this->getData('excise_sales_number'), 'set');
					} else {
						$this->addLoad([
							'excise_sales_number' => NULL,
						]);
						$result = TRUE;
					}

					return $result;
				},
			],
			'excise_license' => [
				'set',
			],
		];
	}

	public function exciseGet($account_id, $company_id) {
		return $this->loadQuery('modules/excise/sql/exciseGet.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}

	public function exciseAdd($account_id, $company_id) {
		return $this->loadQuery('modules/excise/sql/exciseAdd.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}

	public function exciseUpdate($account_id, $company_id) {
		return $this->loadQuery('modules/excise/sql/exciseUpdate.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}
}
