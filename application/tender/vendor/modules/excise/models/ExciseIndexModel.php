<?php

namespace tender\vendor\modules\excise\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class ExciseIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/profile/excise/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
	}

	public function exciseItem($account_id, $company_id) {
		return $this->loadQuery('modules/excise/sql/exciseItem.sql')->prepare([
			'account_id' => $account_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}

	public function exciseBasisList() {
		return $this->loadQuery('modules/excise/sql/exciseBasisList.sql')->execute()->fetchAll();
	}

	public function exciseTaxList() {
		return $this->loadQuery('modules/excise/sql/exciseTaxList.sql')->execute()->fetchAll();
	}

	public function exciseExciseEnum() {
		$type = $this->loadQuery('modules/excise/sql/exciseRegistrationEnum.sql')->execute()->fetchRow('Type');
		preg_match('/^enum\(\'(.*)\'\)$/', $type, $matches);

		return explode("','", $matches[1]);
	}

	public function exciseSalesEnum() {
		$type = $this->loadQuery('modules/excise/sql/exciseSalesEnum.sql')->execute()->fetchRow('Type');
		preg_match('/^enum\(\'(.*)\'\)$/', $type, $matches);

		return explode("','", $matches[1]);
	}

	public function exciseServiceEnum() {
		$type = $this->loadQuery('modules/excise/sql/exciseServiceEnum.sql')->execute()->fetchRow('Type');
		preg_match('/^enum\(\'(.*)\'\)$/', $type, $matches);

		return explode("','", $matches[1]);
	}
}
