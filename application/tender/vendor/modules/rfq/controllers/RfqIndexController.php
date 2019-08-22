<?php

namespace tender\vendor\modules\rfq\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\rfq\models\RfqIndexModel;
use tender\vendor\modules\rfq\views\RfqView;

class RfqIndexController extends Controller {

	private function Model() {
		return RfqIndexModel::instance();
	}

	private function View() {
		return RfqView::instance();
	}

	public function outputRfqListFilter() {
		return $this->View()->renderRfqListFilter();
	}

	public function outputRfqList() {
		$account = faf::session()->get('account');
		$data = $this->Model()->getRfqList($account['id']);

		return $this->View()->renderRfqList($data);
	}

	public function outputRfqItem() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$data = $this->Model()->getRfqItem($account['id'], $rfq_id);

		return $this->View()->renderRfqItem($data);
	}

	public function outputRfqVendorCompanyMenu() {
		$account = faf::session()->get('account');
		$rfq_id = faf::router()->matches['rfq_id'];
		$model_company_menu = $this->Model()->getRfqVendorCompanyMenu($account['id'], $rfq_id);
		$company_menu[] = [
			'text' => 'All',
			'route' => faf::router()->urlTo("/rfq/rfq_id", [
				'rfq_id' => $rfq_id,
				'rfq_cross_vendor_company_id' => NULL,
			]),
		];
		foreach ($model_company_menu as $item) {
			$company_menu[] = [
				'text' => $item['name'],
				'route' => faf::router()->urlTo('/rfq/rfq_id/vendor_company_id', [
					'rfq_id' => $rfq_id,
					'vendor_company_id' => $item['id'],
				]),
			];
		}

		return faf::menu()->renderBootstrapMenu($company_menu, 'nav nav-tabs');
	}

	public function outputRfqItemUrlBack() {
		return $this->View()->renderRfqItemUrlBack();
	}
}
