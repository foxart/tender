<?php

namespace fa\core\helpers;

final class Converter extends \fa\core\classes\Singleton {

	/**
	 * @var static <p>reference to the <i>Singleton</i> instance of class</p>
	 */
	public static $instance;

	/**
	 * @param $array
	 *
	 * @return \stdClass
	 */
	public function arrayToObject($array) {
		$result = new \stdClass();
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				$value = $this->arrayToObject($value);
			}
			$result->$key = $value;
		}

		return $result;
	}

	/**
	 * @param $array
	 *
	 * @return string
	 */
	public function arrayToMetadata($array) {
		if (is_array($array) === TRUE) {
			$metadata = array();
			foreach ($array as $key => $value) {
				if (is_array($value) === TRUE) {
					$metadata[] = "{$key}:{$this->arrayToMetadata($value)}";
				} else {
					$metadata[] = "{$key}:'{$value}'";
				}
			}
			$result = "{" . implode(', ', $metadata) . "}";
		} else {
			$result = new \Exception('must be an array');
		}

		return $result;
	}

	/**
	 * @param array $array1
	 * @param array $array2
	 *
	 * @return array
	 */
	public function arrayIntersectKeyRecursive(array $array1, array $array2) {
		$array1 = array_intersect_key($array1, $array2);
		foreach ($array1 as $key => &$value) {
			if (is_array($value)) {
				$value = is_array($array2[$key]) ? $this->arrayIntersectKeyRecursive($value, $array2[$key]) : $value;
			}
		}

		return $array1;
	}
}
