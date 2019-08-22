<?php

namespace tender\admin\menus;

use fa\classes\Menu;
use fa\core\faf;

class AdminTopMenu extends Menu {

	public static $map = [
		'#overview' => [
			'route' => '/',
			'text' => 'Overview',
		],
		'#users' => [
			'route' => '/users',
			'text' => 'Users',
		],
		'#materials' => [
			'route' => '/materials',
			'text' => 'Materials',
		],
		'#settings' => [
			'route' => '/settings/authorization',
			'text' => 'Settings',
		],
		'#tree' => [
			'route' => '/jstree_materials',
			'text' => 'JsTree',
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
