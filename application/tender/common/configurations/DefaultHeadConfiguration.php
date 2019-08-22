<?php

namespace tender\common\configurations;

use fa\classes\Configuration;

class DefaultHeadConfiguration extends Configuration {

	public static $map = [
		'css' => [
			'fonts' => [
				'flaticon.css',
				],
			'plugins' => [
				'jquery/jquery-ui.css',
				'jquery/jquery.datetimepicker.min.css',
				'bootstrap/bootstrap.min.css',
				'bootstrap/bootstrap-theme.min.css',
				'select2/select2.css',
				'jstree/default/style.min.css',
				'fa/fa.table.css',
				'fa/fa.paginator.css',
				'fa/fa.css',
				'fa-bootstrap/bootstrap-theme.css',
				'fa-bootstrap/bootstrap-modal.css',
				'fa-bootstrap/bootstrap-navbar.css',
			],
			'themes' => [],
		],
		'js' => [
			'plugins' => [
				'jquery/jquery-3.1.1.min.js',
				'jquery/jquery-ui.js',
				'jquery/jquery.datetimepicker.min.js',
				'bootstrap/bootstrap.js',
				'select2/select2.js',
				'jstree/jstree.min.js',
				'fa-bootstrap/bootstrap-feedback.js',
				'fa-bootstrap/bootstrap-form.js',
				'fa-bootstrap/bootstrap-modal.js',
				'fa/fa.js',
				'fa/fa.validator.js',
				'fa/fa.ajax.js',
				'fa/fa.form.js',
				'fa/fa.console.js',
				'fa/fa.parse.js',
				'fa/fa.cookie.js',
				'fa/fa.debug.js',
				'fa/fa.links.js',
			],
			'themes' => [],
		],
	];
}
