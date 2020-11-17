<?php 
namespace Controller;
use Controller;
use Route;
use User;
use Validation;
use Role;

class ProfileController extends Controller
{
	private $user;
	function __construct(){
		parent::__construct();	

		$this->user = new User();
	}

	public function edithProfile($route){
		Role::currentUserCan('edith_user');

		$page_data = [];
		$page_data['edithUserData'] = $this->editUserData();
		$page_data['page_title'] = $page_data['edithUserData']->fname.' '.$page_data['edithUserData']->lname.'\'s profile.';

		$this->view('header', $page_data);
		$this->view('edithProfile', $page_data);
		$this->view('footer', $page_data);
		resetForm();
	}	

	public function editUserData($id = ''){
		if (empty($id) === true) {
			return User();
		}else{
			return $this->user->user_by_ID($id);
		}
	}

	public function updateProfile($route){

		Role::currentUserCan('edith_user');


		$var = new Validation($_POST);

		$var->check([
			'profile_picture' => [
				'validation' => 'Required|Url'
			],
			'first_name' => [
				'validation' => 'Required|Min-3|Max-20'
			],
			'last_name' => [
				'validation' => 'Required|Min-3|Max-20'
			],
			'email' => [
				'validation' => 'Required|Is_email|is_unique-as_user-email-ID-'.User()->ID
			],
			'mobile_number' => [
				'validation' => 'Required|Number|Min-10|Max-20'
			]
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
		}else{
			$this->user->update([
					'email' => sanitize_email($_POST['email']),
					'profile_pic' => sanitize_url($_POST['profile_picture']),
					'fname' => sanitize_text($_POST['first_name']),
					'lname' => sanitize_text($_POST['last_name']),
					'mobile' => sanitize_text($_POST['mobile_number']),
				],[
					'ID' => User()->ID
				] );
			add_alaer_box_message('Profile update successful.');
		}
		Redirect()->back();
	}



	public function edithProfileOther($route, $data){

		Role::currentUserCan('edith_user');
		
		$page_data = [];
		$page_data['edithUserData'] = $this->editUserData($data[0]);


		if (is_null($page_data['edithUserData']) === true) {
			add_alaer_box_message('User dose not exists!!', 'danger');
			Redirect()->url('edit-profile');
			die();
		}

		$page_data['page_title'] = $page_data['edithUserData']->fname.' '.$page_data['edithUserData']->lname.'\'s profile.';
		$page_data['editbleUser'] = ($route['name'] == 'edit-profile-other') ? '/'.$data[0] : '' ;

		if (Role::others(User(), $page_data['edithUserData'], 'edith_other_user') === false) {
			add_alaer_box_message('You have not permission to edit others profile.', 'danger');
			Redirect()->url();
			die();
		}



		$this->view('header', $page_data);
		$this->view('edithProfile', $page_data);
		$this->view('footer', $page_data);
		resetForm();
	}

	public function updateProfileOther($route, $data){

		Role::currentUserCan('edith_user');

		$edithUser = $this->user->user_by_ID($data[0]);

		if (is_null($edithUser) === true) {
			add_alaer_box_message('User dose not exists!', 'danger');
			Redirect()->url('edit-profile');
		}

		if (Role::others(User(), $edithUser, 'edith_other_user') === false) {
			add_alaer_box_message('You have not permission to edit others profile.', 'danger');
			Redirect()->url('edit-profile');
		}

		$var = new Validation($_POST);

		$var->check([
			'profile_picture' => [
				'validation' => 'Required|Url'
			],
			'first_name' => [
				'validation' => 'Required|Min-3|Max-20'
			],
			'last_name' => [
				'validation' => 'Required|Min-3|Max-20'
			],
			'email' => [
				'validation' => 'Required|Is_email|is_unique-as_user-email-ID-'.$data[0]
			],
			'mobile_number' => [
				'validation' => 'Required|Number|Min-10|Max-20'
			]
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
		}else{
			$this->user->update([
					'email' => sanitize_email($_POST['email']),
					'profile_pic' => sanitize_url($_POST['profile_picture']),
					'fname' => sanitize_text($_POST['first_name']),
					'lname' => sanitize_text($_POST['last_name']),
					'mobile' => sanitize_text($_POST['mobile_number']),
				],[
					'ID' => $data[0]
				] );
			add_alaer_box_message('Profile update successful.');
		}
		Redirect()->back();
		die();
	}

	public function deleteProfileOther($rouet, $data){

		if (Role::can(user()->role, 'delete_user') === false) {
			add_alaer_box_message('You have not permission to delete profile.', 'danger');
			Redirect()->back();
		}
		$deleteUser = $this->user->user_by_ID($data[0]);

		if (is_null($deleteUser) === true) {
			add_alaer_box_message('User dose not exists!', 'danger');
			Redirect()->back();
		}

		if (Role::others(User(), $deleteUser, 'delete_other_user') === false) {
			add_alaer_box_message('You have not permission to delete profile.', 'danger');
			Redirect()->back();
		}
		$this->user->delete([
			'ID' => $data[0]
		]);
		add_alaer_box_message('Delete user successful.');
		Redirect()->back();
	}
}