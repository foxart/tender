<?php

namespace tender\common\routes;

use fa\classes\Layout;
use fa\classes\Route;

class DefaultRoutes extends Route {

	public static $map = [
		/* fonts */
		'/fonts' => [
			'route' => '/fonts/:file',
			'constraints' => [
				'file' => '.+[.].{2,5}',
			],
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputFont',
			],
		],
		/* files */
		'/files' => [
			'route' => '/files/:file',
			'constraints' => [
				'file' => '.+[.].{2,3}',
			],
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputFile',
			],
		],
		/* plugins */
		'/plugins' => [
			'route' => '/plugins/:file',
			'constraints' => [
				'file' => '.+[.].{2,3}',
			],
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputPlugin',
			],
		],
		/* themes */
		'/themes' => [
			'route' => '/themes/:file',
			'constraints' => [
				'file' => '.+[.].{2,3}',
			],
			'trigger' => [
				'controller' => Layout::class,
				'action' => 'outputTheme',
			],
		],
	];
}
