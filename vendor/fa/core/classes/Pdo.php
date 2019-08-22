<?php

namespace fa\core\classes;

final class Pdo {

	private $query;
	private $variables;
	private $variables_check;
	private $variables_placeholders;
	private $patterns;
	private $patterns_check;
	private $patterns_placeholders;
	private $connection_dms;
	private $connection_string;
	private $connection_username;
	private $connection_password;
	private $connection_options;
	private $connection_error;
	/**
	 * @var \PDO
	 */
	private $pdo_link;
	/**
	 * @var \PDOStatement
	 */
	private $pdo_statement;
	private $pdo_options = array(
		'fetch' => array(
			'pdo_attribute' => 'ATTR_DEFAULT_FETCH_MODE',
			'pdo_values' => array(
				'associative' => \PDO::FETCH_ASSOC,
				'numeric' => \PDO::FETCH_NUM,
				'both' => \PDO::FETCH_BOTH,
				'object' => \PDO::FETCH_OBJ,
			),
		),
		'case' => array(
			'pdo_attribute' => 'ATTR_CASE',
			'pdo_values' => array(
				'natural' => \PDO::CASE_NATURAL,
				'upper' => \PDO::CASE_UPPER,
				'lower' => \PDO::CASE_LOWER,
			),
		),
		'nulls' => array(
			'pdo_attribute' => 'ATTR_ORACLE_NULLS',
			'pdo_values' => array(
				'natural' => \PDO::NULL_NATURAL,
				'empty' => \PDO::NULL_EMPTY_STRING,
				'string' => \PDO::NULL_TO_STRING,
			),
		),
		'error' => array(
			'pdo_attribute' => 'ATTR_ERRMODE',
			'pdo_values' => array(
				'silent' => \PDO::ERRMODE_SILENT,
				'warning' => \PDO::ERRMODE_WARNING,
				'exception' => \PDO::ERRMODE_EXCEPTION,
			),
		),
		'prepares' => array(
			'pdo_attribute' => 'ATTR_EMULATE_PREPARES',
			'pdo_values' => [
				'true' => TRUE,
				'false' => FALSE,
			],
		),
		'timeout' => array(
			'pdo_attribute' => 'ATTR_TIMEOUT',
			'pdo_values' => NULL,
		),
	);

	public function getAttributes() {
		$data = array(
			'ATTR_AUTOCOMMIT',
			'ATTR_CASE',
			'ATTR_CLIENT_VERSION',
			'ATTR_CONNECTION_STATUS',
			'ATTR_DEFAULT_FETCH_MODE',
			'ATTR_EMULATE_PREPARES',
			'ATTR_ERRMODE',
			'ATTR_ORACLE_NULLS',
			'ATTR_PERSISTENT',
			'ATTR_SERVER_INFO',
			'ATTR_SERVER_VERSION',
//			'ATTR_STRINGIFY_FETCHES',
			'ATTR_TIMEOUT',
//			'MYSQL_ATTR_USE_BUFFERED_QUERY',
		);
		$result = array();
		foreach ($data as $item) {
			$result[$item] = $this->pdo_link->getAttribute(constant("PDO::{$item}"));
		}

		return $result;
	}

	public function connect($data) {
//		$this->connection_directory = $data['directory'];
		$this->connection_dms = $data['dms'];
		if (isset($data['options']) === TRUE) {
			foreach ($data['options'] as $key => $value) {
				if ($this->pdo_options[$key]['pdo_values'][$value] === NULL) {
					$this->connection_options[constant("PDO::{$this->pdo_options[$key]['pdo_attribute']}")] = $value;
//					dump($this->pdo_options[$key]['pdo_attribute']);
//					dump($value);
				} else {
					$this->connection_options[constant("PDO::{$this->pdo_options[$key]['pdo_attribute']}")] = $this->pdo_options[$key]['pdo_values'][$value];
//					dump($this->pdo_options[$key]['pdo_attribute']);
//					dump($this->pdo_options[$key]['pdo_values'][$value]);
				}
			}
		}
//		[PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8' COLLATE 'utf8_unicode_ci'"]
		switch ($data['dms']) {
			case 'mysql':
//				$this->connection_string = "mysql:host={$data['connection']['hostname']};dbname={$data['connection']['database']};charset={$data['connection']['charset']}";
				$this->connection_string = "mysql:host={$data['connection']['hostname']};dbname={$data['connection']['database']}";
				$this->connection_options[\PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES '{$data['connection']['charset']}' COLLATE '{$data['connection']['collation']}'";
//				dump($this->connection_options);
				break;
			case 'mssql':
				if (PHP_OS == 'Linux') {
					$this->connection_string = "dblib:host={$data['connection']['hostname']};dbname={$data['connection']['database']}";
				} else {
					$this->connection_string = "sqlsrv:server={$data['connection']['hostname']};database={$data['connection']['database']}";
				}
				break;
			case 'pgsql':
				$this->connection_string = "pgsql:host={$data['connection']['hostname']};dbname={$data['connection']['database']}";
				break;
			default:
				throw new \Exception("undefined dms: {$data['dms']}");
				break;
		}
		$this->connection_username = $data['connection']['username'];
		$this->connection_password = $data['connection']['password'];
		try {
			$this->pdo_link = new \PDO($this->connection_string, $this->connection_username, $this->connection_password, $this->connection_options);
			$this->connection_error = NULL;
		} catch (\PdoException $exception) {
			$this->connection_error = $exception->getMessage();
		}

		return $this;
	}

	public function resetQuery() {
		$this->pdo_statement = NULL;
		$this->variables = array();
		$this->variables_check = array();
		$this->patterns = array();
		$this->patterns_check = array();

		return $this;
	}

	public function prepareVariables($variables) {
//		dump($this->variables_placeholders);
		foreach (array_keys($this->variables_placeholders) as $placeholder) {
//			dump($placeholder);
//			if (is_array($variables) === FALSE) {
//				dump($placeholder);
//				dump($variables);
//				throw new \Exception('trace');
//				exit;
//			}
//			dump($placeholder);
//			dump($variables);
			if (array_key_exists($placeholder, $variables) === TRUE) {
				$this->variables[':' . $placeholder] = $variables[$placeholder];
				$this->variables_check[$placeholder] = $variables[$placeholder];
			} else {
//				throw new \Exception('Placeholder not prepared: ' . $placeholder);
			}
		}
//		return $this;
	}

	public function executeStatement() {
		$differences = array_merge(array_keys(array_diff_key($this->variables_placeholders, $this->variables_check)),
			array_keys(array_diff_key($this->patterns_placeholders, $this->patterns_check)));
		if (count($differences) !== 0) {
			throw new \Exception('Placeholders not filled: ' . implode(', ', $differences));
		}
		$this->pdo_statement = $this->pdo_link->prepare(str_replace(array_keys($this->patterns), array_values($this->patterns), $this->query));
//		$this->pdo_statement = $this->pdo_link->prepare($this->query);
		foreach ($this->variables as $key => $value) {
//			if ($this->switchParameter($value)===\PDO::PARAM_STR){
//				$this->pdo_statement->bindValue($key, strip_tags($value), $this->switchParameter($value));
//			} else {
//				$this->pdo_statement->bindValue($key, $value, $this->switchParameter($value));
//			}
			$this->pdo_statement->bindValue($key, $value, $this->switchParameter($value));
//			$this->pdo_statement->bindParam($key, $value, $this->switchParameter($value));
		}
		$result = $this->pdo_statement->execute();

//		$this->pdo_statement->closeCursor();
		return $result;
	}

	private function switchParameter($parameter) {
		switch (gettype($parameter)) {
			case 'boolean':
				$result = \PDO::PARAM_BOOL;
				break;
			case 'NULL':
				$result = \PDO::PARAM_NULL;
				break;
			case 'integer':
				$result = \PDO::PARAM_INT;
				break;
			case 'string':
				$result = \PDO::PARAM_STR;
				break;
			case 'resource':
				$result = \PDO::PARAM_LOB;
				break;
			default:
				throw new \Exception('Undefined parameter type: ' . gettype($parameter));
		}

		return $result;
	}

	public function fetchAll() {
		if (is_null($this->pdo_statement) === FALSE) {
			$result = $this->pdo_statement->fetchAll();
		} else {
			$result = NULL;
		}
		$this->pdo_statement->closeCursor();

		return $result;
	}

	public function fetchRow() {
		if (is_null($this->pdo_statement) === FALSE) {
			$result = $this->pdo_statement->fetch();
		} else {
			$result = NULL;
		}
		$this->pdo_statement->closeCursor();

		return $result;
	}

	/*
	 * todo-ivan
	 * Добавить возможность получить результат по конкретному полю
	 */
	public function countRows() {
		if (is_null($this->pdo_statement) === FALSE) {
			$result = $this->pdo_statement->rowCount();
		} else {
			$result = NULL;
		}

		return $result;
	}

	public function countColumns() {
		if (is_null($this->pdo_statement) === FALSE) {
			$result = $this->pdo_statement->columnCount();
		} else {
			$result = NULL;
		}

		return $result;
	}

	public function lastInsertId() {
		return $this->pdo_link->lastInsertId();
	}

	public function beginTransaction() {
		$this->pdo_link->beginTransaction();
	}

	public function checkTransaction() {
		return $this->pdo_link->inTransaction();
	}

	public function commitTransaction() {
		$this->pdo_link->commit();
	}

	public function rollbackTransaction() {
		$this->pdo_link->rollback();
	}

	public function getConnectionError() {
		return $this->connection_error;
	}

	public function enableAutocommit() {
		$this->pdo_link->setAttribute(\PDO::ATTR_AUTOCOMMIT, 1);
	}

	public function disableAutocommit() {
		$this->pdo_link->setAttribute(\PDO::ATTR_AUTOCOMMIT, 0);
	}

	public function getError() {
		return $this->pdo_link->errorInfo();
	}

	/*
	 * INFORMATION
	 */
	public function getOptions() {
		return $this->pdo_options;
	}

	public function getPatterns() {
		return $this->patterns_check;
	}

	public function getVariables() {
		return $this->variables_check;
	}

	public function getDebug() {
		ob_start();
		$this->pdo_statement->debugDumpParams();

		return ob_get_clean();
	}

	public function getQuery() {
		return $this->query;
	}

	public function setQuery($query) {
		$this->query = preg_replace([
			/*remove comments*/
			'/--.+/',
			'/#.+/',
			/*remove empty lines*/
//			'/^[ \t]*[\r\n]+/m',
		], '', $query);
		$this->pdo_statement = NULL;
		$this->variables = array();
		$this->variables_check = array();
		$matches = array();
		preg_match_all('/(?<=:)[0-9a-zA-Z_]+/', $this->query, $matches);
		$this->variables_placeholders = array_flip($matches[0]);
		$this->patterns = array();
		$this->patterns_check = array();
		$matches = array();
		preg_match_all('/(?<=\'{{ )[0-9a-zA-Z_]+(?= }}\')/', $this->query, $matches);
		$this->patterns_placeholders = array_flip($matches[0]);

//		dump($this->variables_placeholders);
		return $this;
	}
}
