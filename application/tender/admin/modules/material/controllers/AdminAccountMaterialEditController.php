<?php

namespace tender\admin\modules\material\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\material\models\MaterialEditModel;

class AdminAccountMaterialEditController extends Controller {

	private function EditModel() {
		return MaterialEditModel::instance();
	}

	/*
	 * MATERIAL
	 */
	public function actionMaterialGet() {
		return json_encode($this->EditModel()->materialGet(faf::router()->matches['id']));
	}

	public function actionMaterialAdd() {
		$this->EditModel()->load(faf::request()->post())->addValidator('material_name', function () {
			if ($this->EditModel()->materialAddCheck() === TRUE) {
				return TRUE;
			} else {
				return 'not unique';
			}
		})->validate();
		if ($this->EditModel()->valid === FALSE) {
			$result = $this->EditModel()->errorsToJson();
		} else {
			$result = $this->EditModel()->materialAdd();
		}

		return $result;
	}

	public function actionMaterialUpdate() {
		$this->EditModel()->load(faf::request()->post())->addValidator('material_name', function () {
			if ($this->EditModel()->materialUpdateCheck(faf::router()->matches['id']) === TRUE) {
				return TRUE;
			} else {
				return 'not unique';
			}
		})->validate();
		if ($this->EditModel()->valid === FALSE) {
			$result = $this->EditModel()->errorsToJson();
		} else {
			$result = $this->EditModel()->materialUpdate(faf::router()->matches['id']);
		}

		return $result;
	}

	public function actionMaterialDelete() {
		return $this->EditModel()->materialDelete(faf::router()->matches['id']);
	}

	/*
	 * GROUP
	 */
	public function actionMaterialGroupGet() {
		return json_encode($this->EditModel()->materialGroupGet(faf::router()->matches['id']));
	}

	public function actionMaterialGroupAdd() {
		$this->EditModel()->load(faf::request()->post())->addValidator('material_group_name', function () {
			if ($this->EditModel()->materialGroupAddCheck() === TRUE) {
				return TRUE;
			} else {
				return 'not unique';
			}
		})->validate();
		if ($this->EditModel()->valid === FALSE) {
			$result = $this->EditModel()->errorsToJson();
		} else {
			$result = $this->EditModel()->materialGroupAdd();
		}

		return $result;
	}

	public function actionMaterialGroupUpdate() {
		$this->EditModel()->load(faf::request()->post())->addValidator('material_group_name', function () {
			if ($this->EditModel()->materialGroupUpdateCheck(faf::router()->matches['id']) === TRUE) {
				return TRUE;
			} else {
				return 'not unique';
			}
		})->validate();
		if ($this->EditModel()->valid === FALSE) {
			$result = $this->EditModel()->errorsToJson();
		} else {
			$result = $this->EditModel()->materialGroupUpdate(faf::router()->matches['id']);
		}

		return $result;
	}

	public function actionMaterialGroupDelete() {
		return $this->EditModel()->materialGroupDelete(faf::router()->matches['id']);
	}
}
