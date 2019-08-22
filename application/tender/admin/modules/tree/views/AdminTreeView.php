<?php

namespace tender\admin\modules\tree\views;

use fa\classes\View;
use fa\core\faf;

class AdminTreeView extends View {

	public static $instance;

	public function renderMaterialTree() {
		return $this->template()->load('tree/index.twig')->set([
			'material_get_url' => faf::router()->urlTo('/jstree_materials/material/jstree_list'),
			'save_tree_url' => faf::router()->urlTo('/jstree_materials/material/save_all'),
			'save_node_url' => faf::router()->urlTo('/jstree_materials/material/save_node'),
			'material_form_modal' => $this->renderMaterialForm(),
			'material_group_form_modal' => $this->renderMaterialGroupForm(),
		])->render();
	}

	public function renderMaterialForm() {
		return $this->template()->load('tree/materialForm.twig')->render();
	}

	public function renderMaterialGroupForm() {
		return $this->template()->load('tree/materialGroupForm.twig')->render();
	}

	public function renderJsTree($material_list) {
		foreach ($material_list as $key => $value) {
			if (empty($value['parent']) === TRUE) {
				$material_list[$key]['parent'] = '#';
			}
			/**
			 * material url
			 */
			$material_add_url = faf::router()->urlTo('/jstree_materials/material/add', [
				'material-id' => $value['id'],
			]);
			$material_update_url = faf::router()->urlTo('/jstree_materials/material/update', [
				'material-id' => $value['id'],
			]);
			$material_delete_url = faf::router()->urlTo('/jstree_materials/material/delete', [
				'material-id' => $value['id'],
			]);
			$material_reload_url = faf::request()->createUrl([
				'path' => faf::router()->urlTo('/jstree_materials/material/list'),
				'get' => [
					'material_name' => faf::request()->get('material_name'),
				],
			]);
			$material_get_url = faf::router()->urlTo('/jstree_materials/material/get', [
				'material-id' => $value['id'],
			]);
			/**
			 * material group url
			 */
			$material_group_get_url = faf::router()->urlTo('/jstree_materials/group/get', [
				'material-id' => $value['id'],
			]);
			$material_group_add_url = faf::router()->urlTo('/jstree_materials/group/add', [
				'material-id' => $value['id'],
			]);
			$material_group_update_url = faf::router()->urlTo('/jstree_materials/group/update', [
				'material-id' => $value['id'],
			]);
			$material_group_delete_url = faf::router()->urlTo('/jstree_materials/group/delete', [
				'material-id' => $value['id'],
			]);

			if ($value['type'] === 'leaf') {
				$metadata = faf::converter()->arrayToMetadata([
					'add' => [
						'title' => 'Add group',
						'modal' => '#material-group-form',
						'container' => '#jstree-materials',
						'submit' => $material_group_add_url,
						'reload' => $material_reload_url,
					],
					'update' => [
						'title' => 'Edit group',
						'modal' => '#material-group-form',
						'container' => '#jstree-materials',
						'populate' => $material_group_get_url,
						'submit' => $material_group_update_url,
						'reload' => $material_reload_url,
					],
					'delete' => [
						'title' => 'Delete group',
						'disable' => [],
						'modal' => '#material-group-form',
						'container' => '#jstree-materials',
						'populate' => $material_group_get_url,
						'submit' => $material_group_delete_url,
						'reload' => $material_reload_url,
					],
				]);
			} else {
				$metadata = faf::converter()->arrayToMetadata([
					'add' => [
						'title' => 'Add material',
						'modal' => '#material-form',
						'container' => '#jstree-materials',
						'submit' => $material_add_url,
						'reload' => $material_reload_url,
					],
					'update' => [
						'title' => 'Edit material',
						'modal' => '#material-form',
						'container' => '#jstree-materials',
						'populate' => $material_get_url,
						'submit' => $material_update_url,
						'reload' => $material_reload_url,
					],
					'delete' => [
						'title' => 'Delete material',
						'disable' => [],
						'modal' => '#material-form',
						'container' => '#jstree-materials',
						'populate' => $material_get_url,
						'submit' => $material_delete_url,
						'reload' => $material_reload_url,
					],
				]);
			}
			$material_list[$key]['li_attr'] = [
				'class' => $metadata,
			];
		}
		$json = json_encode($material_list, JSON_PRETTY_PRINT);

		return $json;
	}
}
