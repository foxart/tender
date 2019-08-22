<?php

namespace tender\vendor\modules\material\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\material\models\MaterialIndexModel;
use tender\vendor\modules\material\views\MaterialView;

class MaterialIndexController extends Controller {

	private function Model() {
		return MaterialIndexModel::instance();
	}

	private function View() {
		return MaterialView::instance();
	}

	public function actionMaterialList() {
		$account = faf::session()->get('account');
		$data = $this->Model()->materialList($account['id'], faf::router()->matches['company']);

		return $this->View()->renderMaterialList($data);
	}
}
