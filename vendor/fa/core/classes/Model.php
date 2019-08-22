<?php

namespace fa\core\classes;

use fa\core\faf;

abstract class Model extends Singleton {

	private $data;
	private $rules;
	private $errors;
	private $validators;
	public $valid;

	protected abstract function rules();

	public function reset() {
		$this->data = array();
		$this->rules = array();
		$this->validators = array();
		$this->errors = array();
		$this->valid = TRUE;

		return $this;
	}

	/**
	 * @param $data
	 *
	 * @return $this
	 */
	public function load($data = NULL) {
		$this->reset();
		$this->loadData($data);

		return $this;
	}

	/**
	 * @param $data
	 *
	 * @return $this
	 */
	public function addLoad($data) {
		$this->loadData($data);

		return $this;
	}

	private function loadData($data) {
		$rules = $this->getRules();
		if (empty($data) === FALSE) {
			foreach ($data as $key => $value) {
				if (isset($rules[$key]) === TRUE) {
//					$this->data[$key] = $value;
					/*
					 * todo-ivan make it configurable
					 */
					$this->data[$key] = strip_tags($value);
					$this->addValidator($key, $rules[$key]);
				} else {
					//load but not add validation
				}
			}
		}
	}

	public function getValidators() {
		return $this->validators;
	}

	/**
	 * @param $field
	 * @param $rule
	 *
	 * @return $this
	 * @throws \Exception
	 */
	public function addValidator($field, $rule) {
		if (empty($rule) === TRUE) {
			throw new \Exception('Empty rules for field: ' . $field);
		}
//		if ($rule instanceof \Closure === TRUE) {
//			$this->validators[$field]['rules'][] = $rule;
//		if (is_array($rule) === TRUE) {
//			$this->validators[$field]['rules'] += $rule;
//		} else {
//			$this->validators[$field]['rules'][] = $rule;
//		}
		if (isset($this->validators[$field]) === FALSE) {
			$this->validators[$field] = [];
		}
		if (is_array($rule) === TRUE) {
			$this->validators[$field] += $rule;
		} else {
			$this->validators[$field][] = $rule;
		}

		return $this;
	}

	public function validate() {
		foreach ($this->validators as $validator_key => $validator_value) {
			foreach ($validator_value as $rule_key => $rule_value) {
				if ($rule_value instanceof \Closure === TRUE) {
					$result = $rule_value();
				} elseif (is_integer($rule_key) === TRUE) {
					$result = faf::validator()->validateField($this->data[$validator_key], $rule_value);
				} else {
					$result = faf::validator()->validateField($this->data[$validator_key], $rule_key, $rule_value);
				}
				$this->errors[$validator_key] = $result;
				if ($result !== TRUE) {
					$this->valid = FALSE;
					break;
				}
			}
		}

		return $this;
	}

	public function getData($key = NULL) {
		if ($key !== NULL) {
			if (isset($this->data[$key]) === TRUE) {
				return $this->data[$key];
			} else {
				return NULL;
			}
		} else {
			return $this->data;
		}
	}

	public function getRules() {
		if (empty($this->rules) === TRUE) {
			$this->rules = $this->rules();
		}

		return $this->rules;
	}

	public function getErrors() {
		if (empty($this->errors) === FALSE) {
			return array_filter($this->errors, function ($value) {
				return $value !== TRUE;
			}, ARRAY_FILTER_USE_BOTH);
		} else {
			return NULL;
		}
	}

	public function errorsToJson() {
		return json_encode($this->getErrors());
	}
}
