<?php

namespace tender\purchaser\menus;

use fa\classes\Menu;
use fa\core\faf;

class PurchaserTopMenu extends Menu {

	public static $map = [
		'#overview' => [
			'route' => '/',
			'text' => 'Overview',
		],
		'#rfq' => [
			'route' => '/rfq',
			'text' => 'Request for quotation',
		],
		'#po' => [
			'route' => '/po',
			'text' => 'Purchase orders',
		],
		'#profile' => [
			'route' => '/profile',
			'text' => 'Profile',
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
