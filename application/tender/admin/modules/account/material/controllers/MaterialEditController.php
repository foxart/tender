<?php

namespace tender\admin\modules\account\material\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\admin\modules\account\material\models\MaterialEditModel;

class MaterialEditController extends Controller {

	/**
	 * @return MaterialEditModel
	 */
	public function EditModel() {
		return MaterialEditModel::instance();
	}

	public function actionMaterialGet() {
		return json_encode($this->EditModel()
			->materialGet(faf::router()->matches['account-id'], faf::router()->matches['company-id'], faf::router()->matches['material-id']));
	}

	public function actionMaterialSelect() {
		$account_id = faf::router()->matches['account-id'];
		$company_id = faf::router()->matches['company-id'];
		$select['items'] = $this->EditModel()->materialSelect($account_id, $company_id, faf::request()->get('query_string'));

		return json_encode($select);
	}

	public function actionMaterialAdd() {
		$material_id_array = faf::request()->post('material_id');
		$this->EditModel()->addValidator('material_id[]', function () {
			if (faf::request()->post('material_id') === NULL) {
				return 'please enter material';
			} else {
				return TRUE;
			}
		})->validate();
		if ($this->EditModel()->valid === TRUE) {
			return $this->EditModel()->materialAdd(faf::router()->matches['account-id'], faf::router()->matches['company-id'], $material_id_array);
		} else {
			return $this->EditModel()->errorsToJson();
		}
	}

	public function actionMaterialUpdate() {
		$account_id = faf::router()->matches['account-id'];
		$company_id = faf::router()->matches['company-id'];
		$material_id = faf::router()->matches['material-id'];
		$material_file_attachement = faf::request()->file('material_file_attachement');
		$post = faf::request()->post();
		$this->EditModel()->load($post)->addValidator('material_file_fake', function () use ($material_file_attachement) {
			return TRUE;
		})->validate();
		if ($this->EditModel()->valid === TRUE) {
			if (faf::io()->isUploaded($material_file_attachement) === TRUE) {
				$material = $this->EditModel()->materialGet($account_id, $company_id, $material_id);
				if (faf::io()->checkFile($material['material_file']) === TRUE) {
					faf::io()->deleteFile($material['material_file']);
				}
				$file_directory = 'purchaser/' . $account_id . '/';
				$file_name = 'company_' . faf::router()->matches['company-id'] . '_material_' . $material_id;
				$material_file = $file_directory . $file_name . '.' . faf::helper()->getExtensionByContentType($material_file_attachement['type']);
				faf::io()->saveUploaded(faf::$configuration['paths']['files'] . $file_directory, $file_name, $material_file_attachement);
			} else {
				$material_file = NULL;
			}

			return $this->EditModel()->materialUpdate($account_id, $company_id, $material_id, $material_file);
		} else {
			return $this->EditModel()->errorsToJson();
		}
	}

	public function actionMaterialDelete() {
		$material = $this->EditModel()
			->materialGet(faf::router()->matches['account-id'], faf::router()->matches['company-id'], faf::router()->matches['material-id']);
		if (faf::io()->checkFile(faf::$configuration['paths']['files'] . $material['material_file']) === TRUE) {
			faf::io()->deleteFile(faf::$configuration['paths']['files'] . $material['material_file']);
		}

		return $this->EditModel()
			->materialDelete(faf::router()->matches['account-id'], faf::router()->matches['company-id'], faf::router()->matches['material-id']);
	}
}
