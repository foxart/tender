<?php

namespace tender\vendor\modules\material\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\material\models\MaterialEditModel;

class MaterialEditController extends Controller {

	public function actionMaterialSelect() {
		$account = faf::session()->get('account');
		$select['items'] = $this->Model()->materialSelect($account['id'], faf::router()->matches['company'], faf::request()->get('query_string'));

		return json_encode($select);
	}

	private function Model() {
		return MaterialEditModel::instance();
	}

	public function actionMaterialGet() {
		$account = faf::session()->get('account');

		return json_encode($this->Model()->materialGet($account['id'], faf::router()->matches['company'], faf::router()->matches['material']));
	}

	public function actionMaterialAdd() {
		$account = faf::session()->get('account');
//		$data = faf::request()->post();
//		dump($data);
		$material_id_array = faf::request()->post('material_id');
		$this->Model()->addValidator('material_id[]', function () {
			if (faf::request()->post('material_id') === NULL) {
				//todo-ivan fix javascript array field name issue
				return 'please enter material';
			} else {
				return TRUE;
			}
		})->validate();
		if ($this->Model()->valid === TRUE) {
			return $this->Model()->materialAdd($account['id'], faf::router()->matches['company'], $material_id_array);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionMaterialUpdate() {
		$account = faf::session()->get('account');
		$company_id = faf::router()->matches['company'];
		$material_id = faf::router()->matches['material'];
		$material_file_attachement = faf::request()->file('material_file_attachement');
		$data = faf::request()->post();
		$this->Model()->load($data)->addValidator('material_file_fake', function () use ($material_file_attachement) {
//			return $material_file_attachement['type'];
			return TRUE;
		})->validate();
		if ($this->Model()->valid === TRUE) {
			if (faf::io()->isUploaded($material_file_attachement) === TRUE) {
				$material = $this->Model()->materialGet($account['id'], $company_id, $material_id);
				if (faf::io()->checkFile(faf::$configuration['paths']['files'] . $material['material_file']) === TRUE) {
					faf::io()->deleteFile(faf::$configuration['paths']['files'] . $material['material_file']);
				}
				$file_directory = 'vendor/' . $account['id'] . '/material/';
				$file_name = 'company_' . faf::router()->matches['company'] . '_material_' . $material_id;
//				$file_name = faf::generator()->unique();
				$material_file = $file_directory . $file_name . '.' . faf::helper()->getExtensionByContentType($material_file_attachement['type']);
				/*
				 *
				 */
//				faf::image()->load($material_file_attachement['tmp_name']);
//				faf::image()->resizeToFit(100, 100);
//				faf::image()
//					->save(faf::$configurations['paths']['files'] . $file_directory . $file_name . '_100x100' . '.' . faf::helper()
//							->getExtensionByContentType($material_file_attachement['type']));
				/*
				 *
				 */
				faf::io()->saveUploaded(faf::$configuration['paths']['files'] . $file_directory, $file_name, $material_file_attachement);
			} else {
				$material_file = NULL;
			}

			return $this->Model()->materialUpdate($account['id'], $company_id, $material_id, $material_file);
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionMaterialDelete() {
		$account = faf::session()->get('account');
		$material = $this->Model()->materialGet($account['id'], faf::router()->matches['company'], faf::router()->matches['material']);
		if (faf::io()->checkFile(faf::$configuration['paths']['files'] . $material['material_file']) === TRUE) {
			faf::io()->deleteFile(faf::$configuration['paths']['files'] . $material['material_file']);
		}

		return $this->Model()->materialDelete($account['id'], faf::router()->matches['company'], faf::router()->matches['material']);
	}
}
