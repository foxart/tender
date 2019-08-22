<?php

namespace tender\purchaser\modules\po\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class PoModel extends SqlModel {

	public static $instance;
	public static $path = 'modules/sql/';
	public static $connection = DefaultConnection::class;

	protected function rules() {
		return [];
	}
}
