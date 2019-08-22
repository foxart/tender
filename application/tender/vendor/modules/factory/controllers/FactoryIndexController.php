<?php

namespace tender\vendor\modules\factory\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\factory\models\FactoryIndexModel;
use tender\vendor\modules\factory\views\IndexView;

class FactoryIndexController extends Controller {

	/**
	 * @return \modules\tender\vendor\profile\factory\models\IndexModel
	 */
	private function Model() {
		return FactoryIndexModel::instance();
	}

	/**
	 * @return \modules\tender\vendor\profile\factory\views\IndexView
	 */
	private function View() {
		return IndexView::instance();
	}

	public function actionFactoryItem() {
		$account = faf::session()->get('account');
		$factory = $this->Model()->factoryItem($account['id'], faf::router()->matches['company']);
		if (empty($factory) === TRUE) {
			return $this->View()->renderFactoryItemAdd();
		} else {
			return $this->View()->renderFactoryItem($factory);
		}
	}
}
