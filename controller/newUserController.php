<?php 
namespace Controller;
use Controller;
use User;
use Validation;
use Role;

class NewUserController extends Controller
{
	private $user;
	function __construct(){
		parent::__construct();
		Role::currentUserCan('add_new_user');
		
		$this->user = new User();		
	}

	public function addNew($route){		
		$page_data = [];
		$page_data['page_title'] 	=  'Add new user';
		$this->view('header', $page_data);
		$this->view('addNewUser', $page_data);
		$this->view('footer', $page_data);
		resetForm();
	}

	public function addNewInsert($route){		

		$var = new Validation($_POST);
		$var->check([
			'profile_picture' => [
				'validation' => 'Required|Url'
			],
			'first_name' => [
				'validation' => 'Required|Max-15|Min-2'
			],
			'last_name' => [
				'validation' => 'Required|Max-15|Min-2'
			],
			'email' => [
				'validation' => 'Required|Is_email|is_unique-as_user-email',
				'message' 	 =>	[
					'is_unique' => 'This email already exists.'
				]
			],
			'password' => [
				'validation' => 'Required|Max-12|Min-5'
			],
			'confirm_password' => [
				'validation' => 'Required|Match-password'
			],
			'mobile_number' => [
				'validation' => 'Required|Number|Min-10|Max-15'
			]
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
		}else{
			$uid = $this->user->join([
					'email' 		=> sanitize_email($_POST['email']),
					'password' 		=> $this->user->make_password($_POST['confirm_password']),
					'profile_pic' 	=> sanitize_url($_POST['profile_picture']),
					'fname' 		=> ucfirst(sanitize_text($_POST['first_name'])),
					'lname' 		=> ucfirst(sanitize_text($_POST['last_name'])),
					'mobile' 		=> sanitize_text($_POST['mobile_number']),
					'role' 			=> $this->user->defaultRole(),
					'create_at' 	=> date("Y-m-d H:i:s")
				]);
			add_alaer_box_message('User create  successful.');
			redirect()->url('edit-profile-other', ['id' => $uid]);
		}
		redirect()->back();
	}

}
