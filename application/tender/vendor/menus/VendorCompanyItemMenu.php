<?php

namespace tender\vendor\menus;

use fa\classes\Menu;
use fa\core\faf;

class VendorCompanyItemMenu extends Menu {

	public static $map = [
		'#general' => [
			'text' => 'General',
			'route' => '/company/company-id',
		],
		'#legal' => [
			'text' => 'Legal entities',
			'route' => '/company/company-id/legal',
		],
		'#detail' => [
			'text' => 'Company details',
			'route' => '/company/company-id/detail',
		],
//		'#factory' => [
//			'text' => 'Factory details',
//			'route' => '/company/company-id/factory',
//		],
		'#contact' => [
			'text' => 'Contact details',
			'route' => '/company/company-id/contact',
		],
		'#excise' => [
			'text' => 'Excise tax',
			'route' => '/company/company-id/excise',
		],
		'#product' => [
			'text' => 'Product profile',
			'route' => '/company/company-id/material',
		],
		'#bank' => [
			'text' => 'Bank details',
			'route' => '/company/company-id/bank',
		],
//		'#attachement' => [
//			'text' => 'Attachments',
//			'route' => '/attachement',
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
