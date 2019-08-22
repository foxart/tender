<?php

namespace tender\purchaser\modules\profile\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\purchaser\modules\profile\models\PurchaserProfileIndexModel;
use tender\purchaser\modules\profile\views\PurchaserProfileIndexView;

class PurchaserProfileIndexController extends Controller {

	private function Model() {
		return PurchaserProfileIndexModel::instance();
	}

	private function View() {
		return PurchaserProfileIndexView::instance();
	}

	public function actionVendorCompanyList() {
		$account = faf::session()->get('account');
		$data = $this->Model()->vendorCompanyList($account['id']);

		return $this->View()->renderVendorCompanyList($data);
	}

	public function actionVendorCompany() {
		$account = faf::session()->get('account');
		$data = $this->Model()->vendorCompany($account['id'], faf::router()->matches['vendor_company_id']);

		return $this->View()->renderVendorCompany($data);
	}

	public function actionVendorBankList() {
		$account = faf::session()->get('account');
		$data = $this->Model()->vendorBankList($account['id'], faf::router()->matches['vendor_company_id']);

		return $this->View()->renderVendorBankList($data);
	}

	public function actionVendorMaterialList() {
		$account = faf::session()->get('account');
		$data = $this->Model()->vendorMaterialList($account['id'], faf::router()->matches['vendor_company_id']);

		return $this->View()->renderVendorMaterialList($data);
	}

	public function purchaserCompanyListMenu() {
		$account = faf::session()->get('account');
		if (isset(faf::router()->matches['purchaser_company_id']) === TRUE) {
			$purchaser_company_id = faf::router()->matches['purchaser_company_id'];
		} else {
			$purchaser_company_id = NULL;
		}
		$menu = $this->Model()->purchaserCompanyListMenu($account['id']);
		$result = [
			faf::html()->li([
				'class' => faf::router()->route === '/profile' ? 'active' : 'passive',
			], faf::html()->a([
				'title' => 'All',
				'href' => faf::router()->urlTo('/profile'),
			], 'All')),
		];
		foreach ($menu as $item) {
			$result[] = faf::html()->li([
				'class' => $purchaser_company_id === $item['purchaser_company_id'] ? 'active' : 'passive',
			], faf::html()->a([
				'title' => $item['purchaser_company_name'],
				'href' => faf::router()->urlTo('/profile/purchaser_company_id/vendor_company_id', [
					'purchaser_company_id' => $item['purchaser_company_id'],
					'vendor_company_id' => $item['vendor_company_id'],
				]),
			], $item['purchaser_company_name']));
		}

		return faf::html()->ul([
			'class' => 'nav nav-tabs',
		], implode('', $result));
	}

	public function vendorCompanyListMenu() {
		$account = faf::session()->get('account');
		$company_list = $this->Model()->vendorCompanyListMenu($account['id'], faf::router()->matches['purchaser_company_id']);
		$company_list_menu = array();
		foreach ($company_list as $item) {
			$company_list_menu[] = faf::html()->li([
				'class' => faf::router()->matches['vendor_company_id'] === $item['vendor_company_id'] ? 'active' : 'passive',
			], faf::html()->a([
				'title' => $item['vendor_company_name'],
				'href' => faf::router()->urlTo(faf::router()->route, [
					'purchaser_company_id' => faf::router()->matches['purchaser_company_id'],
					'vendor_company_id' => $item['vendor_company_id'],
				]),
			], $item['vendor_company_name']));
		}

		return faf::html()->ul([
			'class' => 'nav nav-pills nav-stacked',
		], implode('', $company_list_menu));
	}
}
