<?php

namespace tender\vendor\modules\company\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\company\models\CompanyEditModel;

class CompanyEditController extends Controller {

	private function Model() {
		return CompanyEditModel::instance();
	}

	/*
	 * COMPANY
	 */
	public function actionCompanyGet() {
		$account = faf::session()->get('account');

		return json_encode($this->Model()->companyGet($account['id'], faf::router()->matches['company']));
	}

	public function actionCompanyAdd() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->addValidator('company_name', function () use ($account, $data) {
			if ($this->Model()->companyAddCheck($account['id'], $data['company_name']) == 0) {
				return TRUE;
			} else {
				return 'already exist';
			}
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->companyAdd($account['id']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionCompanyUpdate() {
		$account = faf::session()->get('account');
		$data = faf::request()->post();
		$this->Model()->load($data)->addValidator('company_name', function () use ($account, $data) {
			if ($this->Model()->companyUpdateCheck($account['id'], faf::router()->matches['company'], $data['company_name']) == 0) {
				return TRUE;
			} else {
				return 'already exist';
			}
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->companyUpdate($account['id'], faf::router()->matches['company']);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionCompanyDelete() {
		$account = faf::session()->get('account');

		return $this->Model()->companyDelete($account['id'], faf::router()->matches['company']);
	}
}
