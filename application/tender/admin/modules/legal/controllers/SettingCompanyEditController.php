<?php

namespace tender\admin\modules\legal\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\legal\models\SettingCompanyEditModel;

class SettingCompanyEditController extends Controller {

	/**
	 * @return SettingCompanyEditModel
	 */
	private function EditModel() {
		return SettingCompanyEditModel::instance();
	}

	public function actionCompanyGet() {
		$company = $this->EditModel()->companyGet(faf::router()->matches['company-id']);

		return json_encode($company);
	}

	public function actionCompanyAdd() {
		$result = FALSE;
		if (faf::request()->method() === 'post') {
			$this->EditModel()->load(faf::request()->post());
			$this->EditModel()->addValidator('company_name', function () {
				if ($this->EditModel()->companyAddCheck() === TRUE) {
					return TRUE;
				} else {
					return 'not unique';
				}
			});
			$this->EditModel()->validate();
			if ($this->EditModel()->valid === TRUE) {
				$result = $this->EditModel()->companyAdd();
			} else {
				$result = $this->EditModel()->errorsToJson();
			}
		}

		return $result;
	}

	public function actionCompanyUpdate() {
		$result = FALSE;
		if (faf::request()->method() === 'post') {
			$company_id = faf::router()->matches['company-id'];
			$this->EditModel()->load(faf::request()->post());
			$this->EditModel()->addValidator('company_name', function () use ($company_id) {
				if ($this->EditModel()->companyUpdateCheck($company_id) === TRUE) {
					return TRUE;
				} else {
					return 'not unique';
				}
			});
			$this->EditModel()->validate();
			if ($this->EditModel()->valid === TRUE) {
				$result = $this->EditModel()->companyUpdate($company_id);
			} else {
				$result = $this->EditModel()->errorsToJson();
			}
		}

		return $result;
	}

	public function actionCompanyDelete() {
		if (faf::request()->method() === 'post') {
			$result = json_encode($this->EditModel()->companyDelete(faf::router()->matches['id']));
		} else {
			$result = json_encode($this->EditModel()->companyGet(faf::router()->matches['id']));
		}

		return $result;
	}
}
