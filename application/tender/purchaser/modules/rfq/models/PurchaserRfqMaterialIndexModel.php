<?php

namespace tender\purchaser\modules\rfq\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class PurchaserRfqMaterialIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/rfq/sql/material/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	/*
	 * RFQ item material list
	 */
	public function getRfqMaterialList($account_id, $rfq_id) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialList.sql')->prepare([
			'rfq_id' => $rfq_id,
			'account_id' => $account_id,
//		])->execute()->fetchRow();
		])->execute()->fetchAll();
	}
}
