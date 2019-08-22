<?php

namespace tender\vendor\modules\legal\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class LegalEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/legal/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
//			'legal_title' => [
//				'set',
//			],
		];
	}

	public function legalSelect($account_id, $company_id) {
		$model = $this->loadQuery('modules/legal/sql/legalSelect.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchAll();
		$result = array();
		$count = 0;
		foreach ($model as $item) {
			$result[$count]['id'] = $item['legal_id'];
			$result[$count]['text'] = $item['legal_name'];
			$count++;
		}

		return array_values($result);
	}

	public function legalGet($account_id, $company_id, $legal_id) {
		return $this->loadQuery('modules/legal/sql/legalGet.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
			'legal_id' => $legal_id,
		])->execute()->fetchRow();
	}

	public function legalAdd($account_id, $company_id, $legal_id_array) {
		$this->loadQuery('modules/legal/sql/legalAdd.sql');
		foreach ($legal_id_array as $legal_id) {
			$this->prepare([
				'account_id' => $account_id,
				'company_id' => $company_id,
				'legal_id' => $legal_id,
			])->execute();
		}

		return $this->statement;
	}

	public function legalDelete($account_id, $company_id, $legal_id) {
		return $this->loadQuery('modules/legal/sql/legalDelete.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
			'legal_id' => $legal_id,
		])->execute()->statement;
	}
}
