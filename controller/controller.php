<?php 
namespace Controller;
/**
 * Parent Controller
 */
class Controller{
	
	function __construct()
	{
		# code...
	}

	public function view($file){
		require(APP_PATH.'/view/'.$file.'.php');
	}
}