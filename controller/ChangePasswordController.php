<?php 
namespace Controller;
use Controller;
use User;
use Validation;
use Role;

class ChangePasswordController extends Controller
{
	
	function __construct(){
		parent::__construct();		
		$this->user = new User();
	}

	public function ChangePassword($route){

		Role::currentUserCan('edith_user');

		$page_data = [];
		$page_data['page_title'] = User()->fname.' '.User()->lname.'\'s Change Password.';
		$this->view('header', $page_data);
		$this->view('changePassword', $page_data);
		$this->view('footer', $page_data);
		resetForm();
	}
	public function ChangePasswordUpdate($route){

		Role::currentUserCan('edith_user');

		$var = new Validation($_POST);

		$var->check([
			'old_password' => [
				'validation' => 'Required'
			],
			'new_password' => [
				'validation' => 'Required'
			],
			'confirm_password' => [
				'validation' => 'Required|match-new_password'
			] 
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
		}else{
			if ($this->user->user_exists(User()->email, $_POST['old_password']) === false) {
				add_error('old_password', 'Wrong Password!');
			}else{
				if ($_POST['old_password'] != $_POST['confirm_password']) {
					$this->user->update([
						'password' => $this->user->make_password($_POST['confirm_password'])
					], [
						'ID' => User()->ID,
						'email' => User()->email
					]);
				}
				add_alaer_box_message('Password change successful.');
				resetForm();
			}
		}
		Redirect()->back();
	}

}