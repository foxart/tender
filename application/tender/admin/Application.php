<?php

namespace tender\admin;

use tender\admin\routes\Routes;
//use tender\common\hooks\controllers\LogHook;
//use tender\common\hooks\controllers\TracyHook;
use tender\common\hooks\controllers\WhoopsHook;

class Application extends \fa\classes\Application {

	public static $map = [
		'debug' => TRUE,
		'application' => [
			'name' => 'Procurex',
			'version' => '1.02.20',
		],
		'theme' => 'admin',
		'language' => 'en',
		'markup' => 'html 4.01 strict',
		/* hook before */
		'application_before' => [
			[
//				'controller' => TracyHook::class,
//				'action' => 'initialize',
				'controller' => WhoopsHook::class,
				'action' => 'initialize',
				'arguments' => [],
			],
		],
		/* routes */
		'routes' => Routes::class,
		/* hook after */
		'application_after' => [
			[
//				'controller' => LogHook::class,
//				'action' => 'logRequest',
				'controller' => WhoopsHook::class,
				'action' => 'initialize',
				'arguments' => [],
			],
		],
		'paths' => [
			'application' => FA_PATH . 'application/tender/admin/',
			'storage' => FA_PATH . 'storage/tender/admin/',
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
