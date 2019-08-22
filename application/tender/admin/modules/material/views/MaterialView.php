<?php

namespace tender\admin\modules\material\views;

use fa\classes\View;
use fa\core\faf;
use tender\admin\modules\material\models\MaterialIndexModel;

class MaterialView extends View {

	public static $instance;

	private function Model() {
		return MaterialIndexModel::instance();
	}

	/*
	* MATERIAL
	*/
	public function renderMaterialList($material) {
		$material_add_url = faf::router()->urlTo('/materials/material/add');
		$material_reload_url = faf::request()->createUrl([
			'path' => faf::router()->urlTo('/materials/material/list'),
			'get' => [
				'material_name' => faf::request()->get('material_name'),
			],
		]);
		$material_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'add material',
			'modal' => '#material-form-edit',
			'container' => '#material-list',
			'submit' => $material_add_url,
			'reload' => $material_reload_url,
		]);
		$material_group_list = $this->Model()->getMaterialGroupSelect();
		$material_uom_list = $this->Model()->getMaterialUomSelect();
		$count = 1;
		$table = array();
		foreach ($material as $key => $value) {
			$material_populate_url = faf::router()->urlTo('/materials/material/get', [
				'id' => $value['material_id'],
			]);
			$material_update_url = faf::router()->urlTo('/materials/material/update', [
				'id' => $value['material_id'],
			]);
			$material_delete_url = faf::router()->urlTo('/materials/material/delete', [
				'id' => $value['material_id'],
			]);
			$material_update_metadata = faf::converter()->arrayToMetadata([
				'title' => 'edit material',
				'modal' => '#material-form-edit',
				'container' => '#material-list',
				'populate' => $material_populate_url,
				'submit' => $material_update_url,
				'reload' => $material_reload_url,
			]);
			$material_delete_metadata = faf::converter()->arrayToMetadata([
				'title' => 'delete material',
				'modal' => '#material-form-delete',
				'container' => '#material-list',
				'populate' => $material_populate_url,
				'submit' => $material_delete_url,
				'reload' => $material_reload_url,
			]);
			$table[] = [
				"№" => $value['row'],
				"Material" => $value['material_name'],
				"Group" => $value['material_group_name'],
				"Short Description" => $value['material_description'],
				"UOM" => $value['material_uom'],
				"PO Text" => nl2br($value['material_po']),
				'action' => faf::html()->a([
						'class' => 'glyphicon glyphicon-pencil bs-modal-link ' . $material_update_metadata,
						'title' => 'Edit',
						'href' => '#',
					], '') . '&nbsp;' . faf::html()->a([
						'class' => 'glyphicon glyphicon-trash bs-modal-link ' . $material_delete_metadata,
						'title' => "Delete",
						'href' => '#',
					], ''),
			];
			$count++;
		}
		$result = faf::table()->arrayToTable($table);

		return $this->template()->load('material/materialList.twig')->set([
			'content' => $result,
			'material_metadata_add' => $material_metadata_add,
			'material_form_edit' => $this->renderMaterialFormEdit($material_group_list, $material_uom_list),
			'material_form_delete' => $this->renderMaterialFormDelete($material_group_list, $material_uom_list),
		])->render();
	}

	public function renderMaterialListFilter() {
		$material_list_filter_metadata = faf::converter()->arrayToMetadata([
			'container' => '#material-list',
			'submit' => faf::router()->urlTo('/materials/material/list'),
		]);

		return $this->template()->load('material/materialListFilter.twig')->set([
			'material_list_filter_metadata' => $material_list_filter_metadata,
		])->render();
	}

	/*
	 * MATERIAL EDIT
	 */
	public function renderMaterialFormEdit($material_group_list, $material_uom_list) {
		return $this->template()->load('material/materialFormEdit.twig')->set([
			'material_group_option' => faf::html()->options($material_group_list),
			'material_uom_option' => faf::html()->options($material_uom_list),
		])->render();
	}

	public function renderMaterialFormDelete($material_group_list, $material_uom_list) {
		return $this->template()->load('material/materialFormDelete.twig')->set([
			'material_group_option' => faf::html()->options($material_group_list),
			'material_uom_option' => faf::html()->options($material_uom_list),
		])->render();
	}

	/*
	* MATERIAL GROUP
	*/
	public function renderMaterialGroupList($material_group_list) {
		$material_group_reload_url = faf::router()->urlTo('/materials/group/list');
		$material_group_add_url = faf::router()->urlTo('/materials/group/add');
		$material_group_metadata_add = faf::converter()->arrayToMetadata([
			'title' => 'add material group',
			'modal' => '#material-group-form-edit',
			'container' => '#material-group-list',
			'submit' => $material_group_add_url,
			'reload' => $material_group_reload_url,
		]);
		$table = array();
		foreach ($material_group_list as $key => $value) {
			$material_group_populate_url = faf::router()->urlTo('/materials/group/get', [
				'id' => $value['id'],
			]);
			$material_update_url = faf::router()->urlTo('/materials/group/update', [
				'id' => $value['id'],
			]);
			$material_group_delete_url = faf::router()->urlTo('/materials/group/delete', [
				'id' => $value['id'],
			]);
			$material_update_metadata = faf::converter()->arrayToMetadata([
				'title' => 'edit material group',
				'modal' => '#material-group-form-edit',
				'container' => '#material-group-list',
				'populate' => $material_group_populate_url,
				'submit' => $material_update_url,
				'reload' => $material_group_reload_url,
			]);
			$material_delete_metadata = faf::converter()->arrayToMetadata([
				'title' => 'delete material group',
				'modal' => '#material-group-form-delete',
				'container' => '#material-group-list',
				'populate' => $material_group_populate_url,
				'submit' => $material_group_delete_url,
				'reload' => $material_group_reload_url,
			]);
			$table[] = [
				'№' => $value['row'],
//					'Material group id' => $value['material_group_id'],
				'Group' => $value['name'],
				'Parent' => $value['parent'],
				'Action' => faf::html()->a([
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
		$result = faf::table()->arrayToTable($table);

		return $this->template()->load('material/materialGroupList.twig')->set([
			'content' => $result,
			'material_group_metadata_add' => $material_group_metadata_add,
			'material_group_form_edit' => $this->renderMaterialGroupFormEdit(),
			'material_group_form_delete' => $this->renderMaterialGroupFormDelete(),
		])->render();
	}

	public function renderMaterialGroupListFilter() {
		$material_group_list_filter_metadata = faf::converter()->arrayToMetadata([
			'container' => '#material-group-list',
			'submit' => faf::router()->urlTo('/materials/group/list'),
		]);

		return $this->template()->load('material/materialGroupListFilter.twig')->set([
			'material_group_list_filter_metadata' => $material_group_list_filter_metadata,
		])->render();
	}

	/*
	 * MATERIAL GROUP EDIT
	 */
	public function renderMaterialGroupFormEdit() {
		return $this->template()->load('material/materialGroupFormEdit.twig')->render();
	}

	public function renderMaterialGroupFormUpdate() {
		return $this->template()->load('material/materialGroupFormEdit.twig')->render();
	}

	public function renderMaterialGroupFormDelete() {
		return $this->template()->load('material/materialGroupFormDelete.twig')->render();
	}
}
