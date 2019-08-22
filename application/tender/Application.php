<?php

namespace tender;

use fa\core\faf;

class Application extends \fa\classes\Application {

	public static function get($key = NULL) {
		if (faf::session()->isRequested() === TRUE) {
			faf::session()->start();
		}
		if (faf::session()->isStarted() === TRUE) {
			$session = faf::session()->get('account');
//			$session['type'] = 'test';
			if ($session['type'] === 'root') {
				$result = root\Application::get();
			} elseif ($session['type'] === 'admin') {
				$result = admin\Application::get();
			} elseif ($session['type'] === 'purchaser') {
				$result = purchaser\Application::get();
			} elseif ($session['type'] === 'vendor') {
				$result = vendor\Application::get();
			} else {
//				$result = common\Application::get();
				$result = guest\Application::get();
			}
		} else {
			$result = guest\Application::get();
		}

		return $result;
	}
}
