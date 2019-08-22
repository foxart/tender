<?php

namespace tender\admin\modules\tree\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\tree\models\AdminTreeEditModel;

class AdminTreeEditController extends Controller {

	/**
	 * @return AdminTreeEditModel
	 */
	private function Model() {
		return AdminTreeEditModel::instance();
	}

	/*
	 * MATERIAL
	 */
	public function actionMaterialTreeSave() {
		$post = faf::request()->post();
		$result = var_dump($post);

//$result = json_encode($post);
		return $result;
//		return json_encode([
//			'result' => $result,
//		]);
	}

	public function actionMaterialNodeSave() {
		$post = faf::request()->post();
		$this->Model()->addLoad([
			'material_id' => $post['id'],
			'material_material_id' => $post['parent'],
		]);
		$result = $this->Model()->materialNodeUpdate();

		return $result;
//		return json_encode([
//			'result' => $result,
//		]);
	}

	public function actionMaterialGet() {
		$material_id = faf::router()->matches['material-id'];
		$result = $this->Model()->materialGet($material_id);

		return json_encode($result);
	}

	public function actionMaterialAdd() {
		$this->Model()->load(faf::request()->post())->addValidator('material_name', function () {
			if ($this->Model()->materialAddCheck() === TRUE) {
				return TRUE;
			} else {
				return 'not unique';
			}
		})->validate();
		if ($this->Model()->valid === FALSE) {
			$result = $this->Model()->errorsToJson();
		} else {
			$result = $this->Model()->materialAdd();
		}

		return $result;
	}

	public function actionMaterialUpdate() {
		$this->Model()->load(faf::request()->post())->addValidator('material_name', function () {
			if ($this->Model()->materialUpdateCheck(faf::router()->matches['material-id']) === TRUE) {
				return TRUE;
			} else {
				return 'not unique';
			}
		})->validate();
		if ($this->Model()->valid === FALSE) {
			$result = $this->Model()->errorsToJson();
		} else {
			$result = $this->Model()->materialUpdate(faf::router()->matches['material-id']);
		}

		return $result;
	}

	public function actionMaterialDelete() {
		return $this->Model()->materialDelete(faf::router()->matches['material-id']);
	}

	/*
	 * GROUP
	 */
	public function actionMaterialGroupGet() {
		return json_encode($this->Model()->materialGroupGet(faf::router()->matches['material-id']));
	}

	public function actionMaterialGroupAdd() {
		$this->Model()->load(faf::request()->post())->addValidator('material_group_name', function () {
			if ($this->Model()->materialGroupAddCheck() === TRUE) {
				return TRUE;
			} else {
				return 'not unique';
			}
		})->validate();
		if ($this->Model()->valid === FALSE) {
			$result = $this->Model()->errorsToJson();
		} else {
			$result = $this->Model()->materialGroupAdd();
		}

		return $result;
	}

	public function actionMaterialGroupUpdate() {
		$this->Model()->load(faf::request()->post())->addValidator('material_group_name', function () {
			if ($this->Model()->materialGroupUpdateCheck(faf::router()->matches['material-id']) === TRUE) {
				return TRUE;
			} else {
				return 'not unique';
			}
		})->validate();
		if ($this->Model()->valid === FALSE) {
			$result = $this->Model()->errorsToJson();
		} else {
			$result = $this->Model()->materialGroupUpdate(faf::router()->matches['material-id']);
		}

		return $result;
	}

	public function actionMaterialGroupDelete() {
		return $this->Model()->materialGroupDelete(faf::router()->matches['material-id']);
	}
}
