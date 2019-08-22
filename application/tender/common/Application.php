<?php

namespace tender\common;

use tender\common\hooks\controllers\LogHook;
use tender\common\hooks\controllers\TracyHook;
use tender\common\routes\Routes;

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
				'controller' => TracyHook::class,
				'action' => 'initialize',
				'arguments' => [],
			],
		],
		/* routes */
		'routes' => Routes::class,
		/* hook after */
		'application_after' => [
			[
				'controller' => LogHook::class,
				'action' => 'logRequest',
				'arguments' => [],
			],
		],
		'paths' => [
			'application' => FA_PATH . 'application/tender/common/',
			'storage' => FA_PATH . 'storage/tender/common/',
			/**/
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
