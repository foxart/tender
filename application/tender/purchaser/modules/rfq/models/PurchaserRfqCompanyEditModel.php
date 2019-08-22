<?php

namespace tender\purchaser\modules\rfq\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class PurchaserRfqCompanyEditModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/rfq/sql/company/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function rfqVendorCompanySelect($account_id, $rfq_id, $company_name) {
		$data = $this->loadQuery('modules/rfq/sql/rfqVendorCompanySelect.sql')->prepare([
			'account_id' => $account_id,
			'rfq_id' => $rfq_id,
			'company_name' => $company_name,
		])->execute()->fetchAll();
		$result = array();
		foreach ($data as $item) {
			$result[$item['authentication_id']]['text'] = $item['authentication_email'];
			if (isset($result[$item['authentication_id']]['children']) === FALSE) {
				$result[$item['authentication_id']]['children'] = [];
			}
			$child = [
				'id' => $item['company_id'],
				'text' => $item['company_name'],
			];
			array_push($result[$item['authentication_id']]['children'], $child);
		}

		return array_values($result);
	}

	public function rfqVendorCompanyGet($account_id, $rfq_id, $company_id) {
		return $this->loadQuery('modules/rfq/sql/rfqVendorCompanyGet.sql')->prepare([
			'account_id' => $account_id,
			'rfq_id' => $rfq_id,
			'company_id' => $company_id,
		])->execute()->fetchRow();
	}

	//rfqVendorCompanyAdd
	public function rfqVendorCompanyAdd($account_id, $rfq_id, $company_id_array) {
		$this->loadQuery('modules/rfq/sql/rfqVendorCompanyAdd.sql');
		foreach ($company_id_array as $company_id) {
			$this->prepare([
				'account_id' => $account_id,
				'rfq_id' => $rfq_id,
				'company_id' => $company_id,
			])->execute();
		}

		return $this->statement;
	}

	public function rfqCompanyDelete($account_id, $rfq_id, $company_id) {
		return $this->loadQuery('modules/rfq/sql/rfqVendorCompanyDelete.sql')->prepare([
			'account_id' => $account_id,
			'rfq_id' => $rfq_id,
			'company_id' => $company_id,
		])->execute()->statement;
	}
}
