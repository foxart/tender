<?php

namespace tender\common\modules\index\views;

use fa\classes\View;
use fa\core\faf;

class IndexView extends View {

	public static $instance;

	public function render403() {
		faf::header()->setStatusCode(403);
		faf::header()->setContentType(faf::helper()->getContentTypeByExtension('html'));

		return $this->template()->load('application/tender/common/modules/index/templates/403Layout.twig')->set([
				'url' => faf::request()->createUrl(faf::request()->getRequest()),
			])->render();
	}

	public function render404() {
		faf::header()->setStatusCode(404);
		faf::header()->setContentType(faf::helper()->getContentTypeByExtension('html'));

		return $this->template()->load('application/tender/common/modules/index/templates/404Layout.twig')->set([
			'url' => faf::request()->createUrl(faf::request()->getRequest()),
		])->render();
	}

	public function render500() {
		faf::header()->setStatusCode(500);
		faf::header()->setContentType(faf::helper()->getContentTypeByExtension('html'));

		return $this->template()->load('application/tender/common/modules/index/templates/500Layout.twig')->set([
			'url' => faf::request()->createUrl(faf::request()->getRequest()),
		])->render();
	}
}
