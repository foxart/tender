<?php
/**
 * Created by PhpStorm.
 * User: ikosenko
 * Date: 24-03-2017
 * Time: 11:45
 */

namespace tender\common\hooks\models;

use fa\classes\SqlModel;
use tender\common\connections\DefaultConnection;

class MysqlDefaultModel extends SqlModel {

	public static $instance;
//	public static $path = 'common/hooks/sql/';
	public static $connection = DefaultConnection::class;

	public function rules() {
		// TODO: Implement rules() method.
	}

	public function getConnections() {
		return $this->loadQuery('application/tender/common/hooks/sql/getMysqlConnections.sql')->execute()->fetchRow();
	}
}

