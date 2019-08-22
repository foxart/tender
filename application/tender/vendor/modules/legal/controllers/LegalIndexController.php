<?php

namespace tender\vendor\modules\legal\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\vendor\modules\legal\models\LegalIndexModel;
use tender\vendor\modules\legal\views\IndexView;

class LegalIndexController extends Controller {

	private function Model() {
		return LegalIndexModel::instance();
	}

	private function View() {
		return IndexView::instance();
	}

	public function actionLegalList() {
		$account = faf::session()->get('account');
		$data = $this->Model()->legalList($account['id'], faf::router()->matches['company']);

		return $this->View()->renderLegalList($data);
	}

//	public function actionLegalFile() {
//		$file_path = faf::router()->matches['file'];
//		$file_info = faf::helper()->getFileInfo($file_path);
//		faf::header()->setContentType(faf::helper()->getContentTypeByExtension($file_info['extension']));
//
//		return faf::io()->loadFile(faf::$configurations['paths']['storage'] . faf::router()->matches['file']);
//	}
}
