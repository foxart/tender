<?php

namespace tender\admin\modules\account\company\views;

use fa\classes\View;
use fa\core\faf;

class AdminAccountCompanyView extends View {

	public static $instance;

	public function renderCompanyList($account_id, $company) {
		$button_add_metadata = faf::converter()->arrayToMetadata([
			'modal' => '#form-company-add',
			'title' => 'Assign company',
			'container' => '#company-list',
			'select2' => faf::router()->urlTo('/users/purchaser/account-id/company/list_not_binded', [
				'account-id' => faf::router()->matches['account-id'],
			]),
			'submit' => faf::router()->urlTo('/users/purchaser/account-id/company/add', [
				'account-id' => faf::router()->matches['account-id'],
			]),
			'reload' => faf::router()->urlTo('/users/purchaser/account-id/company/list', [
				'account-id' => faf::router()->matches['account-id'],
			]),
		]);
		if (empty($company) === FALSE) {
			$table = array();
			foreach ($company as $key => $value) {
				$company_delete_metadata = faf::converter()->arrayToMetadata([
					'modal' => '#form-company-delete',
					'title' => 'Remove company',
					'container' => '#company-list',
					'submit' => faf::router()->urlTo('/users/purchaser/account-id/company/delete', [
						'account-id' => $account_id,
						'company-id' => $value['company_id'],
					]),
					'reload' => faf::router()->urlTo('/users/purchaser/account-id/company/list', [
						'account-id' => $account_id,
					]),
				]);
				$table[] = [
					"Company Id" => $value['id'],
					"Company Name" => faf::html()->span([
							'class' => 'glyphicon glyphicon-folder-open',
						], '&nbsp;') . faf::html()->a([
							'href' => faf::router()->urlTo('/users/purchaser/account-id/company/company-id/material', [
								'company-id' => $value['company_id'],
								'account-id' => $account_id,
							]),
						], $value['text']),
					"Action" => faf::html()->a([
						'href' => '#',
						'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $company_delete_metadata,
					], ''),
				];
			}
			$content = faf::table()->arrayToTable($table);
		} else {
			$content = $this->displayWarningMessage('Add company to purchaser');
		}
		$result = $this->template()->load('account/company/index.twig')->set([
			'content' => $content,
			'button_add_metadata' => $button_add_metadata,
			'modal_company_add' => $this->renderCompanyAddform(),
			'modal_binded_company_delete' => $this->renderCompanyDeleteform(),
			'back_url' => faf::router()->urlTo('/users'),
		])->render();

		return $result;
	}

	public function renderCompanyAddform() {
		$result = $this->template()->load('account/company/companyFormAdd.twig')->render();

		return $result;
	}

	public function renderCompanyDeleteform() {
		$result = $this->template()->load('account/company/companyFormDelete.twig')->render();

		return $result;
	}
}
