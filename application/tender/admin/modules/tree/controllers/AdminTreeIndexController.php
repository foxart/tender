<?php

namespace tender\admin\modules\tree\controllers;

use fa\classes\Controller;
use tender\admin\modules\tree\models\AdminTreeIndexModel;
use tender\admin\modules\tree\views\AdminTreeView;

/**
 * Class AdminTreeIndexController
 *
 * @package tender\admin\modules\tree\controllers
 */
class AdminTreeIndexController extends Controller {

	/**
	 * @return AdminTreeIndexModel
	 */
	private function Model() {
		return AdminTreeIndexModel::instance();
	}

	/**
	 * @return AdminTreeView
	 */
	private function View() {
		return AdminTreeView::instance();
	}

	public function actionMaterialList() {
		return $this->View()->renderMaterialTree();
	}

	public function actionMaterialTreeList() {
		$material_list = $this->Model()->materialList();
		$result = $this->View()->renderJsTree($material_list);
		header('Content-Type: application/json');

		return $result;
	}
}
