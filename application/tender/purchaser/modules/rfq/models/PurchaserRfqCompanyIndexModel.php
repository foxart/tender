<?php

namespace tender\purchaser\modules\rfq\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class PurchaserRfqCompanyIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/rfq/sql/company/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function getRfqVendorCompanyList($account_id, $rfq_id) {
		return $this->loadQuery('modules/rfq/sql/rfqVendorCompanyList.sql')->prepare([
			'rfq_id' => $rfq_id,
			'account_id' => $account_id,
		])->execute()->fetchAll();
	}
}
