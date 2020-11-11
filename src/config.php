<?php
namespace Src;
/**
 * config managment
 */
class Config{
	
	function __construct(){
	}

	public static function get($option, $file = 'config'){

		$location = APP_PATH.'/config/';

		if (empty(@$GLOBALS['site_config'][$file][$option]) === false) {
			$conf = $GLOBALS['site_config'][$file];
		}else{
			$conf = require_once($location.$file.'.php');
		}
		return $conf[$option];
	}


	public static function set($option, $val, $file = 'config'){
		$GLOBALS['site_config'][$file][$option] = $val;
	}

}