<?php

namespace tender\common\modules\index\controllers;

use fa\classes\Controller;
use tender\common\modules\index\views\IndexView;

class IndexController extends Controller {

	private function View() {
		return IndexView::instance();
	}

	public function output403() {
		return $this->View()->render403();
	}

	public function output404() {
		return $this->View()->render404();
	}

	public function output500() {
		return $this->View()->render500();
	}
}
