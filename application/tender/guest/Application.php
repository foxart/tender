<?php

namespace tender\guest;

use tender\common\hooks\controllers\LogHook;

class Application extends \fa\classes\Application {

	public static $map = [
		'debug' => TRUE,
		'application' => [
			'name' => 'Procurex',
			'version' => '1.02.20',
		],
		'theme' => 'common',
		'language' => 'en',
		'markup' => 'html 4.01 strict',
		/* hook before */
		'application_before' => [
			[
				'controller' => LogHook::class,
				'action' => 'logRequest',
				'arguments' => [],
			],
		],
		/* routes */
		'routes' => Routes::class,
		/* hook after */
		'application_after' => [

		],
		'paths' => [
			'application' => FA_PATH . 'application/tender/guest/',
			'storage' => FA_PATH . 'storage/tender/guest/',
			/* */
			'files' => FA_PATH . 'web/tender/files/',
			'fonts' => FA_PATH . 'web/tender/fonts/',
			'plugins' => FA_PATH . 'web/tender/plugins/',
			'themes' => FA_PATH . 'web/tender/themes/',
		],
		'urls' => [
			'files' => '/files/',
			'fonts' => '/fonts/',
			'plugins' => '/plugins/',
			'themes' => '/themes/',
		],
	];
}
