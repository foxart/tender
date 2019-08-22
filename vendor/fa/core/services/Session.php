<?php

namespace fa\core\services;

use fa\core\classes\Singleton;

class Session extends Singleton {

	public static $instance;

	public function isRequested() {
		if (filter_input(INPUT_COOKIE, session_name()) === NULL) {
			$result = FALSE;
		} else {
			$result = TRUE;
		}

		return $result;
	}

	public function isStarted() {
		if (isset($_SESSION) === TRUE) {
			$result = TRUE;
		} else {
			$result = FALSE;
		}

		return $result;
	}

	public function start() {
		if ($this->isStarted() === FALSE) {
			session_start();
		}
	}

	public function get($key = NULL) {
		if ($this->isStarted() === TRUE) {
			if ($key === NULL) {
				if (isset($_SESSION) === TRUE) {
					$result = $_SESSION;
				} else {
					$result = NULL;
				}
			} else {
				if (isset($_SESSION[$key]) === TRUE) {
					$result = $_SESSION[$key];
				} else {
					$result = NULL;
				}
			}
		} else {
			throw new \Exception('session is not started');
		}

		return $result;
	}

	public function set($key, $value) {
		if ($this->isStarted() === TRUE) {
			$_SESSION[$key] = $value;
		} else {
			throw new \Exception('session is not started');
		}
	}

	public function end() {
//		if ($this->check() === TRUE) {
//		}
//		dump(@$_SESSION);
//		exit;
		$params = session_get_cookie_params();
		setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
		session_unset();
		session_destroy();
		session_write_close();
	}
}
