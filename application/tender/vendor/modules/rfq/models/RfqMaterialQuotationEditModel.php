<?php

namespace tender\vendor\modules\rfq\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class RfqMaterialQuotationEditModel extends SqlModel {

	public static $instance;
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			'rfq_material_quotation_quantity' => [
				'set',
				'float',
			],
			'rfq_material_quotation_delivery_date' => [
				'set',
				'match' => [
					'pattern' => '[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])',
					'message' => 'not a date',
				],
			],
			'rfq_material_quotation_delivery_cost' => [
				'set',
				'float',
			],
			'rfq_material_quotation_tax_cost' => [
				'set',
				'float',
			],
			'rfq_material_quotation_total_cost' => [
				'set',
				'float',
			],
			'rfq_material_quotation_unit_cost' => [
				'set',
				'float',
			],
		];
	}

	public function rfqMaterialGet($account_id, $matches) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialQuotationGet.sql')->prepare([
			'account_id' => $account_id,
		])->prepare($matches)->execute()->fetchRow();
	}

	public function rfqMaterialAdd($account_id, $matches) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialQuotationAdd.sql')->prepare([
			'account_id' => $account_id,
		])->prepare($matches)->execute()->statement;
	}

	public function rfqMaterialAddCheck($account_id, $matches) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialQuotationAddCheck.sql')->prepare([
			'account_id' => $account_id,
		])->prepare($matches)->execute()->fetchRow('count');
	}

	public function rfqMaterialDelete($account_id, $matches) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialQuotationDelete.sql')->prepare([
			'account_id' => $account_id,
		])->prepare($matches)->execute()->statement;
	}

	public function rfqMaterialUpdate($account_id, $matches) {
		return $this->loadQuery('modules/rfq/sql/rfqMaterialQuotationUpdate.sql')->prepare([
			'account_id' => $account_id,
		])->prepare($matches)->execute()->statement;
	}
}
