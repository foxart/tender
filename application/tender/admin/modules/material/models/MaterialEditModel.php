<?php

namespace tender\admin\modules\material\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

/**
 * Class MaterialModel
 *
 * @package modules\tender\admin\models
 */
class MaterialEditModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;
//	public static $path = 'admin/modules/material/sql/edit/';

	protected function rules() {
		return [
			/*
			 * MATERIAL
			 */
			'material_name' => [
				'set',
//				'match' => [
//					'pattern' => '[a-zA-Z0-9]+',
//					'message' => 'wrong pattern',
//				],
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
			/*
			 * MATERIAL GROUP
			 */
			'material_group_name' => [
				'set',
//				'match' => [
//					'pattern' => '[a-zA-Z0-9]+',
//					'message' => 'wrong pattern',
//				],
			],
		];
	}

	/*
	 * MATERIAL
	 */
	public function materialGet($material_id) {
		return $this->loadQuery('modules/material/sql/materialGet.sql')->prepare([
			'material_id' => $material_id,
		])->execute()->fetchRow();
	}

	public function materialAddCheck() {
		$count = $this->loadQuery('modules/material/sql/materialAddCheck.sql')->execute()->fetchRow('count');
		if ($count == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function materialAdd() {
		return $this->loadQuery('modules/material/sql/materialAdd.sql')->execute()->statement;
	}

	public function materialUpdateCheck($material_id) {
		$count = $this->loadQuery('modules/material/sql/materialUpdateCheck.sql')->prepare([
			'material_id' => $material_id,
		])->execute()->fetchRow('count');
		if ($count == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function materialUpdate($material_id) {
		return $this->loadQuery('modules/material/sql/materialUpdate.sql')->prepare([
			'material_id' => $material_id,
		])->execute()->statement;
	}

	public function materialDelete($material_id) {
		return $this->loadQuery('modules/material/sql/materialDelete.sql')->prepare([
			'material_id' => $material_id,
		])->execute()->statement;
	}

	/*
	 * MATERIAL GROUP
	 */
	public function materialGroupGet($material_group_id) {
		return $this->loadQuery('modules/material/sql/materialGroupGet.sql')->prepare([
			'material_group_id' => $material_group_id,
		])->execute()->fetchRow();
	}

	public function materialGroupAddCheck() {
		$this->loadQuery('modules/material/sql/materialGroupAddCheck.sql')->execute()->fetchRow();
		if ($this->count === 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function materialGroupAdd() {
		return $this->loadQuery('modules/material/sql/materialGroupAdd.sql')->execute()->statement;
	}

	public function materialGroupUpdateCheck($material_group_id) {
		$this->loadQuery('modules/material/sql/materialGroupUpdateCheck.sql')->prepare([
			'material_group_id' => $material_group_id,
		])->execute()->fetchRow();
		if ($this->count === 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function materialGroupUpdate($material_group_id) {
		return $this->loadQuery('modules/material/sql/materialGroupUpdate.sql')->prepare([
			'material_group_id' => $material_group_id,
		])->execute()->statement;
	}

	public function materialGroupDelete($material_group_id) {
		return $this->loadQuery('modules/material/sql/materialGroupDelete.sql')->prepare([
			'material_group_id' => $material_group_id,
		])->execute()->statement;
	}
}
