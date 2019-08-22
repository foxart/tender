<?php

namespace tender\vendor\modules\rfq\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class RfqMaterialQuotationIndexModel extends SqlModel {

	public static $instance;
//	public static $path = 'vendor/modules/rfq/sql/material/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	/*
	 * RFQ item material list
	 */
	public function getRfqMaterialList($account_id, $rfq_id, $vendor_company_id) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialQuotationList.sql')->prepare([
			'account_id' => $account_id,
			'rfq_id' => $rfq_id,
//			'rfq_cross_vendor_company_id' => $rfq_cross_vendor_company_id,
			'vendor_company_id' => $vendor_company_id,
//		])->execute()->fetchRow();
		])->execute()->fetchAll();
	}
}
