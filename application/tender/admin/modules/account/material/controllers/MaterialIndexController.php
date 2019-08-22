<?php

namespace tender\admin\modules\account\material\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\account\material\models\MaterialIndexModel;
use tender\admin\modules\account\material\views\MaterialView;

class MaterialIndexController extends Controller {

	/**
	 * @return MaterialIndexModel
	 */
	public function IndexModel() {
		return MaterialIndexModel::instance();
	}

	/**
	 * @return MaterialView
	 */
	public function View() {
		return MaterialView::instance();
	}

	public function actionMaterialList() {
		$data = $this->IndexModel()->materialListGet(faf::router()->matches['account-id'], faf::router()->matches['company-id']);

		return $this->View()->materialList($data);
	}

	public function companyMenu() {
		$company_list = $this->IndexModel()->getCompany(faf::router()->matches['account-id']);

		return $this->View()->companyListMenu($company_list);
	}
}
