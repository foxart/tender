<?php

namespace tender\vendor\modules\legal\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\legal\models\LegalEditModel;

class LegalEditController extends Controller {

	public function actionLegalSelect() {
		$account = faf::session()->get('account');
//		return json_encode($this->Model()->legalSelect($account['id'], faf::router()->matches['company']));
		$select['items'] = $this->Model()->legalSelect($account['id'], faf::router()->matches['company']);

		return json_encode($select);
	}

	private function Model() {
		return LegalEditModel::instance();
	}

	public function actionLegalGet() {
		$account = faf::session()->get('account');

		return json_encode($this->Model()->legalGet($account['id'], faf::router()->matches['company'], faf::router()->matches['legal']));
	}

	public function actionLegalAdd() {
		$account = faf::session()->get('account');
//		$data = faf::request()->post();
//		dump($data);
		$legal_id_array = faf::request()->post('legal_id');
		$this->Model()->addValidator('legal_id[]', function () {
			if (faf::request()->post('legal_id') === NULL) {
				//todo-ivan fix javascript array field name issue
				return 'please enter legal';
			} else {
				return TRUE;
			}
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->legalAdd($account['id'], faf::router()->matches['company'], $legal_id_array);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionLegalDelete() {
		$account = faf::session()->get('account');

//		$legal = $this->Model()->legalGet($account['id'], faf::router()->matches['company'], faf::router()->matches['legal']);
		return $this->Model()->legalDelete($account['id'], faf::router()->matches['company'], faf::router()->matches['legal']);
	}
}
