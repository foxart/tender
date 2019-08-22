<?php

namespace fa\classes;

use fa\core\faf;

abstract class Controller implements ControllerInterface {

	public final function actionIndex() {
		return faf::debug()->dump(json_encode($this, JSON_PRETTY_PRINT), FALSE);
	}

	public final function outputIndex() {
		return faf::debug()->dump($this, FALSE);
	}
}
