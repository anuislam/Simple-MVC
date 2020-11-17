<?php 
namespace Src\request;
/**
 * Redirect
 */
class Redirect
{
	
	function __construct(){
		
	}

	public function back(){
		$back = $_SERVER['HTTP_REFERER'];
		$back = ltrim($back, '/');
		header("Location: $back", TRUE, 301);
		die();
	}

	public function url($name = 'index', $data = ''){
		header("Location: ".url($name, $data), TRUE, 301);
		die();
	}

	public function Refresh(){
		header("Refresh: 0");
		die();
	}
}