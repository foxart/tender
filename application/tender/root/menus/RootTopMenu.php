<?php

namespace tender\root\menus;

use fa\classes\Menu;
use fa\core\faf;

class RootTopMenu extends Menu {

	public static $map = [
		'#home' => [
			'route' => '/',
			'text' => 'Home',
		],
		'#import' => [
			'route' => '/import_geo',
			'text' => 'Import Geo',
		],
		'#maintenance' => [
			'route' => '/maintenance',
			'text' => 'File Fixer',
		],
		'#logout' => [
			'route' => '/authentication/sign-out',
			'class' => 'glyphicon glyphicon-log-out',
			'text' => 'Logout',
		],
	];

	public static function get($key = NULL) {
		$menu = array();
		foreach (self::$map as $item) {
			$menu[] = [
				'text' => $item['text'],
				'route' => faf::router()->urlTo($item['route'], faf::router()->matches),
			];
		}

		return $menu;
	}
}
