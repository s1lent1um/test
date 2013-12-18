<?php
/**
 * Created by silentium
 * Date: 12.12.13
 * Time: 19:01
 */

function autoload($classname) {
	$classname = explode('\\', $classname);
	$classname = end($classname);
	include $classname . '.php';
}

defined('DATE_SQL') or define('DATE_SQL', 'Y-m-d H:i:s');

date_default_timezone_set('Europe/Moscow');
set_include_path(__DIR__ . PATH_SEPARATOR . get_include_path());
spl_autoload_register('autoload');