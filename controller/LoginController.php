<?php 
namespace Controller;
use Controller;
use User;
use Validation;
use Email;
use DB;

class LoginController extends Controller
{
	
	function __construct(){
		parent::__construct();		
	}

	public function login($route){
		$page_data = [];
		$page_data['page_title'] = 'LogIn Here.';

		$this->view('login/header', $page_data);
		$this->view('login/login', $page_data);
		$this->view('login/footer', $page_data);
		resetForm();
	}

	public function loginValidation($route){

		$var = new Validation($_POST);

		$var->check([
			'email' => [
				'validation' => 'Required|Is_email'
			],
			'password' => [
				'validation' => 'Required'
			] 
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
		}else{
			$Login = new User();
			$email = $_POST['email'];
			$password = $_POST['password'];

			$remember_me = (empty($remember_me) === true) ? true : false ;
			if ($Login->user_exists($email, $password) === false) {				
				add_alaer_box_message('User not exists!!', 'danger');
			}else{				
				$Login->login_start($Login->user_exists($email, $password), $remember_me);
				add_alaer_box_message('Login successful.');
				Redirect()->url();								
			}
		}
		Redirect()->back();

	}
	public function register($route){
		$page_data = [];
		$page_data['page_title'] = 'Registration Here.';

		$this->view('login/header', $page_data);
		$this->view('login/register', $page_data);
		$this->view('login/footer', $page_data);
		resetForm();
	}

	public function registerValidation($route){

		$var = new Validation($_POST);

		$var->check([
			'email' => [
				'validation' => 'Required|Is_email|is_unique-as_user-email',
				'message' 	 =>	[
					'is_unique' => 'This email already exists.'
				]
			],
			'password' => [
				'validation' => 'Required|Min-6|Max-12'
			],
			'confirm_password' => [
				'validation' => 'Required|Match-password'
			]
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
		}else{
			$email 		= sanitize_email($_POST['email']);
			$password 	= $_POST['password'];
			$user = new User();
			$uid = $user->join([
					'email' 	=> $email,
					'password' 	=> $user->make_password($password),
					'role' 		=> $user->defaultRole(),
					'create_at' => date("Y-m-d H:i:s"),
				]);
			$user->login_start([
				'email' => $email,
				'ID' => $uid,
			], false);

			add_alaer_box_message('Registration successful.');
			Redirect()->url();
		}

		Redirect()->back();

	}
	public function logout($route){
		(new User)->log_out();
		Redirect()->url('login');
	}

	public function forgotPassword($route){
		$page_data = [];
		$page_data['page_title'] = 'Forgot password.';
		$this->view('login/header', $page_data);
		$this->view('login/forgotPassword', $page_data);
		$this->view('login/footer', $page_data);
		resetForm();
	}

	public function forgotPasswordUpdate($route){
		$var = new Validation($_POST);

		$var->check([
			'email' => [
				'validation' => 'Required|Is_email',
			]
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
		}else{
			$email = sanitize_email($_POST['email']);
			$user = new User();
			$user = $user->user_by_email($email);
			if (is_null($user) === true) {
				add_error('email', 'Email dose not exists..');
			}else{

				(new DB())->delete('password_reset', [
					'email' 	=> $user->email
				]);


				$token = bin2hex(random_bytes(32));
				$timestamp = strtotime(date("Y-m-d H:i:s")) + 60*60;
				$time = date("Y-m-d H:i:s", $timestamp);
				$url = url('reset-password');
				$url .= '?email='.$user->email;
				$url .= '&token='.$token;

				(new DB())->insert('password_reset', [
					'email' 	=> $user->email,
					'token' 	=> $token,
					'exp_life' 	=> $time,
				]);


				$e = new Email();
				$e->to($user->email, $user->fname .' '. $user->lname);
				$e->subject('Forgot my password');
				$e->body('Forgot my password <br> <a href="'.$url.'" >'.$url.'</a>');
				$e->send();
				resetForm();
				add_alaer_box_message('Email send successful. Please check your email inbox..');
			}
		}
		Redirect()->back();
	}

	public function resetPassword($route){
		$email = (empty($_GET['email']) === false) ? sanitize_email($_GET['email']) : false ;
		;
		$token = (empty($_GET['token']) === false) ? $_GET['token'] : false ;
		if (ctype_xdigit($token) === false) {
			add_alaer_box_message('Invalid token!!');
			Redirect()->url('login');
		}
		$user = new User();
		if ($user->passwordResetRequestExists($email, $token) === false) {
			add_alaer_box_message('Invalid token!!','danger');
			Redirect()->url('login');
		}

		$page_data = [];
		$page_data['page_title'] = 'Reset password.';
		$page_data['email'] 	 = $email;
		$page_data['token'] 	 = $token;

		$this->view('login/header', $page_data);
		$this->view('login/resetPassword', $page_data);
		$this->view('login/footer', $page_data);
		resetForm();
	}


	public function resetPasswordUpdate($route){

	$var = new Validation($_POST);

		$var->check([
			'email' => [
				'validation' => 'Required|Is_email',
			],
			'new_password' => [
				'validation' => 'Required|Min-6|Max-12',
			],
			'confirm_password' => [
				'validation' => 'Required|Match-new_password',
			]
		]);

		if ($var->if_error()) {
			$errors = $var->get_error();
			foreach ($errors as $key => $value) {
				add_error($key, $value);
			}
		}else{
			$email = (empty($_POST['email']) === false) ? sanitize_email($_POST['email']) : false ;
			$token = (empty($_POST['token']) === false) ? $_POST['token'] : false ;
			$user = new User();
			$usr = $user->user_by_email($email);
			if (is_null($usr)) {
				add_alaer_box_message('Email dose not exists..', 'danger');
				Redirect()->back();
			}

			if (ctype_xdigit($token) === false) {
				add_alaer_box_message('Invalid token!!','danger');
				Redirect()->back();
			}

			if ($user->passwordResetRequestExists($email, $token) === false) {
				add_alaer_box_message('Invalid token!!','danger');
				Redirect()->back();
			}

			$user->update([
				'password' => $user->make_password($_POST['confirm_password'])
			], [
				'ID' => $usr->ID,
				'email' => $usr->email
			]);

			(new DB())->delete('password_reset', [
				'email' 	=> $usr->email
			]);
			resetForm();
			add_alaer_box_message('Password reset successful. You can login now.');
			Redirect()->url('login');
		}
		Redirect()->back();
	}

}