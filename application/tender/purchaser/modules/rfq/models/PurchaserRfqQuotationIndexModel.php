<?php

namespace tender\purchaser\modules\rfq\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class PurchaserRfqQuotationIndexModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function getRfqQuotationList($account_id, $rfq_id) {
		return $this->loadQuery('modules/rfq/sql/rfqQuotationList.sql')->prepare([
			'rfq_id' => $rfq_id,
			'account_id' => $account_id,
//		])->execute()->fetchRow();
		])->execute()->fetchAll();
	}
}
