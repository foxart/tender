<?php

namespace tender\vendor;

use tender\common\hooks\controllers\LogHook;
use tender\common\hooks\controllers\TracyHook;
use tender\vendor\routes\Routes;

class Application extends \fa\classes\Application {

	public static $map = [
		'debug' => TRUE,
		'application' => [
			'name' => 'Procurex',
			'version' => '1.02.20',
		],
		'theme' => 'vendor',
		'language' => 'en',
		'markup' => 'html 4.01 strict',
		/* hook before */
		'application_before' => [
			[
				'controller' => TracyHook::class,
				'action' => 'initialize',
				'arguments' => [
					'bar' => TRUE,
				],
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
			[
				'controller' => TracyHook::class,
				'action' => 'dumpSession',
				'arguments' => [],
			],
			[
				'controller' => TracyHook::class,
				'action' => 'dumpMysqlDefaultConnections',
				'arguments' => [],
			],
			[
				'controller' => TracyHook::class,
				'action' => 'dumpFaf',
				'arguments' => [],
			],
			[
				'controller' => TracyHook::class,
				'action' => 'dumpFafInstances',
				'arguments' => [],
			],
		],
		'paths' => [
			'application' => FA_PATH . 'application/tender/vendor/',
			'storage' => FA_PATH . 'storage/tender/vendor/',
			/* files */
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
