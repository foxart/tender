<?php

namespace tender\admin\modules\legal\views;

use fa\classes\View;
use fa\core\faf;

class SettingCompanyView extends View {

	public static $instance;

	public function renderIndexPage($company_list) {
		$company_add_button_metadata = faf::converter()->arrayToMetadata([
			'modal' => '#company-form',
			'container' => '#company-list',
			'title' => 'Add company',
			'submit' => faf::router()->urlTo('/settings/company/add'),
			'reload' => faf::router()->urlTo('/settings/company/list'),
		]);

		return $this->template()->load('setting/company/index.twig')->set([
			'company_list' => $this->renderCompanyList($company_list),
			'company_form' => $this->renderCompanyForm(),
			'company_add_button' => faf::html()->a([
				'class' => 'btn btn-block btn-primary btn-sm bs-modal-link ' . $company_add_button_metadata,
				'href' => '#',
			], 'Add'),
		])->render();
	}

	public function renderCompanyForm() {
		return $this->template()->load('setting/company/companyForm.twig')->render();
	}

	public function renderCompanyList($company_list) {
		$table = array();
		if (empty($company_list) === FALSE) {
			foreach ($company_list as $key => $value) {
				$company_update_button_metadata = faf::converter()->arrayToMetadata([
					'modal' => '#company-form',
					'container' => '#company-list',
					'title' => 'Edit company',
					'populate' => faf::router()->urlTo('/settings/company/company-id', ['company-id' => $value['company_id']]),
					'submit' => faf::router()->urlTo('/settings/company/update', ['company-id' => $value['company_id']]),
					'reload' => faf::router()->urlTo('/settings/company/list'),
				]);
				$company_delete_button_metadata = faf::converter()->arrayToMetadata([
					'modal' => '#company-form',
					'container' => '#company-list',
					'title' => 'Delete company',
					'disable' => [],
					'submit' => faf::router()->urlTo('/settings/company/delete', ['id' => $value['company_id']]),
					'populate' => faf::router()->urlTo('/settings/company/delete', ['id' => $value['company_id']]),
					'reload' => faf::router()->urlTo('/settings/company/list'),
				]);
				$table[] = [
					"№" => $value['row'],
//					"legal entity code" => $value['company_code'],
					"legal entity" => $value['company_name'],
					'action' => faf::html()->a([
							'class' => 'glyphicon glyphicon-pencil bs-modal-link ' . $company_update_button_metadata,
							'title' => 'Edit',
							'href' => '#',
						], '') . '&nbsp;' . faf::html()->a([
							'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $company_delete_button_metadata,
							'title' => "Delete",
							'href' => '#',
						], ''),
				];
			}
			$content = faf::table()->arrayToTable($table);
		} else {
			$content = $this->displayWarningMessage('add company company');
		}

		return $content;
	}
}
