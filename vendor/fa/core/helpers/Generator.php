<?php

namespace fa\core\helpers;

use fa\core\classes\Singleton;

/**
 * example of basic @param usage
 *
 * @param bool $baz
 *
 * @return mixed
 */
class Generator extends Singleton {

	public static $instance;

	public function string($length = 10) {
//		trigger_error();
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		return $randomString;
	}

	public function unique($prefix = '', $entropy = FALSE) {
		return uniqid($prefix, $entropy);
	}

	public function password() {
		return $this->string(8);
	}

	public function salt() {
		return md5(microtime(TRUE));
	}
}
