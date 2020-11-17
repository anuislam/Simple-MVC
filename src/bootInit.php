<?php
ob_start();
session_start();
if (config('debug') === true) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}else{
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(0);
}


require_once(APP_PATH.'/route.php');
require_once(APP_PATH.'/src/helpers/core.php');

load_aliases();

(new Dispatch())->run();