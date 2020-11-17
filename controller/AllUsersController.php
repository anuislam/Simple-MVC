<?php 
namespace Controller;
use Controller;
use User;
use Validation;
use Role;

class AllUsersController extends Controller
{
	private $user;
	function __construct(){
		parent::__construct();
		$this->user = new User();		
	}

	public function allUsers($route){
		Role::currentUserCan('edith_other_user');
		$page_data = [];
		$page_data['page_title'] 	=  'Allemployees profile';
		$page_data['emple_get'] 	=  $this->user->getAll();

		$this->view('header', $page_data);
		$this->view('allUsers', $page_data);
		$this->view('footer', $page_data);
		resetForm();
	}

}
//allemployees