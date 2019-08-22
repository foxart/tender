<?php

namespace tender\vendor\modules\company\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class CompanyIndexModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function companyList($account_id) {
		return $this->loadQuery('modules/company/sql/companyList.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchAll();
	}

	public function companyListMenu($account_id) {
		return $this->loadQuery('modules/company/sql/companyListMenu.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchAll();
	}

	public function companyItem($account_id, $company_id) {
		return $this->loadQuery('modules/company/sql/companyItem.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}

	public function companyTitleList() {
		return $this->loadQuery('modules/company/sql/companyTitleList.sql')->execute()->fetchAll();
	}

	public function companyTypeList() {
		return $this->loadQuery('modules/company/sql/companyTypeList.sql')->execute()->fetchAll();
	}
}
