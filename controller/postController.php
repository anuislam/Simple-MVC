<?php 
namespace Controller;
use Controller\Controller;

class PostController extends Controller
{
	
	function __construct(){
		parent::__construct();
	}

	public function single($route, $data){
		echo 'this is our post id '. $data[0];
	}
}