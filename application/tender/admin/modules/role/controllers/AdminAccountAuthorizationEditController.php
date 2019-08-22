<?php

namespace tender\admin\modules\role\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\role\models\AuthorizationEditModel;

class AdminAccountAuthorizationEditController extends Controller {

	/**
	 * @return AuthorizationEditModel
	 */
	private function EditModel() {
		return AuthorizationEditModel::instance();
	}

	public function actionAuthorizationGet() {
		$company = $this->EditModel()->authorizationGet(faf::router()->matches['authorization-id']);

		return json_encode($company);
	}

	public function actionAuthorizationAdd() {
		$result = FALSE;
		if (faf::request()->method() === 'post') {
			$this->EditModel()->load(faf::request()->post());
			$this->EditModel()->addValidator('authorization_name', function () {
				if ($this->EditModel()->authorizationAddCheck() === TRUE) {
					return TRUE;
				} else {
					return 'not unique';
				}
			});
			$this->EditModel()->validate();
			if ($this->EditModel()->valid === TRUE) {
				$result = $this->EditModel()->authorizationAdd();
			} else {
				$result = $this->EditModel()->errorsToJson();
			}
		}

		return $result;
	}

	public function actionAuthorizationUpdate() {
		$this->EditModel()->load(faf::request()->post());
		$this->EditModel()->addValidator('authorization_name', function () {
			$authoruzation_id = faf::router()->matches['authorization-id'];
			if ($this->EditModel()->authorizationUpdateCheck($authoruzation_id) === TRUE) {
				return TRUE;
			} else {
				return 'not unique';
			}
		});
		$this->EditModel()->validate();
		if ($this->EditModel()->valid === TRUE) {
			$result = $this->EditModel()->authorizationUpdate(faf::router()->matches['authorization-id']);
		} else {
			$result = $this->EditModel()->errorsToJson();
		}

		return $result;
	}

	public function actionAuthorizationDelete() {
		$result = $this->EditModel()->authorizationDelete(faf::router()->matches['authorization-id']);

		return $result;
	}
}
