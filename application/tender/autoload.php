<?php
spl_autoload_register(function ($name) {
	$class = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $name) . '.php';
	if (is_file($class)) {
		require_once($class);
	}
});
