<?php

namespace tender\admin\modules\legal\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class SettingCompanyEditModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	public function rules() {
		return [
			'company_name' => [
				'set',
			],
		];
	}

	public function companyGet($company_id) {
		$result = $this->loadQuery('modules/legal/sql/companyGet.sql')->prepare([
			'company_id' => $company_id,
		])->execute()->fetchRow();

		return $result;
	}

	public function companyAdd() {
		$result = $this->loadQuery('modules/legal/sql/companyAdd.sql')->execute()->statement;

		return $result;
	}

	/**
	 * @return bool
	 */
	public function companyAddCheck() {
		$this->loadQuery('modules/legal/sql/companyAddCheck.sql')->execute()->fetchRow();
		if ($this->count === 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function companyUpdate($company_id) {
		$result = $this->loadQuery('modules/legal/sql/companyUpdate.sql')->prepare([
			'company_id' => $company_id,
		])->execute()->statement;

		return $result;
	}

	/**
	 * @param $company_id int
	 *
	 * @return bool
	 */
	public function companyUpdateCheck($company_id) {
		$result = $this->loadQuery('modules/legal/sql/companyUpdateCheck.sql')->prepare([
			'company_id' => $company_id,
		])->execute()->fetchRow('count');
		if ($result == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function companyDelete($company_id) {
		$result = $this->loadQuery('modules/legal/sql/companyDelete.sql')->prepare([
			'company_id' => $company_id,
		])->execute()->statement;

		return $result;
	}
}
