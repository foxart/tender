<?php

namespace tender\purchaser\modules\profile\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class PurchaserProfileIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/profile/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function vendorCompanyList($account_id) {
		return $this->loadQuery('modules/profile/sql/vendorCompanyList.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchAll();
	}

	public function vendorCompany($account_id, $company_id) {
		return $this->loadQuery('modules/profile/sql/vendorCompany.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}

	public function vendorBankList($account_id, $company_id) {
		return $this->loadQuery('modules/profile/sql/vendorBankList.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchAll();
	}

	public function vendorMaterialList($account_id, $company_id) {
		return $this->loadQuery('modules/profile/sql/vendorMaterialList.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchAll();
	}

	public function vendorCompanyListMenu($account_id, $purchaser_company_id) {
		return $this->loadQuery('modules/profile/sql/vendorCompanyListMenu.sql')->prepare([
			'account_id' => $account_id,
			'purchaser_company_id' => $purchaser_company_id,
		])->execute()->fetchAll();
	}

	public function purchaserCompanyListMenu($account_id) {
		return $this->loadQuery('modules/profile/sql/purchaserCompanyListMenu.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchAll();
	}
}
