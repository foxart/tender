<?php

namespace tender\purchaser\modules\overview\views;

use fa\classes\View;

class OverviewView extends View {

	public static $instance;
//	public function renderIndex() {
//		return $this->template()->load('overview/index.twig')->set([
//			'content' => 'content',
//		])->render();
//	}
	public function renderOverview() {
		return $this->template()->load('overview/index.twig')->set([//			'content' => 'content',
		])->render();
	}
}
