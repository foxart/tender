<?php

namespace tender\purchaser\modules\rfq\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class PurchaserRfqMaterialEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/rfq/sql/material/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			'rfq_id' => [
				'set',
			],
			'rfq_material_quantity' => [
				'set',
				'float',
			],
		];
	}

	public function rfqMaterialGet($account_id, $rfq_id, $material_id) {
		$this->loadQuery('modules/rfq/sql/rfqMaterialGet.sql');
		$this->prepare([
			'account_id' => $account_id,
			'rfq_id' => $rfq_id,
			'material_id' => $material_id,
		])->execute();

		return $this->fetchRow();
	}

	public function rfqItemMaterialSelect($account_id, $rfq_id, $material_name) {
		$data = $this->loadQuery('modules/rfq/sql/rfqMaterialSelect.sql')->prepare([
			'account_id' => $account_id,
			'rfq_id' => $rfq_id,
			'material_name' => $material_name,
		])->execute()->fetchAll();
		$result = array();
		foreach ($data as $item) {
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

	public function rfqMaterialAdd($account_id, $rfq_id, $material_id) {
		$this->loadQuery('modules/rfq/sql/rfqMaterialAdd.sql');
//		foreach ($material_id_array as $material_id) {
		$this->prepare([
			'account_id' => $account_id,
			'material_id' => $material_id,
			'rfq_id' => $rfq_id,
		])->execute();

//		}
		return $this->statement;
	}

	public function rfqMaterialAddCheck($account_id, $rfq_id, $material_id) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialAddCheck.sql')->prepare([
			'account_id' => $account_id,
			'material_id' => $material_id,
			'rfq_id' => $rfq_id,
		])->execute()->fetchRow('count');
	}

	public function rfqMaterialUpdate($account_id, $rfq_id, $material_id) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialUpdate.sql')->prepare([
			'account_id' => $account_id,
			'material_id' => $material_id,
			'rfq_id' => $rfq_id,
		])->execute()->statement;
	}

	public function rfqMaterialDelete($account_id, $rfq_id, $material_id) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialDelete.sql')->prepare([
			'account_id' => $account_id,
			'material_id' => $material_id,
			'rfq_id' => $rfq_id,
		])->execute()->statement;
	}

	public function rfqMaterialDeleteCheck($account_id, $rfq_id, $material_id) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialDeleteCheck.sql')->prepare([
			'account_id' => $account_id,
			'material_id' => $material_id,
			'rfq_id' => $rfq_id,
		])->execute()->fetchAll();
	}
}
