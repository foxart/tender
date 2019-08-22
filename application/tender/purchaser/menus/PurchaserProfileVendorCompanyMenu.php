<?php

namespace tender\purchaser\menus;

use fa\classes\Menu;
use fa\core\faf;

class PurchaserProfileVendorCompanyMenu extends Menu {

	public static $map = [
		'#company' => [
			'route' => '/profile/purchaser_company_id/vendor_company_id',
			'text' => 'Company',
		],
		'#bank' => [
			'route' => '/profile/purchaser_company_id/vendor_company_id/bank',
			'text' => 'Bank details',
		],
		'#materials' => [
			'route' => '/profile/purchaser_company_id/vendor_company_id/materials',
			'text' => 'Products profile',
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
