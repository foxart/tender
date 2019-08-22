<?php

namespace tender\root\modules\models;

use fa\classes\SqlModel;
use fa\core\faf;
use tender\common\connections\DefaultConnection;

class MaintenanceModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}

	public function getFilePath() {
		$result = str_replace([
			'\\',
			'/',
		], DIRECTORY_SEPARATOR, faf::$configuration['paths']['files']);

		return $result;
	}

	public function normalizePath($list) {
		$result = array();
		foreach ($list as $item) {
			$result[] = str_replace([
				'\\',
				'/',
			], DIRECTORY_SEPARATOR, $item);
		}

		return $result;
	}

	public function sortByLenght($a, $b) {
		if (strlen($a) === strlen($b)) {
			$result = 0;
		} elseif (strlen($a) > strlen($b)) {
			$result = -1;
		} else {
			$result = 1;
		}

		return $result;
	}

	public function getFileListFromDb() {
		$files = $this->loadQuery('modules/sql/getFileList.sql')->execute()->fetchAll();
		$result = array();
		foreach ($files as $file) {
			$result[] = $file['file'];
		}

		return $result;
	}

	public function getFileListOnDisk($path) {
		$objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
		$fileList = [];
		foreach ($objects as $name => $object) {
			if ($object->isFile() === TRUE) {
				$file = str_replace([
					$path,
					DIRECTORY_SEPARATOR,
				], [
					'',
					'/',
				], $name);
				$fileList [] = $file;
			}
		}

		return $fileList;
	}

	public function getFileListForRemove($path) {
		$fileListOnDisk = $this->getFileListOnDisk($path);
		$fileListFromDB = $this->getFileListFromDb();
		$diff = array_diff($fileListOnDisk, $fileListFromDB);
		$removeFilesList = array();
		if (empty($diff) === FALSE) {
			foreach ($diff as $item) {
				$removeFilesList [] = $path . str_replace([
						'/',
						'\\',
					], DIRECTORY_SEPARATOR, $item);
			}
		}

		return $removeFilesList;
	}

	public function getEmptyDirs($path) {
		$objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
		$emptyDirList = array();
		$allDirList = array();
		foreach ($objects as $name => $object) {
			if ($object->isDir() === TRUE) {
				$list = glob($name . '/*');
				if (preg_match('#.*\\.\.?$#', $name) === 0) {
					$allDirList[$name] = $this->normalizePath($list);
					if (count($list) === 0) {
						$emptyDirList[] = $name;
					}
				}
			}
		}
		// перебираем масив директорий и смотрим разницу с пустыми диреториями
		// если разницы нету то это пустая диретория и удаляем её из списка директорий
		// и добавляем ёё в список пустых диреторий
		// повторяем до тех пор пока не будет найдено ни одной пустой директории
		do {
			$flag = 0;
			foreach ($allDirList as $dirname => $content) {
				if (empty (array_diff($content, $emptyDirList)) === TRUE) {
					if (in_array($dirname, $emptyDirList) === FALSE) {
						$emptyDirList[] = $dirname;
					}
					unset($allDirList[$dirname]);
					$flag = 1;
				}
			}
		} while ($flag === 1);
		usort($emptyDirList, array(
			$this,
			"sortByLenght",
		));

		return $emptyDirList;
	}
}
