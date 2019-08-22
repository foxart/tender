<?php

namespace tender\common\modules\geo\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class GeoModel extends SqlModel {

	public static $instance;
//	public static $path = 'modules/geo/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [
			/*
			 * AJAX
			 */
			'geo_country' => [
				'set',
			],
			'geo_region' => [
				'set',
			],
			'geo_city' => [
				'set',
			],
		];
	}

	/*
	 * country
	 */
	public function countryList($limit) {
		return $this->loadQuery('application/tender/common/modules/geo/sql/countryList.sql')->prepare([
			'limit' => $limit,
		])->execute()->fetchAll();
	}

	public function countryCheck($country) {
		$this->loadQuery('application/tender/common/modules/geo/sql/countryCheck.sql')->prepare([
			'country' => $country,
		])->execute()->fetchAll();
		if ($this->count === 0) {
			return 'unknown country';
		} else {
			return TRUE;
		}
	}

	/*
	 * region
	 */
	public function regionList($limit) {
		return $this->loadQuery('application/tender/common/modules/geo/sql/regionList.sql')->prepare([
			'limit' => $limit,
		])->execute()->fetchAll();
	}

	public function regionCheck($country, $region) {
		$this->loadQuery('application/tender/common/modules/geo/sql/regionCheck.sql')->prepare([
			'country' => $country,
			'region' => $region,
		])->execute()->fetchAll();
		if ($this->count === 0) {
			return 'unknown region';
		} else {
			return TRUE;
		}
	}

	/*
	 * city
	 */
	public function cityList($limit) {
		return $this->loadQuery('application/tender/common/modules/geo/sql/cityList.sql')->prepare([
			'limit' => $limit,
		])->execute()->fetchAll();
	}

	public function cityCheck($country, $region, $city) {
		$this->loadQuery('application/tender/common/modules/geo/sql/cityCheck.sql')->prepare([
			'country' => $country,
			'region' => $region,
			'city' => $city,
		])->execute()->fetchAll();
		if ($this->count === 0) {
			return 'unknown city';
		} else {
			return TRUE;
		}
	}
}
