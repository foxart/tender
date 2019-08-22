<?php

namespace tender\common\modules\test\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\common\modules\test\models\TestModel;
use tender\common\modules\test\views\TestView;

class TestController extends Controller {

	/**
	 * @return TestModel
	 */
	private function Model() {
		return TestModel::instance();
	}

	/**
	 * @return TestView
	 */
	private function View() {
		return TestView::instance();
	}

	/*
	 * MATERIAL
	 */
	public function actionTest() {
		$get = faf::request()->get();
//		$this->Model()->load($get)->validate();
//		if ($this->Model()->valid === FALSE) {
//			$result = $this->Model()->errorsToJson();
//		} else {
//			$model = $this->Model()->materialList(faf::request()->get('material'));
//			if (empty($model) === TRUE) {
//				$result = $this->View()->displayInformationMessage('no records found');
//			} else {
//				$result = $this->View()->renderMaterialList($model);
//			}
//		}
		$result = $this->View()->renderTest();

//		return $result;
		return $result . faf::debug()->dump($get, FALSE);
	}
}
