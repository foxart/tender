<?php

namespace tender\common\modules\test\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

/**
 * Class MaterialModel
 *
 * @package modules\admin\models
 */
class TestModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;
	public static $path = 'admin/material/sql/index/';

	protected function rules() {
		return [
			/*
			 * FILTERS
			 */
			'material_name' => [
//				'set',
				'match' => [
					'pattern' => '[a-zA-Z0-9]*',
					'message' => 'wrong pattern',
				],
			],
		];
	}

	/*
 	 * SELECT
 	 */
	public function getMaterialUomSelect() {
		return $this->loadQuery('materialUomSelect.sql')->execute()->fetchAll();
	}

	public function getMaterialGroupSelect() {
		return $this->loadQuery('materialGroupSelect.sql')->execute()->fetchAll();
	}

	/*
	 * MATERIAL
	 */
	public function materialList($material_name) {
		return $this->loadQuery('materialList.sql')->prepare([
			'material_name' => $material_name,
		])->execute()->fetchAll();
	}

	/*
	 * MATERIAL GROUP
	 */
	public function materialGroupList($material_group_name) {
		return $this->loadQuery('materialGroupList.sql')->prepare([
			'material_group_name' => $material_group_name,
		])->execute()->fetchAll();
	}
}
