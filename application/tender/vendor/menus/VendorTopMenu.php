<?php

namespace tender\vendor\menus;

use fa\classes\Menu;
use fa\core\faf;

class VendorTopMenu extends Menu {

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
			'route' => '/company',
			'text' => 'Profile',
		],
		'#logout' => [
			'route' => '/authentication/sign-out',
			'class' => 'glyphicon glyphicon-log-out',
			'text' => 'Logout',
		],
//		'#materials_group' => [
//			'text' => 'Materials',
//			'type' => 'dropdown',
//			'children' => [
//				'#materials_group#material' => [
//					'text' => 'Materials',
//					'route' => '/rfq',
//				],
//				'#materials_group#group' => [
//					'text' => 'Groups',
//					'route' => '/',
//				],
//			],
//		],
	];
//		faf::io()->saveFile(faf::$configuration['paths']['storage'].'menu.json', json_encode(self::$map, JSON_PRETTY_PRINT));
//		self::$map = json_decode(faf::io()->loadFile(faf::$configuration['paths']['storage'] . 'menu.json'), TRUE);
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
