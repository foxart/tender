<?php

namespace tender\vendor\modules\company\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\company\models\CompanyIndexModel;
use tender\vendor\modules\company\views\CompanyIndexView;

class CompanyIndexController extends Controller {

	private function Model() {
		return CompanyIndexModel::instance();
	}

	private function View() {
		return CompanyIndexView::instance();
	}

	public function outputCompanyList() {
		$account = faf::session()->get('account');
		$company_list = $this->Model()->companyList($account['id']);

		return $this->View()->renderCompanyList($company_list);
	}

	public function actionCompanyItem() {
		$account = faf::session()->get('account');

		return $this->View()->renderCompanyItem($this->Model()->companyItem($account['id'], faf::router()->matches['company']));
	}

	public function outputCompanyForm() {
		return $this->View()->renderCompanyForm();
	}

	public function companyListMenu() {
		$account = faf::session()->get('account');
		$company_list = self::Model()->companyListMenu($account['id']);
		$menu = array();
		foreach ($company_list as $item) {
			$menu[] = [
				'route' => faf::router()->urlTo(faf::router()->route, [
					'company' => $item['id'],
				]),
				'text' => $item['name'],
			];
		}

		return faf::menu()->renderBootstrapMenu($menu, 'nav nav-pills nav-stacked');
	}
}
