<?php

namespace tender\purchaser\modules\po\views;

use fa\classes\View;

class PoView extends View {

	public static $instance;

	public function renderPo() {
		return $this->template()->load('po/index.twig')->set([
			'content' => 'List',
		])->render();
	}

	public function renderDelivery() {
		return $this->template()->load('po/DeliverySchedule.twig')->set([
			'content' => 'DeliverySchedule',
		])->render();
	}

	public function renderDispatch() {
		return $this->template()->load('po/Dispatch.twig')->set([
			'content' => 'Dispatch',
		])->render();
	}
}
