<?php

namespace tender\common\modules\test\views;

use fa\classes\View;

class TestView extends View {

	public static $instance;

	public function renderTest() {
		return $this->template()->load('test/index.twig')->set([])->render();
	}
}
