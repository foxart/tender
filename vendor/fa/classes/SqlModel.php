<?php

namespace fa\classes;

use fa\core\classes\Model;
use fa\core\classes\Pdo;
use fa\core\faf;

abstract class SqlModel extends Model {

	/**
	 * @var array
	 */
	private static $__sql;
//	private static $path;
	private static $connection;
	public $path;
	public $count;
	public $last_insert_id;
	public $statement;

	public function onConstruct() {
		if (property_exists(static::class, 'connection') === FALSE) {
			throw new \Exception('Access to undeclared static property: ' . static::class . '::$connection');
		}
		if (property_exists(static::class, 'path') === FALSE) {
			throw new \Exception('Access to undeclared static property: ' . static::class . '::$path');
		}
		self::instance()->reset();
	}

	public function getSqlPatterns() {
		return self::sql()->getPatterns();
	}

	/**
	 * @return \fa\core\classes\Pdo
	 * @throws \Exception
	 */
	private static function sql() {
		/**
		 * @var $connection_map \fa\classes\Connection
		 */
		$connection_map = static::$connection;
		if (isset(self::$__sql[static::$connection]) === FALSE) {
			/**
			 * @var $sql \fa\core\classes\Pdo
			 */
			$sql = new Pdo();
			if (empty($sql->connect($connection_map::get())->getConnectionError()) === TRUE) {
				self::$__sql[static::$connection] = $sql;
			} else {
				throw new \Exception($sql->connect($connection_map::get())->getConnectionError());
			}
//			bdump(self::$__sql);
		}

		return self::$__sql[static::$connection];
	}

	public function getSqlError() {
		return self::sql()->getError();
	}

	public function getSqlDebug() {
		return self::sql()->getDebug();
	}

	/**
	 * @param $query
	 *
	 * @return $this
	 * @throws \Exception
	 */
	protected function loadQuery($query) {
		$sql_directory = [
			faf::$configuration['paths']['application'],
			FA_PATH,
		];
		$found = FALSE;
		foreach ($sql_directory as $directory) {
			if (faf::io()->checkFile($directory . $query) === TRUE) {
				$found = TRUE;
				$this->path = $directory . $query;
				break;
			}
		}
		if ($found === FALSE) {
			throw new \Exception('sql not found: ' . $query . "\nin [\n" . implode(PHP_EOL, $sql_directory) . "\n]");
		}
//		$this->setQuery(faf::io()->loadFile(faf::$configuration['paths']['application'] . static::$path . $query));
		$this->setQuery(faf::io()->loadFile($this->path));

		return $this;
	}

	/**
	 * @param $query
	 *
	 * @return $this
	 */
	protected function setQuery($query) {
		self::sql()->setQuery($query);

		return $this;
	}

	/**
	 * @param $data
	 *
	 * @return $this
	 * @throws \Exception
	 */
	protected function prepare($data) {
		if (empty($data) === TRUE) {
			throw new \Exception('No data to prepare');
		}
		self::sql()->prepareVariables($data);

//		exit;
		return $this;
	}


	/*
	 * DEBUG
	 */
	protected function fetchAll() {
		return self::sql()->fetchAll();
//		self::sql()->prepareVariables($this->getData());
//		$this->log();
//		if (self::sql()->executeStatement() === TRUE) {
//			$result = self::sql()->execute()->fetchAll();
//			$this->count = self::sql()->countRows();
//		} else {
//			$result = FALSE;
//			$this->count = 0;
//		}
//
//		return $result;
	}

	protected function fetchRow($index = NULL) {
		$row = self::sql()->fetchRow();
		if ($index !== NULL and $row !== FALSE) {
			if (isset($row[$index]) === TRUE) {
				return $row[$index];
			} else {
				throw new \Exception('undefined row index: ', $index);
			}
		} else {
			return $row;
		}
	}

	/**
	 * @return $this
	 */
	protected function execute() {
		if (empty($this->getData()) === FALSE) {
			self::sql()->prepareVariables($this->getData());
		}
		$this->log();
		$this->statement = self::sql()->executeStatement();
		$this->count = self::sql()->countRows();
		$this->last_insert_id = self::sql()->lastInsertId();

		return $this;
	}

	/**
	 * LOG
	 */
	private function log() {
		$data = array();
		$data[] = PHP_EOL . 'file: ' . faf::backtrace()->getCallee(4)['class'] . '->' . faf::backtrace()->getCallee(4)['function'] . '()' . PHP_EOL;
		$data[] = 'variables: ' . json_encode(self::sql()->getVariables(), JSON_PRETTY_PRINT) . PHP_EOL;
		$data[] = 'query: ' . PHP_EOL . $this->getQuery() . PHP_EOL;
//		$data[] = PHP_EOL;
		faf::io()->log('sql', implode('', $data));
	}

	public function getQuery() {
		$result = array();
		foreach ($this->getSqlVariables() as $key => $value) {
			switch (gettype($value)) {
				case 'boolean':
					$result[":$key"] = $value;
					break;
				case 'NULL':
					$result[":$key"] = NULL;
					break;
				case 'integer':
					$result[":$key"] = $value;
					break;
				case 'string':
					$result[":$key"] = "'" . addslashes($value) . "'";
					break;
				case 'resource':
					$result[":$key"] = $value;
					break;
				default:
					throw new \Exception('Undefined parameter type: ' . gettype($value));
			}
		}

		return str_replace(array_keys($result), array_values($result), $this->getSqlQuery());
	}

	public function getSqlVariables() {
		return self::sql()->getVariables();
	}

	public function getSqlQuery() {
		return self::sql()->getQuery();
	}
}
