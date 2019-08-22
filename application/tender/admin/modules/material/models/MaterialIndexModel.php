<?php

namespace tender\admin\modules\material\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

/**
 * Class MaterialModel
 *
 * @package modules\tender\admin\models
 */
class MaterialIndexModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;
//	public static $path = 'modules/material/sql/';

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
		return $this->loadQuery('modules/material/sql/materialUomSelect.sql')->execute()->fetchAll();
	}

	public function getMaterialGroupSelect() {
		return $this->loadQuery('modules/material/sql/materialGroupSelect.sql')->execute()->fetchAll();
	}

	/*
	 * MATERIAL
	 */
	public function materialList($material_name) {
		return $this->loadQuery('modules/material/sql/materialList.sql')->prepare([
			'material_name' => $material_name,
		])->execute()->fetchAll();
	}

	/*
	 * MATERIAL GROUP
	 */
	public function materialGroupList($material_group_name) {
		return $this->loadQuery('modules/material/sql/materialGroupList.sql')->prepare([
			'material_group_name' => $material_group_name,
		])->execute()->fetchAll();
	}
}
