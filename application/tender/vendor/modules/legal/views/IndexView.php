<?php

namespace tender\vendor\modules\legal\views;

use fa\classes\View;
use fa\core\faf;

class IndexView extends View {

	public static $instance;

	public function renderLegalList($data) {
		$company = faf::router()->matches['company'];
		$reload_url = faf::router()->urlTo('/company/company-id/legal/ajax', [
			'company' => $company,
		]);
		$result = array();
		foreach ($data as $key => $value) {
			$legal_delete_metadata = faf::converter()->arrayToMetadata([
				'title' => 'delete legal entity',
				'modal' => '#legal-form-delete',
				'container' => '#company_item',
				'populate' => faf::router()->urlTo('/company/company-id/legal/get/legal-id', [
					'company' => $company,
					'legal' => $value['legal_id'],
				]),
				'submit' => faf::router()->urlTo('/company/company-id/legal/delete/legal-id', [
					'company' => $company,
					'legal' => $value['legal_id'],
				]),
				'reload' => $reload_url,
			]);
			$result[] = [
				'№' => $value['row'],
				'code' => $value['legal_id'],
				'name' => $value['legal_name'],
				"action" => faf::html()->a([
					'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $legal_delete_metadata,
					'title' => "Delete",
					'href' => '#',
				], ''),
			];
		}
		if (empty($result) === TRUE) {
			$table = $this->displayWarningMessage('add company legal entities');
		} else {
			$table = faf::table()->arrayToTable($result);
		}
		$legal_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'add legal entity',
			'modal' => '#legal-form-add',
			'container' => '#company_item',
			'select_url' => faf::router()->urlTo('/company/company-id/legal/select', [
				'company' => $company,
			]),
			'submit' => faf::router()->urlTo('/company/company-id/legal/add', [
				'company' => $company,
			]),
			'reload' => $reload_url,
		]);

		return $this->template()->load('legal/legalList.twig')->set([
			'table' => $table,
			'legal_metadata_add' => $legal_metadata_add,
			'legal_form_add' => $this->legalFormAdd(),
//			'legal_form_update' => faf::template()->load('legal/legalFormUpdate.twig')->render(),
			'legal_form_delete' => $this->legalFormDelete(),
			'back_url' => faf::router()->urlTo('/company'),
		])->render();
	}

	public function legalFormAdd() {
		return $this->template()->load('legal/legalFormAdd.twig')->render();
	}

	public function legalFormDelete() {
		return $this->template()->load('legal/legalFormDelete.twig')->render();
	}
}
