<?php
/**
 * PHP SETTINGS
 */
ini_set('error_reporting', E_ALL);
ini_set('memory_limit', '128M');
set_time_limit('5');
date_default_timezone_set('UTC');
//date_default_timezone_set('Europe/Kiev');
//date_default_timezone_set(timezone_name_from_abbr('', 0 * 3600, FALSE));
//set_error_handler('catch_error');
//register_shutdown_function('catch_fatal_error');
/**
 * VENDOR AUTOLOAD
 */
require('../vendor/autoload.php');
/**
 * FA AUTOLOAD
 */
//require('../vendor/fa/autoload.php');
/**
 * APPLICATION AUTOLOAD
 */
//include('../tender/autoload.php');
/**
 * APPLICATION RUN
 */
define('FA_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
\fa\core\faf::run(\tender\Application::class);
