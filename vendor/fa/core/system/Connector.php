<?php

namespace fa\core\system;

use fa\core\classes\Singleton;
use fa\core\helpers\Converter;
use fa\core\helpers\Generator;
use fa\core\helpers\Helper;
use fa\core\helpers\Html;
use fa\core\helpers\Menu;
use fa\core\helpers\Paginator;
use fa\core\helpers\Table;
use fa\core\helpers\Template;
use fa\core\helpers\Validator;
use fa\core\services\Backtrace;
use fa\core\services\Debug;
use fa\core\services\Header;
use fa\core\services\Image;
use fa\core\services\InputOutput;
use fa\core\services\Request;
use fa\core\services\Router;
use fa\core\services\Server;
use fa\core\services\Session;

abstract class Connector extends Singleton {

	private static $connector;
	/* HELPERS */
	/**
	 * @return \fa\core\helpers\Converter
	 */
	public static function converter() {
		return Converter::instance();
	}

	/**
	 * @return \fa\core\helpers\Generator
	 */
	public static function generator() {
		return Generator::instance();
	}

	/**
	 * @return \fa\core\helpers\Helper
	 */
	public static function helper() {
		return Helper::instance();
	}

	/**
	 * @return \fa\core\helpers\Html
	 */
	public static function html() {
		return Html::instance();
	}

	/**
	 * @return \fa\core\helpers\Menu
	 */
	public static function menu() {
		return Menu::instance();
	}

	/**
	 * @return \fa\core\helpers\Table
	 */
	public static function table() {
		return Table::instance();
	}

	/**
	 * @return \fa\core\helpers\Template
	 */
	public static function template() {
		if (isset(self::$connector[__METHOD__]) === FALSE) {
			self::$connector[__METHOD__] = new Template();
		}

		return self::$connector[__METHOD__];
	}

	/**
	 * @return \PHPMailer
	 */
	public static function mailer() {
		if (isset(self::$connector[__METHOD__]) === FALSE) {
			self::$connector[__METHOD__] = new \PHPMailer();
		}

		return self::$connector[__METHOD__];
	}

	/**
	 * @return \fa\core\helpers\Validator
	 */
	public static function validator() {
		return Validator::instance();
	}

	/**
	 * @return \fa\core\helpers\Paginator
	 */
	public static function paginator() {
		return Paginator::instance();
	}

	/* SERVICES */
	/**
	 * @return \fa\core\services\Backtrace
	 */
	public static function backtrace() {
		return Backtrace::instance();
	}

	/**
	 * @return \fa\core\services\Debug
	 */
	public static function debug() {
		return Debug::instance();
	}

	/**
	 * @return \fa\core\services\InputOutput
	 */
	public static function io() {
		return InputOutput::instance();
	}

	/**
	 * @return \fa\core\services\Image
	 */
	public static function image() {
		return Image::instance();
	}

	/**
	 * @return \fa\core\services\Header
	 */
	public static function header() {
		return Header::instance();
	}

	/**
	 * @return \fa\core\services\Request
	 */
	public static function request() {
		return Request::instance();
	}

	/**
	 * @return \fa\core\services\Router
	 */
	public static function router() {
		return Router::instance();
	}

	/**
	 * @return \fa\core\services\Server
	 */
	public static function server() {
		return Server::instance();
	}

	/**
	 * @return \fa\core\services\Session
	 */
	public static function session() {
		return Session::instance();
	}
}
