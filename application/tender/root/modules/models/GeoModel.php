<?php

namespace tender\root\modules\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;
use tender\root\configurations\ImportConfiguration;

class GeoModel extends SqlModel {

	public static $instance;
	public static $path = 'root/sql/';
	public static $connection = DefaultConnection::class;
	public $import = array();

	protected function rules() {
		return [];
	}

	public function setImport($item) {
		if (ImportConfiguration::check($item) === TRUE) {
			$this->import = ImportConfiguration::get($item);
		} else {
			throw  new \Exception('Undefined parameter: ' . $item);
		}
	}

	public function getGeoItem($name) {
		return $this->loadQuery($this->import['getItem'])->prepare(['name' => $name])->execute()->fetchRow();
	}

	public function getTotalItems() {
		$result = $this->loadQuery($this->import['getTotalItems'])->execute()->fetchRow();

		return $result['count'];
	}

	public function addItem($item) {
		$exist = $this->loadQuery($this->import['checkUniqueItem'])->prepare($item)->execute()->count;
		if (empty($exist) === TRUE) {
			$this->loadQuery($this->import['addItem'])->prepare($item)->execute();
		}
	}

	public function importCsv($file) {
		return $this->loadQuery('importCsv.sql')->prepare(['filename' => $file])->execute()->count;
	}

	public function CreateGeoTable() {
		return $this->loadQuery('createGeo.sql')->execute();
	}
}
