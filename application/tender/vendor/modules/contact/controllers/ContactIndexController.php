<?php

namespace tender\vendor\modules\contact\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\contact\models\ContactIndexModel;
use tender\vendor\modules\contact\views\ContactIndexView;

class ContactIndexController extends Controller {

	private function Model() {
		return ContactIndexModel::instance();
	}

	private function View() {
		return ContactIndexView::instance();
	}

	public function actionContact() {
		$account = faf::session()->get('account');
		$contact = $this->Model()->contact($account['id'], faf::router()->matches['company']);
		if (empty($contact) === TRUE) {
			return $this->View()->renderContactItemAdd();
		} else {
			return $this->View()->renderContactItem($contact);
		}
	}
}
