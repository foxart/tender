<?php

namespace tender\root;

use tender\common\hooks\controllers\LogHook;
use tender\common\hooks\controllers\WhoopsHook;
use tender\root\routes\RootRoutes;

class Application extends \fa\classes\Application {

	public static $map = [
		'debug' => TRUE,
		'application' => [
			'name' => 'Procurex',
			'version' => '1.02.20',
		],
		'theme' => 'root',
		'language' => 'en',
		'markup' => 'html 4.01 strict',
		/* hook before */
		'application_before' => [
			[
				'controller' => WhoopsHook::class,
				'action' => 'initialize',
				'arguments' => [],
			],
		],
		/* routes */
		'routes' => RootRoutes::class,
		/* hook after */
		'application_after' => [
			[
				'controller' => LogHook::class,
				'action' => 'logRequest',
				'arguments' => [],
			],
		],
		'paths' => [
			'application' => FA_PATH . 'application/tender/root/',
			'storage' => FA_PATH . 'storage/tender/root/',
			/* */
			'fonts' => FA_PATH . 'web/tender/fonts/',
			'files' => FA_PATH . 'web/tender/files/',
			'plugins' => FA_PATH . 'web/tender/plugins/',
			'themes' => FA_PATH . 'web/tender/themes/',
		],
		'urls' => [
			'fonts' => '/fonts/',
			'files' => '/files/',
			'plugins' => '/plugins/',
			'themes' => '/themes/',
		],
	];
}
