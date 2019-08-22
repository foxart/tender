<?php

namespace fa\core\services;

use fa\core\classes\Singleton;

final class Backtrace extends Singleton {

	public static $instance;

	public function get($index = NULL) {
		if ($index !== NULL) {
			$result = debug_backtrace()[$index];
		} else {
			$result = debug_backtrace();
		}

		return $result;
	}

	public function getCallee($index = 0) {
		return $this->get($index);
	}

	public function getCalleeClass($index = 0) {
		return $this->get($index)['class'];
	}
}
