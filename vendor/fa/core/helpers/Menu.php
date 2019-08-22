<?php

namespace fa\core\helpers;

use fa\core\classes\Singleton;
use fa\core\faf;

class Menu extends Singleton {

	public static $instance;
	private $__menu;

	public function renderBootstrapMenu($nodes, $class) {
		$this->__menu = array();
		$this->loopBootstrapMenu($nodes);
		if (empty($nodes) === FALSE) {
			$menu = implode(PHP_EOL, $this->__menu);
		} else {
			$menu = '';
		}
		$result = "<ul class=\"{$class}\">" . $menu . "</ul>";

		return $result;
	}

	private function loopBootstrapMenu($menu) {
//		dump($menu);
//		dump(faf::router()->parameters);
		foreach ($menu as $key => $value) {
			if (isset($value['class']) === TRUE) {
				$class = $value['class'];
			} else {
				$class = '';
			}
			if (isset($value['text']) === TRUE) {
				$text = $value['text'];
			} else {
				$text = '&nbsp;';
			}
			if (isset($value['title']) === TRUE) {
				$title = $value['title'];
			} else {
				$title = '';
			}
			if (isset($value['route']) === TRUE) {
//				$url_menu = faf::router()->urlTo($value['route'], faf::router()->matches);
				$url_menu = $value['route'];
			} else {
				$url_menu = '#';
			}
			if (isset($value['type']) === TRUE) {
				$type = $value['type'];
			} else {
				$type = 'leaf';
			}
			if ($type === 'leaf') {
//				dump(faf::router());
//				dump(faf::router()->request);
//				dump($url_menu);
//				if (faf::router()->route === $url_menu) {
				if (faf::router()->request['path'] === $url_menu) {
					$this->__menu[] = "<li class=\"active\">";
				} else {
					$this->__menu[] = "<li>";
				};
				$this->__menu[] = "<a class=\"{$class}\" href=\"{$url_menu}\" title=\"{$title}\">{$text}</a>";
				$this->__menu[] = "</li>";
			} elseif ($type === 'header') {
				$this->__menu[] = "<li class=\"dropdown-header\">{$text}</li>";
			} elseif ($type === 'divider') {
				$this->__menu[] = "<li class=\"divider\"></li>";
			} elseif ($type === 'dropdown') {
				$this->__menu[] = "<li class=\"dropdown\">";
				$this->__menu[] = "<a href=\"#\" class=\"{$class} dropdown-toggle\" data-toggle=\"dropdown\" title=\"{$title}\">{$text}&nbsp;<span class=\"caret\"></span></a>";
				$this->__menu[] = "<ul class=\"dropdown-menu\">";
				$this->loopBootstrapMenu($value['children']);
				$this->__menu[] = "</ul>";
				$this->__menu[] = "</li>";
			}
		}
	}
}
