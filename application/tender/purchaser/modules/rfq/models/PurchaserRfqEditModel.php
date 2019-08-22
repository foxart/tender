<?php

namespace tender\purchaser\modules\rfq\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class PurchaserRfqEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/rfq/sql/rfq/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			'rfq_company_id' => [
				'set',
			],
			'rfq_date_quote' => [
				'set',
			],
			'rfq_date_question' => [
				'set',
			],
			'rfq_name' => [
				'set',
			],
			'rfq_remark' => [
				'any',
			],
			'rfq_term' => [
				'any',
			],
		];
	}

	public function rfqPurchaserCompanyList($account_id) {
		return $this->loadQuery('modules/rfq/sql/rfqPurchaserCompanyList.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->fetchAll();
	}

	/*
	 *
	 */
	public function rfqGet($account_id, $rfq_id) {
		return $this->loadQuery('modules/rfq/sql/rfqGet.sql')->prepare([
			'account_id' => $account_id,
			'rfq_id' => $rfq_id,
		])->execute()->fetchRow();
	}

	public function rfqAdd($account_id) {
		return $this->loadQuery('modules/rfq/sql/rfqAdd.sql')->prepare([
			'account_id' => $account_id,
		])->execute()->statement;
	}

	public function rfqUpdate($account_id, $rfq_id) {
		return $this->loadQuery('modules/rfq/sql/rfqUpdate.sql')->prepare([
			'account_id' => $account_id,
			'rfq_id' => $rfq_id,
		])->execute()->statement;
	}

	public function rfqUpdateCheck($account_id, $rfq_id) {
		return $this->loadQuery('modules/rfq/sql/rfqUpdateCheck.sql')->prepare([
			'account_id' => $account_id,
			'rfq_id' => $rfq_id,
		])->execute()->fetchRow('count');
	}

	public function rfqDelete($account_id, $rfq_id) {
		return $this->loadQuery('modules/rfq/sql/rfqDelete.sql')->prepare([
			'account_id' => $account_id,
			'rfq_id' => $rfq_id,
		])->execute()->statement;
	}
}
