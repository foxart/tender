<?php

namespace tender\root\modules\views;

use fa\classes\View;
use fa\core\faf;

class MaintenanceView extends View {

	public static $instance;

	public function renderMaintenance($content) {
		$container = '#ajax';
		$url = faf::router()->urlTo('/maintenance/badfiles');
		$show_files_metadata = "{url:'${url}', container: '${container}'}";
		$url = faf::router()->urlTo('/maintenance/delfiles');
		$del_files_metadata = "{url:'${url}', container: '${container}'}";
		$url = faf::router()->urlTo('/maintenance/emptydirs');
		$show_dirs_metadata = "{url:'${url}', container: '${container}'}";
		$url = faf::router()->urlTo('/maintenance/deldirs');
		$del_dirs_metadata = "{url:'${url}', container: '${container}'}";

		return $this->template()->load('maintenance.twig')->set([
			'show_files_metadata' => $show_files_metadata,
			'del_files_metadata' => $del_files_metadata,
			'show_dirs_metadata' => $show_dirs_metadata,
			'del_dirs_metadata' => $del_dirs_metadata,
			'content' => $content,
		])->render();
	}

	public function renderList($files, $message) {
		if (empty($files) === TRUE) {
			return $this->displayWarningMessage($message);
		} else {
			return implode('<br/>', $files);
		}
	}

	public function renderListWithTip($list, $message) {
		$result = array();
		foreach ($list as $key => $value) {
			if ($value === TRUE) {
				$status = '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>';
			} else {
				$status = '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
			}
			$result[] = $key . ' - ' . $status;
		}
		if (empty($result) === TRUE) {
			return $this->displayWarningMessage($message);
		} else {
			return implode('<br>', $result);
		}
	}
}
