<?php 
use Src\Config;
use Src\route\Dispatch;
use Src\route\Route;

require_once(APP_PATH.'/route.php');



(new Dispatch())->run();