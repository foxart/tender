<?php

namespace tender\vendor\modules\material\views;

use fa\classes\View;
use fa\core\faf;

class MaterialView extends View {

	public static $instance;

	public function renderMaterialList($data) {
		$company = faf::router()->matches['company'];
		$result = array();
		foreach ($data as $key => $value) {
			$material_update_metadata = faf::converter()->arrayToMetadata([
				'title' => 'change material',
				'modal' => '#material-form-update',
				'container' => '#company_item',
				'populate' => faf::router()->urlTo('/company/company-id/material/get/material-id', [
					'company' => $company,
					'material' => $value['material_id'],
				]),
				'submit' => faf::router()->urlTo('/company/company-id/material/update/material-id', [
					'company' => $company,
					'material' => $value['material_id'],
				]),
				'reload' => faf::router()->urlTo('/company/company-id/material/ajax', [
					'company' => $company,
				]),
			]);
			$material_delete_metadata = faf::converter()->arrayToMetadata([
				'title' => 'delete material',
				'modal' => '#material-form-delete',
				'container' => '#company_item',
				'populate' => faf::router()->urlTo('/company/company-id/material/get/material-id', [
					'company' => $company,
					'material' => $value['material_id'],
				]),
				'submit' => faf::router()->urlTo('/company/company-id/material/delete/material-id', [
					'company' => $company,
					'material' => $value['material_id'],
				]),
				'reload' => faf::router()->urlTo('/company/company-id/material/ajax', [
					'company' => $company,
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
//				'group id' => $value['material_group_id'],
				'group' => $value['material_group_name'],
//				'material id' => $value['material_id'],
				'material' => $value['material_name'],
				'uom' => $value['material_uom'],
				'description' => $value['material_description'],
				'po' => nl2br($value['material_po']),
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
			$table = $this->displayWarningMessage('add company materials');
		} else {
			$table = faf::table()->arrayToTable($result);
		}
		$material_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'add material',
			'modal' => '#material-form-add',
			'container' => '#company_item',
			'material_select' => faf::router()->urlTo('/company/company-id/material/select', [
				'company' => $company,
			]),
			'submit' => faf::router()->urlTo('/company/company-id/material/add', [
				'company' => $company,
			]),
			'reload' => faf::router()->urlTo('/company/company-id/material/ajax', [
				'company' => $company,
			]),
		]);

		return $this->template()->load('material/materialList.twig')->set([
			'table' => $table,
			'material_metadata_add' => $material_metadata_add,
			'material_form_add' => $this->materialFormAdd(),
			'material_form_update' => $this->materialFormUpdate(),
			'material_form_delete' => $this->materialFormDelete(),
		])->render();
	}

	public function materialFormAdd() {
		return $this->template()->load('material/materialFormAdd.twig')->render();
	}

	public function materialFormUpdate() {
		return $this->template()->load('material/materialFormUpdate.twig')->render();
	}

	public function materialFormDelete() {
		return $this->template()->load('material/materialFormDelete.twig')->render();
	}
}
