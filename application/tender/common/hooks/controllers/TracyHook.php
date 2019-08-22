<?php

namespace tender\common\hooks\controllers;

use fa\classes\Controller;
use fa\core\faf;
use tender\common\hooks\models\MysqlDefaultModel;
use Tracy\Debugger;

class TracyHook extends Controller {

	public function initialize($showBar = FALSE) {
		if (faf::io()->checkDirectory(faf::$configuration['paths']['storage'] . 'tracy/') === FALSE) {
			faf::io()->createDirectory(faf::$configuration['paths']['storage'] . 'tracy/');
		};
//		\Tracy\Debugger::enable(\Tracy\Debugger::DETECT);
//		\Tracy\Debugger::enable(\Tracy\Debugger::DEVELOPMENT);
		Debugger::enable(Debugger::DETECT, faf::$configuration['paths']['storage'] . 'tracy/');
		Debugger::$showBar = $showBar;
		Debugger::$strictMode = TRUE;
		Debugger::$maxDepth = 0; // common: 3
		Debugger::$maxLength = 0; // common: 150
		Debugger::$showLocation = TRUE;
//		\Tracy\Debugger::$logSeverity = E_NOTICE | E_WARNING;
//		\Tracy\Debugger::$showLocation = \Tracy\Dumper::LOCATION_CLASS | \Tracy\Dumper::LOCATION_LINK;
//		\Tracy\OutputDebugger::enable();
//		\Tracy\Debugger::log('Unexpected error'); // text message
//		if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) { // AJAX request
//			\Tracy\Debugger::barDump('AJAX request');
//			if (!empty($_GET['error'])) {
//				this_is_fatal_error();
//			}
//			$data = [
//				rand(),
//				rand(),
//				rand(),
//			];
//			header('Content-Type: application/json');
//			header('Cache-Control: no-cache');
//			echo json_encode($data);
//			exit;
//		}
	}

	public function dumpMysqlDefaultConnections() {
		bdump(MysqlDefaultModel::instance()->getConnections());
	}

	public function dumpFaf() {
		bdump(faf::$faf);
	}

	public function dumpFafConfiguration() {
		bdump(faf::$configuration);
	}

	public function dumpFafInstances() {
		bdump(faf::instance()->getInstances());
	}

	public function dumpSession() {
		bdump(faf::session()->get());
	}
}


