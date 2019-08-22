<?php

namespace tender\vendor\modules\company\views;

use fa\classes\View;
use fa\core\faf;
use tender\vendor\modules\company\models\CompanyIndexModel;

class CompanyIndexView extends View {

	public static $instance;

	private function Model() {
		return CompanyIndexModel::instance();
	}

	/* companies */
	public function renderCompanyList($company_list) {
		$result = array();
		$company_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'add company',
			'modal' => '#company-form',
			'container' => '#company_list',
			'submit' => faf::router()->urlTo('/company/add'),
			'reload' => faf::router()->urlTo('/company/ajax'),
		]);
		foreach ($company_list as $key => $value) {
			$company_delete_metadata = faf::converter()->arrayToMetadata([
				'title' => 'delete company',
				'modal' => '#company-form',
				'container' => '#company_list',
				'disable' => [],
				'populate' => faf::router()->urlTo('/company/company-id/get', [
					'company' => $value['id'],
				]),
				'submit' => faf::router()->urlTo('/company/company-id/delete', [
					'company' => $value['id'],
				]),
				'reload' => faf::router()->urlTo('/company/ajax'),
			]);
			$result[] = [
				'№' => $value['row'],
				'code' => $value['id'],
				'name' => faf::html()->span([
						'class' => 'glyphicon glyphicon-folder-open',
					], '&nbsp;') . faf::html()->a([
						'title' => 'Edit',
						'href' => faf::router()->urlTo('/company/company-id', [
							'company' => $value['id'],
						]),
					], $value['name']),
				'title' => $value['title'],
				'type' => $value['type'],
				'action' => faf::html()->a([
					'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $company_delete_metadata,
					'title' => "Delete",
					'href' => '#',
				], ''),
			];
		}
		$table = faf::table()->arrayToTable($result);

		return $this->template()->load('company/companyList.twig')->set([
			'table' => $table,
//			'company_form_add' => $this->renderCompanyForm(),
			'company_metadata_add' => $company_metadata_add,
		])->render();
	}

	/*
	 * company
	 */
	public function renderCompanyItem($company) {
		if (empty($company) === TRUE) {
			return $this->displayErrorMessage('company not found');
		} else {
			$id = faf::router()->matches['company'];
			$company_metadata_update = faf::converter()->arrayToMetadata([
				'title' => 'change company',
				'modal' => '#company-form',
				'container' => '#company_item',
				'populate' => faf::router()->urlTo('/company/company-id/get', [
					'company' => $id,
				]),
				'submit' => faf::router()->urlTo('/company/company-id/update', [
					'company' => $id,
				]),
				'reload' => faf::router()->urlTo('/company/company-id/ajax', [
					'company' => $id,
				]),
			]);

			return $this->template()->load('company/companyItem.twig')->set([
				'company_id' => $company['company_id'],
				'company_name' => $company['company_name'],
				'company_title' => $company['company_title_name'],
				'company_type' => $company['company_type_name'],
			])->set([
//				'company_form_update' => $this->renderCompanyForm(),
				'company_metadata_update' => $company_metadata_update,
				'back_url' => faf::router()->urlTo('/company'),
			])->render();
		}
	}

	public function renderCompanyForm() {
		$company_title_option = faf::html()->options($this->Model()->companyTitleList());
		$company_type_option = faf::html()->options($this->Model()->companyTypeList());

		return $this->template()->load('company/companyForm.twig')->set([
			'company_title_option' => $company_title_option,
			'company_type_option' => $company_type_option,
		])->render();
	}
}
