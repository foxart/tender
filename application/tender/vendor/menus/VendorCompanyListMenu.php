<?php

namespace tender\vendor\menus;

use fa\classes\Menu;
use fa\core\faf;
use tender\vendor\modules\company\models\CompanyIndexModel;

class VendorCompanyListMenu extends Menu {

	private static function Model() {
		return CompanyIndexModel::instance();
	}

	public static $map = [];

	public static function get($key = NULL) {
//		$menu = array();
//		foreach (self::$map as $item) {
//			$menu[] = [
//				'text' => $item['text'],
//				'route' => faf::router()->urlTo($item['route'], faf::router()->matches),
//			];
//		}
//
//		return $menu;
		$account = faf::session()->get('account');
		$company_list = self::Model()->companyListMenu($account['id']);
		$menu = array();
		foreach ($company_list as $item) {
			$menu[] = [
				'route' => faf::router()->urlTo(faf::router()->route, [
					'company' => $item['id'],
				]),
				'text' => $item['name'],
			];
		}

		return $menu;
	}
}
