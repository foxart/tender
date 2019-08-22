<?php

namespace tender\purchaser\modules\overview\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class OverviewModel extends SqlModel {

	public static $instance;
	public static $path = 'modules/overview/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}
}
