<?php

namespace fa\core\helpers;

use fa\core\classes\Singleton;

class Validator extends Singleton {

	public static $instance;

	private function validateSet($value, $parameters) {
		if (empty($value) === TRUE) {
			return $this->addError("can not be blank", $parameters);
		} else {
			return TRUE;
		}
	}

	private function validateBoolean($value, $parameters) {
		if (filter_var($value, FILTER_VALIDATE_BOOLEAN) === FALSE) {
			return $this->addError("is not a boolean", $parameters);
		} else {
			return TRUE;
		}
	}

	private function validateInteger($value, $parameters) {
		if (filter_var($value, FILTER_VALIDATE_INT) === FALSE) {
			return $this->addError("is not an integer", $parameters);
		} else {
			return TRUE;
		}
	}

	private function validateFloat($value, $parameters) {
		if (filter_var($value, FILTER_VALIDATE_FLOAT) === FALSE) {
			return $this->addError("is not a float", $parameters);
		} else {
			return TRUE;
		}
	}

	private function validateEmail($value, $parameters) {
		if (filter_var($value, FILTER_VALIDATE_EMAIL) === FALSE) {
			return $this->addError("is not a valid email", $parameters);
		} else {
			return TRUE;
		}
	}

	private function validateIp($value, $parameters) {
		if (filter_var($value, FILTER_VALIDATE_IP) === FALSE) {
			return $this->addError("is not a valid ip", $parameters);
		} else {
			return TRUE;
		}
	}

	private function validateMac($value, $parameters) {
		if (filter_var($value, FILTER_VALIDATE_MAC) === FALSE) {
			return $this->addError("is not a valid mac", $parameters);
		} else {
			return TRUE;
		}
	}

	private function validateUrl($value, $parameters) {
		if (filter_var($value, FILTER_VALIDATE_URL) === FALSE) {
			return $this->addError("is not a valid url", $parameters);
		} else {
			return TRUE;
		}
	}

	private function validateMatch($value, $parameters) {
		if (preg_match("/^{$parameters['pattern']}$/", $value) === 0) {
			return $this->addError("does not match pattern {$parameters['pattern']}", $parameters);
		} else {
			return TRUE;
		}
	}

	private function addError($error, $parameters) {
		if (isset($parameters['message']) === TRUE) {
			$result = $parameters['message'];
		} else {
			$result = $error;
		}

		return $result;
	}

	public function validateField($value, $validator, $parameters = NULL) {
//		dump($value);
//		dump($validator);
		switch ($validator) {
			case 'any':
				$result = TRUE;
				break;
			case 'set':
				$result = $this->validateSet($value, $parameters);
				break;
			case 'boolean':
				$result = $this->validateBoolean($value, $parameters);
				break;
			case 'integer':
				$result = $this->validateInteger($value, $parameters);
				break;
			case 'float':
				$result = $this->validateFloat($value, $parameters);
				break;
			case 'email':
				$result = $this->validateEmail($value, $parameters);
				break;
			case 'ip':
				$result = $this->validateIp($value, $parameters);
				break;
			case 'mac':
				$result = $this->validateMac($value, $parameters);
				break;
			case 'url':
				$result = $this->validateUrl($value, $parameters);
				break;
			case 'match':
				$result = $this->validateMatch($value, $parameters);
				break;
			default:
				throw new \Exception('Undefined validator: ' . $validator);
		}

		return $result;
	}
}
