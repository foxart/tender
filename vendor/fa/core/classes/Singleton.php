<?php

namespace fa\core\classes;

/**
 * <p>returns class <b>Singleton</b></p>
 *
 * @link http://foxart.org
 * @return \fa\core\classes\Singleton
 */
abstract class Singleton {

	/**
	 * @var static <p>reference to the <i>Singleton</i> instance of class</p>
	 */
	private static $instance;

	/**
	 * @var array <p>list of the invoked <i>Singleton</i> instances</p>
	 */
	private static $__instances;

	/**
	 * Private constructor to prevent creating a new instance of the Singleton instance
	 */
	private final function __construct() {

	}

	/**
	 * Private clone method to prevent cloning of the instance of the Singleton instance
	 */
	public final function __clone() {
		throw new \Exception('Cloning is forbidden');
	}

	/**
	 * Private serialize method to prevent serialization of the Singleton instance
	 */
	public final function __sleep() {
		throw new \Exception('Serializing is forbidden');
	}

	/**
	 * Private unserialize method to prevent unserialization of the Singleton instance
	 */
	public final function __wakeup() {
		throw new \Exception('Unserializing is forbidden');
	}

	/**
	 * Singleton constructor
	 */
	public function onConstruct() {
//		dump(static::$instance);
	}

	/**
	 * Returns late static binding of class <i>Singleton</i>
	 *
	 * @return static
	 * @throws \Exception
	 */
	public final static function instance() {
		if (property_exists(static::class, 'instance') === FALSE) {
			throw new \Exception('Access to undeclared static property: ' . static::class . '::$instance');
		}
		if (static::$instance === NULL) {
			static::$instance = new static();
			self::$__instances[] = static::class;
			static::$instance->onConstruct();
		}

		return static::$instance;
	}

	/**
	 * Returns invoked instances of class <i>Singleton</i>
	 *
	 * @return array
	 */
	public final function getInstances() {
		return self::$__instances;
	}

}
