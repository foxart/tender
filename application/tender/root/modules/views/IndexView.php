<?php

namespace tender\root\modules\views;

use fa\classes\View;

class IndexView extends View {

	public static $instance;
//	public function renderIndex($content) {
//		return $this->template()->load('root/index.twig')->set([
//			'content' => $content,
//		])->render();
//	}
	public function renderHome($content) {
		return $this->template()->load('index.twig')->set([
			'content' => $content,
		])->render();
	}
}
