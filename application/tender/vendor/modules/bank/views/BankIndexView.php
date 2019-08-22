<?php

namespace tender\vendor\modules\bank\views;

use fa\classes\View;
use fa\core\faf;

class BankIndexView extends View {

	public static $instance;

	public function renderBankList($data) {
		$company = faf::router()->matches['company'];
		$result = array();
		foreach ($data as $key => $value) {
			$bank_update_metadata = faf::converter()->arrayToMetadata([
				'title' => 'change bank details',
				'modal' => '#bank-form-update',
				'container' => '#company_item',
				'populate' => faf::router()->urlTo('/company/company-id/bank/get/bank-id', [
					'company' => $company,
					'bank' => $value['id'],
				]),
				'submit' => faf::router()->urlTo('/company/company-id/bank/update/bank-id', [
					'company' => $company,
					'bank' => $value['id'],
				]),
				'reload' => faf::router()->urlTo('/company/company-id/bank/ajax', [
					'company' => $company,
				]),
			]);
			$bank_delete_metadata = faf::converter()->arrayToMetadata([
				'title' => 'delete bank details',
				'modal' => '#bank-form-delete',
				'container' => '#company_item',
				'populate' => faf::router()->urlTo('/company/company-id/bank/get/bank-id', [
					'company' => $company,
					'bank' => $value['id'],
				]),
				'submit' => faf::router()->urlTo('/company/company-id/bank/delete/bank-id', [
					'company' => $company,
					'bank' => $value['id'],
				]),
				'reload' => faf::router()->urlTo('/company/company-id/bank/ajax', [
					'company' => $company,
				]),
			]);
			$result[] = [
				'№' => $value['row'],
//				'id' => $value['id'],
				'key' => $value['key'],
				'account' => $value['account'],
				'holder' => $value['holder'],
				"action" => faf::html()->a([
						'class' => 'glyphicon glyphicon-pencil bs-modal-link ' . $bank_update_metadata,
						'title' => 'Edit',
						'href' => '#',
					], '') . '&nbsp;' . faf::html()->a([
						'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $bank_delete_metadata,
						'title' => "Delete",
						'href' => '#',
					], ''),
			];
		}
		if (empty($result) === TRUE) {
			$table = $this->displayWarningMessage('add bank details');
		} else {
			$table = faf::table()->arrayToTable($result);
		}
		$bank_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'add bank details',
			'modal' => '#bank-form-add',
			'container' => '#company_item',
			'submit' => faf::router()->urlTo('/company/company-id/bank/add', [
				'company' => $company,
			]),
			'reload' => faf::router()->urlTo('/company/company-id/bank/ajax', [
				'company' => $company,
			]),
		]);

		return $this->template()->load('bank/bankList.twig')->set([
			'table' => $table,
			'bank_metadata_add' => $bank_metadata_add,
			'bank_form_add' => $this->bankFormAdd(),
			'bank_form_update' => $this->bankFormUpdate(),
			'bank_form_delete' => $this->bankFormDelete(),
		])->render();
	}

	public function bankFormAdd() {
		return $this->template()->load('bank/bankFormAdd.twig')->render();
	}

	public function bankFormUpdate() {
		return $this->template()->load('bank/bankFormUpdate.twig')->render();
	}

	public function bankFormDelete() {
		return $this->template()->load('bank/bankFormDelete.twig')->render();
	}
}
