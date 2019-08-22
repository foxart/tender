<?php

namespace tender\root\modules\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\root\modules\models\GeoModel;
use tender\root\modules\views\ImportView;

class ImportController extends Controller {

	public function View() {
		return ImportView::instance();
	}

	public function Model() {
		return GeoModel::instance();
	}

	public function actionHome() {
		return $this->View()->renderIndex('');
	}

	public function actionImport() {
		$directory = faf::$configuration['paths']['files'] . 'import/';
		if (file_exists($directory) === TRUE) {
			$file_list = array_diff(scandir($directory), array(
				'..',
				'.',
			));
		} else {
			$file_list = array();
		}

		return $this->View()->renderImport($file_list);
	}

	public function actionImportContinent() {
		$this->Model()->setImport('continent');

		return $this->ImportItem();
	}

	public function actionImportCountry() {
		$this->Model()->setImport('country');

		return $this->ImportItem();
	}

	public function actionImportRegion() {
		$this->Model()->setImport('region');

		return $this->ImportItem();
	}

	public function actionImportDevision() {
	}

	public function actionImportTimeZone() {
	}

	public function actionImportCity() {
	}

	public function ImportItem() {
		$id = faf::router()->matches['id'];
		$item = $this->Model()->getGeoItem($id);
		if (empty($item) === FALSE) {
			$total = $this->Model()->getTotalItems();
			$this->Model()->addItem($item);
			$next = faf::router()->urlTo($this->Model()->import['routeAlias'], [
				'id' => $id + 1,
			]);
		} else {
			return 'false';
		}
		$tip = $this->Model()->import['tip'];

		return json_encode([
			"progress" => [
				"row" => $id,
				"rows" => $total,
				"percents" => round($id / $total * 100, 2),
				"next" => $next,
			],
			"data" => [
				"{$tip}" => $item['name'],
			],
		]);
	}

	public function ImportCSV($file) {
		$this->Model()->CreateGeoTable($file);
		$this->Model()->importCsv($file);
	}

	public function actionImportUploadFile() {
		$file_attachement = faf::request()->file('import_file_attachement');
		$data = faf::request()->post();
		$this->Model()->load($data)->addValidator('import_file', function () use ($file_attachement) {
			if ($file_attachement['type'] !== 'application/vnd.ms-excel') {
				return 'Please upload valid file with .csv extention';
			}

			return TRUE;
		})->validate();
		if ($this->Model()->valid === TRUE) {
			if (faf::io()->isUploaded($file_attachement) === TRUE) {
				$file_directory = 'import/';
				$t = new \DateTime();
				$data = $t->format("Y-m-d H-i-s");
				$file_name = 'GeoLite2-City-Locations-en ' . $data;
				$ext = faf::helper()->getExtensionByContentType($file_attachement['type']);
				$full_file_name = faf::$configuration['paths']['files'] . $file_directory . $file_name . $ext;
				if (faf::io()->checkFile($full_file_name) === TRUE) {
					faf::io()->deleteFile($full_file_name);
				}
				$status = faf::io()->saveUploaded(faf::$configuration['paths']['files'] . $file_directory, $file_name, $file_attachement);
			}

			return $status;
		} else {
			return $this->Model()->errorsToJson();
		}
	}

	public function actionImportEmpty() {
		$directory = faf::$configuration['paths']['files'] . 'import/';
		if (file_exists($directory) === TRUE) {
			$file_list = array_diff(scandir($directory), array(
				'..',
				'.',
			));
		} else {
			$file_list = array();
		}

		return $this->View()->renderDirList($file_list);
	}
}
