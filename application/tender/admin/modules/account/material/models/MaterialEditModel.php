<?php

namespace tender\admin\modules\account\material\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class MaterialEditModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [
			'material_title' => [
				'set',
			],
		];
	}

	public function materialGet($account_id, $company_id, $material_id) {
		return $this->loadQuery('modules/account/material/sql/materialGet.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
			'material_id' => $material_id,
		])->execute()->fetchRow();
	}

	public function materialSelect($account_id, $company_id, $material_name) {
		$model = $this->loadQuery('modules/account/material/sql/materialSelect.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
			'material_name' => $material_name,
		])->execute()->fetchAll();
		$result = array();
		foreach ($model as $item) {
			$result[$item['material_group_id']]['text'] = $item['material_group_name'];
			if (isset($result[$item['material_group_id']]['children']) === FALSE) {
				$result[$item['material_group_id']]['children'] = [];
			}
			$child = [
				'id' => $item['material_id'],
				'text' => $item['material_name'],
			];
			array_push($result[$item['material_group_id']]['children'], $child);
		}

		return array_values($result);
	}

	public function materialAdd($account_id, $company_id, $material_id_array) {
		$this->loadQuery('modules/account/material/sql/materialAdd.sql');
		foreach ($material_id_array as $material_id) {
			$this->prepare([
				'account_id' => $account_id,
				'company_id' => $company_id,
				'material_id' => $material_id,
			])->execute();
		}

		return $this->statement;
	}

	public function materialUpdate($account_id, $company_id, $material_id, $material_file) {
		return $this->loadQuery('modules/account/material/sql/materialUpdate.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
			'material_id' => $material_id,
			'material_file' => $material_file,
		])->execute()->statement;
	}

	public function materialDelete($account_id, $company_id, $material_id) {
		return $this->loadQuery('modules/account/material/sql/materialDelete.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
			'material_id' => $material_id,
		])->execute()->statement;
	}
}
