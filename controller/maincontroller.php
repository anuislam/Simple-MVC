<?php 
namespace Controller;
use Controller\Controller;

class Maincontroller extends Controller
{
	
	function __construct(){
		parent::__construct();
	}

	public function index($route, $perameter){
		$this->view('example');
	}
}