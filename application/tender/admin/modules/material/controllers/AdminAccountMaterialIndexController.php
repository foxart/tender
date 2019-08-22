<?php

namespace tender\admin\modules\material\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\material\models\MaterialIndexModel;
use tender\admin\modules\material\views\MaterialView;

class AdminAccountMaterialIndexController extends Controller {

	/**
	 * @return MaterialIndexModel
	 */
	private function Model() {
		return MaterialIndexModel::instance();
	}

	/**
	 * @return MaterialView
	 */
	private function View() {
		return MaterialView::instance();
	}

	/*
	 * MATERIAL
	 */
	public function actionMaterialList() {
		$get = faf::request()->get();
		$this->Model()->load($get)->validate();
		if ($this->Model()->valid === FALSE) {
			$result = $this->Model()->errorsToJson();
		} else {
			$model = $this->Model()->materialList(faf::request()->get('material'));
			if (empty($model) === TRUE) {
				$result = $this->View()->displayInformationMessage('no records found');
			} else {
				$result = $this->View()->renderMaterialList($model);
			}
		}

		return $result;
	}

	public function actionMaterialListFilter() {
		return $this->View()->renderMaterialListFilter();
	}

	/*
	 * GROUP
	 */
	public function actionMaterialGroupList() {
		$get = faf::request()->get();
		$this->Model()->load($get)->validate();
		if ($this->Model()->valid === FALSE) {
			$result = $this->Model()->errorsToJson();
		} else {
			$model = $this->Model()->materialGroupList(faf::request()->get('group'));
			if (empty($model) === TRUE) {
				$result = $this->View()->displayInformationMessage('no records found');
			} else {
				$result = $this->View()->renderMaterialGroupList($model);
			}
		}

		return $result;
	}

	public function actionMaterialGroupListFilter() {
		return $this->View()->renderMaterialGroupListFilter();
	}
}
