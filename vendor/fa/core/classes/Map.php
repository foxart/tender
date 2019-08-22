<?php

namespace fa\core\classes;

abstract class Map implements MapInterface {

	protected static $map;

	public static function check($key) {
		if (isset(static::$map[$key]) === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public static function get($key = NULL) {
		if ($key !== NULL) {
			return static::$map[$key];
		} else {
			return static::$map;
		}
	}
}
