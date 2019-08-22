<?php

namespace tender\vendor\modules\rfq\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class RfqIndexModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	/* RFQ list */
	public function getRfqList($account_id) {
		return $this->loadQuery('modules/rfq/sql/rfqList.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchAll();
	}

	/* RFQ item */
	public function getRfqItem($account_id, $rfq_id) {
		return $this->loadQuery('modules/rfq/sql/rfqItem.sql')->prepare([
			'rfq_id' => $rfq_id,
			'account_id' => $account_id,
		])->execute()->fetchRow();
	}

	public function getRfqVendorCompanyMenu($account_id, $rfq_id) {
		return $this->loadQuery('modules/rfq/sql/rfqVendorCompanyMenu.sql')->prepare([
			'rfq_id' => $rfq_id,
			'account_id' => $account_id,
		])->execute()->fetchAll();
	}
}
