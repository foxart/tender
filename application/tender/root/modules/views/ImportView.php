<?php

namespace tender\root\modules\views;

use fa\classes\View;
use fa\core\faf;

class ImportView extends View {

	public static $instance;

	public function renderImport($list) {
		$upload_file_metadata = faf::converter()->arrayToMetadata([
			'title' => 'Upload new GeoData file',
			'modal' => '#file-upload-form',
			'container' => '#container',
//			'populate' => faf::router()->urlTo('/import_geo/stub'),
			'submit' => faf::router()->urlTo('/import_geo/upload'),
			'reload' => faf::router()->urlTo('/import_geo/stub'),
		]);

		return $this->template()->load('import.twig')->set([
			'upload_file_metadata' => $upload_file_metadata,
			'upload_file_form' => $this->uploadForm(),
			'content' => implode('<br>', $list),
		])->render();
	}

	public function uploadForm() {
		return $this->template()->load('uploadForm.twig')->render();
	}

	public function renderDirList($list) {
		return implode('<br>', $list);
	}
}
