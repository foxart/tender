<?php

namespace tender\admin\modules\account\material\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class MaterialIndexModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;
//	public static $path = 'modules/account/material/sql/index/';

	public function rules() {
		return [
			'material_title' => [
				'set',
			],
		];
	}

	public function materialListGet($account_id, $company_id) {
		$result = $this->loadQuery('modules/account/material/sql/materialListGet.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchAll();

//		return [];
		return $result;
	}


//	outputAdminAccountMaterialCompanyListMenu
	//actionCompanyListMenu
	public function getCompany($account_id) {
		$result = $this->loadQuery('modules/account/material/sql/companyListGet.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchAll();

		return $result;
	}
}
