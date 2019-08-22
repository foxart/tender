<?php

namespace tender\root\modules\controllers;

use fa\classes\Controller;
use tender\root\modules\models\MaintenanceModel;
use tender\root\modules\views\MaintenanceView;

class MaintenanceController extends Controller {

	public function View() {
		return MaintenanceView::instance();
	}

	public function Model() {
		return MaintenanceModel::instance();
	}

	public function actionHome() {
//		return $this->View()->renderMaintenance('');
	}

	public function actionMaintenance() {
		return $this->View()->renderMaintenance('');
	}

	public function actionBadFiles() {
		$path = $this->Model()->getFilePath();
		$removeFilesList = $this->Model()->getFileListForRemove($path);

		return $this->View()->renderList($removeFilesList, 'no bad files');
	}

	public function actionRemoveFiles() {
		$path = $this->Model()->getFilePath();
		$removeFilesList = $this->Model()->getFileListForRemove($path);
		$result = array();
		if (empty($removeFilesList) === FALSE) {
			foreach ($removeFilesList as $file) {
				if (is_writable($file) === FALSE) {
					$status = FALSE;
				} else {
					$status = unlink($file);
				}
				$result[$file] = $status;
			}
		}

		return $this->View()->renderListWithTip($result, 'no bad files');
	}

	public function actionGetEmptyDirs() {
		$path = $this->Model()->getFilePath();
		$emptyDirs = $this->Model()->getEmptyDirs($path);

		return $this->View()->renderList($emptyDirs, 'no empty folders');
	}

	public function actionRemoveEmptyDirs() {
		$path = $this->Model()->getFilePath();
		$result = array();
		$dirictories = $this->Model()->getEmptyDirs($path);
		foreach ($dirictories as $directory) {
			$status = FALSE;
			if (is_writable($directory) === TRUE) {
				$status = @rmdir($directory);
			}
			$result[$directory] = $status;
		}

		return $this->View()->renderListWithTip($result, 'no empty folders');
	}
}
