<?php

namespace tender\admin\menus;

use fa\classes\Menu;
use fa\core\faf;

class SettingsMenu extends Menu {

	public static $map = [
		'#account_type' => [
			'text' => 'Roles',
			'route' => '/settings/authorization',
		],
		'#company' => [
			'text' => 'Legal entity',
			'route' => '/settings/company',
		],
//		'#conditions' => [
//			'text' => 'Conditions',
//			'route' => '/settings/condition',
//		],
//		'#other_settings' => [
//			'text' => 'Other settings',
//			'route' => '/settings/other',
//		],
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
