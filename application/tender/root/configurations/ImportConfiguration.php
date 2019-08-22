<?php

namespace tender\root\configurations;

use fa\classes\Configuration;

class ImportConfiguration extends Configuration {

	public static $map = [
		'continent' => [
			'tip' => 'Continen',
			'routeAlias' => '/import_geo/continent',
			'getItem' => 'continent/getGeoItem.sql',
			'getTotalItems' => 'continent/getTotalItems.sql',
			'checkUniqueItem' => 'continent/checkUniqueItem.sql',
			'addItem' => 'continent/addItem.sql',
		],
		'country' => [
			'tip' => 'Country',
			'routeAlias' => '/import_geo/country',
			'getItem' => 'country/getGeoItem.sql',
			'getTotalItems' => 'country/getTotalItems.sql',
			'checkUniqueItem' => 'country/checkUniqueItem.sql',
			'addItem' => 'country/addItem.sql',
		],
		'region' => [
			'tip' => 'Region',
			'routeAlias' => '/import_geo/region',
			'getItem' => 'region/getGeoItem.sql',
			'getTotalItems' => 'region/getTotalItems.sql',
			'checkUniqueItem' => 'region/checkUniqueItem.sql',
			'addItem' => 'region/addItem.sql',
		],
		'division' => [],
		'timezone' => [],
		'city' => [],
	];
}
