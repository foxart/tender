<?php

namespace fa\classes;

use fa\core\classes\Singleton;
use fa\core\faf;
use fa\core\helpers\Template;

abstract class View extends Singleton implements ViewInterface {

//abstract class View implements ViewInterface {
	private $template;

	public final function renderIndex() {
		return faf::debug()->dump($this, FALSE);
	}

//	private static $template;
	public final function displayInformationMessage($message = NULL) {
		if ($message === NULL) {
			$result = '<b>Information:</b> no data to display';
		} else {
			$result = $message;
		}

		return '<div class="alert alert-info">' . $result . '</div>';
	}

	public final function displayWarningMessage($message = NULL) {
		if ($message === NULL) {
			$result = '<b>Warning:</b> no data to display';
		} else {
			$result = $message;
		}

		return '<div class="alert alert-warning">' . $result . '</div>';
	}

	public final function displayErrorMessage($message = NULL) {
		if ($message === NULL) {
			$result = '<b>Error:</b> no data to display';
		} else {
			$result = $message;
		}

		return '<div class="alert alert-danger">' . $result . '</div>';
	}

	/**
	 * @return \fa\core\helpers\Template
	 */
	public final function template() {
		$debug_backtrace = debug_backtrace();
		$class = $debug_backtrace[1]['class'];
		$method = $debug_backtrace[1]['function'];
		if (isset($this->template[$class][$method]) === FALSE) {
			$this->template[$class][$method] = new Template();
		}

		return $this->template[$class][$method];
	}
}
