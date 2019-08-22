<?php

namespace fa\core\services;

use fa\core\classes\Singleton;
use fa\core\faf;

final class InputOutput extends Singleton {

	public static $instance;

	/**
	 * @param string $path
	 *
	 * @return resource
	 */
	public function streamCreate($path) {
		$pointer = fopen($path, "w");
//		fwrite($fp,$content);
		fclose($pointer);

		return $pointer;
	}

	/**
	 * @param string $directory
	 *
	 * @return boolean
	 */
	public function checkDirectory($directory) {
		return is_dir($directory);
	}

	/**
	 * @param string $path
	 *
	 * @return boolean
	 */
	public function checkFile($path) {
		return is_file($path);
	}

	/**
	 * @param $path
	 *
	 * @return integer|boolean
	 */
	public function createFile($path) {
		return file_put_contents($path, NULL);
	}

	/**
	 * @param $directory
	 * @param int $mode
	 *
	 * @return bool
	 */
	public function createDirectory($directory, $mode = 0700) {
		return mkdir($directory, $mode, TRUE);
	}

	public function deleteFile($path) {
		unlink($path);
	}

	/**
	 * @param string $file_path
	 *
	 * @return string
	 * @throws \Exception
	 */
	public function loadFile($file_path) {
		return file_get_contents($file_path);
	}

	/**
	 * @param string $path
	 * @param string $data
	 * @param boolean $append
	 *
	 * @throws \Exception
	 */
	public function saveFile($path, $data, $append = FALSE) {
		if ($append == TRUE) {
			file_put_contents($path, $data, FILE_APPEND);
		} else {
			file_put_contents($path, $data);
		}
	}

	public function isUploaded($data) {
		if ($data['error'] === 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function saveUploaded($directory, $file, $data) {
		if ($this->checkDirectory($directory) === FALSE) {
			$this->createDirectory($directory);
		}
		$file_path = $directory . $file . '.' . faf::helper()->getExtensionByContentType($data['type']);
		if (move_uploaded_file($data['tmp_name'], str_replace('\\', DIRECTORY_SEPARATOR, $file_path)) === TRUE) {
			return TRUE;
		} else {
//			throw new \Exception('file upload failed: ' . $file_path);
			return FALSE;
		}
	}

	/**
	 * @param string $file
	 * @param string $data
	 */
	public function log($file, $data) {
		$directory = faf::$configuration['paths']['storage'] . 'logs/';
		if (faf::io()->checkDirectory($directory) === FALSE) {
			faf::io()->createDirectory($directory);
		}
		$path = $directory . $file . '.log';
		if (faf::io()->checkFile($path) === FALSE) {
			faf::io()->createFile($path);
		}
		$this->saveFile($path, date('d/M/Y H:i:s') . $data . PHP_EOL, TRUE);
	}
}
