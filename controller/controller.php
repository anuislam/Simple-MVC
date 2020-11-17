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

	public function view($file, $data){
		
		echo $this->make_view($file, $data);
	}
	public function make_view($file, $data){
		extract($data);
		ob_start();	
		require(APP_PATH.'/view/'.$file.'.php');
		return ob_get_clean();
	}
}