<?php

namespace tender\admin\modules\tree\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class AdminTreeEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/account/company/sql/index/';
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [
			'material_id' => [
				'integer',
			],
			'material_material_id' => [
				'integer',
			],
			'material_name' => [
				'set',
			],
			'material_group_id' => [
				'set',
				'integer',
			],
			'material_uom_id' => [
				'set',
			],
			'material_description' => [
				'set',
			],
			'material_po' => [
				'set',
			],
		];
	}

	/*
	 * MATERIAL
	 */
	public function materialNodeUpdate() {
		$result = $this->loadQuery('modules/tree/sql/materialNodeUpdate.sql')->execute()->statement;

		return $result;
	}

	public function materialGet($material_id) {
		$result = $this->loadQuery('modules/tree/sql/materialGet.sql')->prepare([
			'material_id' => $material_id,
		])->execute()->fetchRow();

		return $result;
	}

	public function materialAddCheck() {
		$count = $this->loadQuery('modules/tree/sql/materialAddCheck.sql')->execute()->fetchRow('count');
		if ($count == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function materialAdd() {
		return $this->loadQuery('modules/tree/sql/materialAdd.sql')->execute()->statement;
	}

	public function materialUpdateCheck($material_id) {
		$count = $this->loadQuery('modules/tree/sql/materialUpdateCheck.sql')->prepare([
			'material_id' => $material_id,
		])->execute()->fetchRow('count');
		if ($count == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function materialUpdate($material_id) {
		return $this->loadQuery('modules/tree/sql/materialUpdate.sql')->prepare([
			'material_id' => $material_id,
		])->execute()->statement;
	}

	public function materialDelete($material_id) {
		return $this->loadQuery('modules/tree/sql/materialDelete.sql')->prepare([
			'material_id' => $material_id,
		])->execute()->statement;
	}

	/*
	 * MATERIAL GROUP
	 */
	public function materialGroupGet($material_group_id) {
		return $this->loadQuery('modules/tree/sql/materialGroupGet.sql')->prepare([
			'material_group_id' => $material_group_id,
		])->execute()->fetchRow();
	}

	public function materialGroupAddCheck() {
		$this->loadQuery('modules/tree/sql/materialGroupAddCheck.sql')->execute()->fetchRow();
		if ($this->count === 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function materialGroupAdd() {
		return $this->loadQuery('modules/tree/sql/materialGroupAdd.sql')->execute()->statement;
	}

	public function materialGroupUpdateCheck($material_group_id) {
		$this->loadQuery('modules/tree/sql/materialGroupUpdateCheck.sql')->prepare([
			'material_group_id' => $material_group_id,
		])->execute()->fetchRow();
		if ($this->count === 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function materialGroupUpdate($material_group_id) {
		return $this->loadQuery('modules/tree/sql/materialGroupUpdate.sql')->prepare([
			'material_group_id' => $material_group_id,
		])->execute()->statement;
	}

	public function materialGroupDelete($material_group_id) {
		return $this->loadQuery('modules/tree/sql/materialGroupDelete.sql')->prepare([
			'material_group_id' => $material_group_id,
		])->execute()->statement;
	}
}
