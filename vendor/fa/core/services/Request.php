<?php
/*
  Scheme: https
  Protocol: https
  Authority: en.wikipedia.org
  Host: en.wikipedia.org
  Hostname: en.wikipedia.org
  Subdomain: en
  Domain: wikipedia.org
  Tld: org
  Resource: /wiki/Query_string
  Directory: /wiki
  Path: /wiki/Query_string
  File name: Query_string
 */

namespace fa\core\services;

use fa\core\classes\Singleton;

final class Request extends Singleton {

	public static $instance;
	private $__request;
	public $accept;
	public $status;
	public $isAjax;

	public function onConstruct() {
		parent::onConstruct();
		self::instance()->parseRequest();
	}

	private function parseRequest() {
		/* PROTOCOL */
		if (filter_input(INPUT_SERVER, 'SERVER_PORT') == 443) {
			$this->__request['protocol'] = 'https';
		} else {
			$this->__request['protocol'] = 'http';
		}
		/* HOST with www */
//		$this->setRequest('host', filter_input(INPUT_SERVER, 'HTTP_HOST'));
		/* HOST without www */
		$this->__request['host'] = preg_replace('#^www\.(.+\.)#i', '$1', filter_input(INPUT_SERVER, 'HTTP_HOST'));
		/* PATH */
		$path_matches = array();
		if (preg_match('/[^\?]+/', filter_input(INPUT_SERVER, 'REQUEST_URI'), $path_matches) === 1) {
			$this->__request['path'] = $path_matches[0];
		} else {
			$this->__request['path'] = NULL;
		}
		/* METHOD */
		$this->__request['method'] = strtolower(filter_input(INPUT_SERVER, 'REQUEST_METHOD'));
		/*STATUS*/
		$this->status = filter_input(INPUT_SERVER, 'REDIRECT_STATUS');
		/*ACCEPT*/
		$this->accept = filter_input(INPUT_SERVER, 'HTTP_ACCEPT');
		/* GET */
		$this->__request['get'] = filter_input_array(INPUT_GET);
		/* POST */
		$this->__request['post'] = filter_input_array(INPUT_POST);
		/* FILE */
		if (empty($_FILES) === FALSE) {
			$this->__request['file'] = $_FILES;
		} else {
			$this->__request['file'] = NULL;
		}
		if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH') !== NULL) {
			$this->isAjax = TRUE;
		} else {
			$this->isAjax = FALSE;
		}
	}

	public function getRequest() {
		return $this->__request;
	}

	public function method() {
		return $this->__request['method'];
	}

	public function protocol() {
		return $this->__request['protocol'];
	}

	public function host() {
		return $this->__request['host'];
	}

	public function path() {
		return $this->__request['path'];
	}

	public function post($key = NULL, $options = array()) {
		if ($key === NULL) {
			if (isset($this->__request['post']) === TRUE) {
				$value = $this->__request['post'];
			} else {
				$value = NULL;
			}
			$result = $value;
		} else {
			if (isset($this->__request['post'][$key]) === TRUE) {
				$value = $this->__request['post'][$key];
			} else {
				$value = NULL;
			}
			if (empty($options) === FALSE) {
				$result = $this->convertResult($value, $options);
			} else {
				$result = $value;
//				$result = $this->convertResult($value, [
//					'empty' => '',
//				]);
			}
		}

		return $result;
	}

	public function get($key = NULL, $options = array()) {
		if ($key === NULL) {
			if (isset($this->__request['get']) === TRUE) {
				$value = $this->__request['get'];
			} else {
				$value = NULL;
			}
		} else {
			if (isset($this->__request['get'][$key]) === TRUE) {
				$value = $this->__request['get'][$key];
			} else {
				$value = NULL;
			}
		}
		if (empty($options) === FALSE) {
			$result = $this->convertResult($value, $options);
		} else {
			$result = $value;
		}

		return $result;
	}

	public function file($key = NULL) {
		if ($key === NULL) {
			if (isset($this->__request['file']) === TRUE) {
				$result = $this->__request['file'];
			} else {
				$result = NULL;
			}
		} else {
			if (isset($this->__request['file'][$key]) === TRUE) {
				$result = $this->__request['file'][$key];
			} else {
				$result = NULL;
			}
		}

		return $result;
	}

	private function convertResult($value, $options) {
		if (array_key_exists('empty', $options) === TRUE and empty($value) === TRUE) {
			$result = $options['empty'];
		} elseif (array_key_exists('cast', $options) and is_null($value) === FALSE) {
//			dump($options);
			$case = $options['cast'];
			switch ($case) {
				case 'boolean':
					$result = (bool)$value;
					break;
				case 'integer':
					$result = (int)$value;
					break;
				case 'string':
					$result = (string)$value;
					break;
				default:
					throw new \Exception("undefined cast: {$case}");
					break;
			}
		} else {
			$result = $value;
		}

		return $result;
	}

	/**
	 * @param null $array
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function createUrl($array = NULL) {
		$url = array();
		if (isset($array['protocol']) === TRUE) {
			$protocol = $array['protocol'];
		} else {
			$protocol = $this->protocol();
		}
		if (isset($array['host']) === TRUE) {
			$url[] = $array['host'];
		} else {
			$url[] = $this->host();
		}
		if (isset($array['path']) === TRUE) {
			$url[] = $array['path'];
		} else {
			$url[] = $this->path();
		}
		if (empty($array['get']) === FALSE) {
//			$get_array = array();
//			foreach ($array['get'] as $key => $value) {
//				if ($value !== NULL) {
//					$get_array[] = $key . '=' . htmlentities($value);
//				}
//			}
//			$url[] = '?' . implode('&', $get_array);
			$url[] = '?' . http_build_query($array['get']);
		} else {
			$url[] = '';
//			$url[] = '?' . http_build_query($this->get());
		}
		$result = "{$protocol}://" . implode('', $url);

		return $result;
	}
}
