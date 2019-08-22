<?php

namespace tender\admin\modules\account\material\views;

use fa\classes\View;
use fa\core\faf;

class MaterialView extends View {

	public static $instance;

	public function companyListMenu($company_list) {
		$company_list_menu = array();
		foreach ($company_list as $item) {
			$company_list_menu[] = faf::html()->li([
				'class' => faf::router()->matches['company-id'] === $item['company_id'] ? 'active' : 'passive',
			], faf::html()->a([
				'title' => $item['name'],
				'href' => faf::router()->urlTo(faf::router()->route, [
					'company-id' => $item['company_id'],
					'account-id' => faf::router()->matches['account-id'],
				]),
			], $item['name']));
		}

		return faf::html()->ul([
			'class' => 'nav nav-pills nav-stacked',
		], implode('', $company_list_menu));
	}

	public function materialList($material_list) {
		$result = array();
		$account_id = faf::router()->matches['account-id'];
		$company_id = faf::router()->matches['company-id'];
		foreach ($material_list as $key => $value) {
			$material_update_metadata = faf::converter()->arrayToMetadata([
				'modal' => '#material-form-update',
				'container' => '#content',
				'title' => 'Edit material',
				'populate' => faf::router()->urlTo('/users/purchaser/account-id/company/company-id/material/material-id/get', [
					'account-id' => $account_id,
					'company-id' => $company_id,
					'material-id' => $value['material_id'],
				]),
				'submit' => faf::router()->urlTo('/users/purchaser/account-id/company/company-id/material/material-id/update', [
					'account-id' => $account_id,
					'company-id' => $company_id,
					'material-id' => $value['material_id'],
				]),
				'reload' => faf::router()->urlTo('/users/purchaser/account-id/company/company-id/material/ajax', [
					'account-id' => $account_id,
					'company-id' => $company_id,
				]),
			]);
			$material_delete_metadata = faf::converter()->arrayToMetadata([
				'modal' => '#material-form-delete',
				'container' => '#content',
				'title' => 'Remove material',
				'populate' => faf::router()->urlTo('/users/purchaser/account-id/company/company-id/material/material-id/get', [
					'account-id' => $account_id,
					'company-id' => $company_id,
					'material-id' => $value['material_id'],
				]),
				'submit' => faf::router()->urlTo('/users/purchaser/account-id/company/company-id/material/material-id/delete', [
					'account-id' => $account_id,
					'company-id' => $company_id,
					'material-id' => $value['material_id'],
				]),
				'reload' => faf::router()->urlTo('/users/purchaser/account-id/company/company-id/material/ajax', [
					'account-id' => $account_id,
					'company-id' => $company_id,
				]),
			]);
			if ($value['material_file'] !== NULL) {
				$file = faf::html()->span([
						'class' => 'glyphicon glyphicon-file',
					], '&nbsp;') . faf::html()->a([
						'class' => 'fa-js-blank',
						'title' => 'Edit',
						'href' => faf::router()->urlTo('/files', [
							'file' => $value['material_file'],
						]),
					], $value['material_title']);
			} else {
				$file = $value['material_title'];
			}
			$result[] = [
				'№' => $value['row'],
//				'id' => $value['id'],
//				'group id' => $value['material_group_id'],
				'group' => $value['material_group_name'],
//				'material id' => $value['material_id'],
				'material' => $value['material_name'],
				'uom' => $value['material_uom'],
				'description' => $value['material_description'],
				'po' => $value['material_po'],
				'file' => $file,
				"action" => faf::html()->a([
						'class' => 'glyphicon glyphicon-pencil bs-modal-link ' . $material_update_metadata,
						'title' => 'Edit',
						'href' => '#',
					], '') . '&nbsp;' . faf::html()->a([
						'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $material_delete_metadata,
						'title' => "Delete",
						'href' => '#',
					], ''),
			];
		}
		if (empty($result) === TRUE) {
			$table = $this->displayWarningMessage('assign company materials');
		} else {
			$table = faf::table()->arrayToTable($result);
		}
		$material_metadata_add = faf::converter()->arrayToMetadata([
			'modal' => '#material-form-add',
			'container' => '#content',
			'title' => 'Assign material',
			'material_select' => faf::router()->urlTo('/users/purchaser/account-id/company/company-id/material/select', [
				'account-id' => faf::router()->matches['account-id'],
				'company-id' => faf::router()->matches['company-id'],
			]),
			'submit' => faf::router()->urlTo('/users/purchaser/account-id/company/company-id/material/add', [
				'account-id' => faf::router()->matches['account-id'],
				'company-id' => faf::router()->matches['company-id'],
			]),
			'reload' => faf::router()->urlTo('/users/purchaser/account-id/company/company-id/material/ajax', [
				'account-id' => faf::router()->matches['account-id'],
				'company-id' => faf::router()->matches['company-id'],
			]),
		]);
		$material_form_add = $this->template()->load('account/material/materialFormAdd.twig')->render();
		$material_form_update = $this->template()->load('account/material/materialFormUpdate.twig')->render();
		$material_form_delete = $this->template()->load('account/material/materialFormDelete.twig')->render();

		return $this->template()->load('account/material/materialList.twig')->set([
			'table' => $table,
			'material_metadata_add' => $material_metadata_add,
			'material_form_add' => $material_form_add,
			'material_form_update' => $material_form_update,
			'material_form_delete' => $material_form_delete,
			'companies_url' => faf::router()->urlTo('/users/purchaser/account-id/company', [
				'account-id' => faf::router()->matches['account-id'],
			]),
		])->render();
	}
}
