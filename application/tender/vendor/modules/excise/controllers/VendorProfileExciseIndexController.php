<?php

namespace tender\vendor\modules\excise\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\excise\models\ExciseIndexModel;
use tender\vendor\modules\excise\views\ExciseIndexView;

class VendorProfileExciseIndexController extends Controller {

	/**
	 * @return \modules\tender\vendor\profile\excise\models\VendorProfileExciseIndexModel
	 */
	private function Model() {
		return ExciseIndexModel::instance();
	}

	/**
	 * @return \modules\tender\vendor\profile\excise\views\VendorProfileExciseIndexView
	 */
	private function View() {
		return ExciseIndexView::instance();
	}

	public function actionExcise() {
		$account = faf::session()->get('account');
		$excise = $this->Model()->exciseItem($account['id'], faf::router()->matches['company']);
//		dump($contact);
//		exit;
		if (empty($excise) === TRUE) {
			return $this->View()->renderExciseItemAdd();
		} else {
			return $this->View()->renderExciseItem($excise);
		}
	}
}
