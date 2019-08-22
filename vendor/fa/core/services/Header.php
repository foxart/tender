<?php

namespace fa\core\services;

use fa\core\classes\Singleton;

class Header extends Singleton {

	public static $instance;

	public function get() {
		return headers_list();
	}

	public function clear() {
		if (headers_sent() === FALSE) {
			header_remove();
		} else {
			throw new \Exception('headers already sent');
		}
	}

	public function set($header, $replace = TRUE, $http_response_code = NULL) {
		if (headers_sent() === FALSE) {
			header($header, $replace, $http_response_code);
		} else {
			throw new \Exception('headers already sent');
		}
	}

	public function setStatusCode($code) {
		switch ($code) {
			case 200:
				$header = '200 Ok';
				break;
			case 403:
				$header = '403 Forbidden';
				break;
			case 404:
				$header = '404 Not Found';
				break;
			case 500:
				$header = '500 Internal Server Error';
				break;
			default:
				throw new \Exception('undefinded status code: ' . $code);
				break;
		}
		$this->set('HTTP/1.1 ' . $header);
	}

	public function setAcceptRanges($accept_ranges) {
		$this->set('Accept-Ranges: ' . $accept_ranges);
	}

	public function setLastModified($last_modified) {
		$this->set('Last-Modified: ' . $last_modified);
	}

	public function setContentType($content_type, $replace = TRUE, $http_response_code = NULL) {
		$this->set('Content-Type: ' . $content_type, $replace, $http_response_code);
	}

	public function setContentLength($content_length) {
		$this->set('Content-Length: ' . $content_length);
	}

	public function setLocation($location) {
		$this->set('Location: ' . $location);
//		exit;
	}

	public function setRefresh($location, $timeout) {
		$this->set('Refresh: ' . $timeout . '; url=' . $location);
	}
}
