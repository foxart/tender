<?php

namespace tender\admin\menus;

use fa\classes\Menu;
use fa\core\faf;

class AccountAdminMenu extends Menu {

	public static $map = [
		'#account' => [
			'text' => 'Account',
			'route' => '/users/admin/account-id',
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
