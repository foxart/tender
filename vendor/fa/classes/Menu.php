<?php

namespace fa\classes;

use fa\core\classes\Map;
use fa\core\faf;

abstract class Menu extends Map {

	public final function outputBootstrapMenu($arguments) {
		/**
		 * @type \fa\classes\Menu $map
		 */
//		$map = $arguments['map'];

		return faf::menu()->renderBootstrapMenu(static::get(), $arguments['class']);
	}
}
