<?php 
namespace Controller;
use Controller;
use User;
use Role;

class Maincontroller extends Controller {
	private $user;

	function __construct(){
		parent::__construct();
		$this->user = new User();
	}

	public function index($route, $perameter){
		Role::currentUserCan('view_site');
		echo 'WellCome to our website';
	}
}