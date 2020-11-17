<?php 
namespace Model\user;
use DB;
use PDO;
/**
 * User management
 * require database file
 */
class User{

	private $tbl;
	private $prefix;


	function __construct(){
		$this->prefix = config('prefix', 'db');
		$this->tbl = 'user';
	}
	public function user_exists($email, $password){
		$tbl = $this->prefix.'user';

		$data = DB()->prepare("SELECT * FROM `".$tbl."` WHERE `email` = :email" );
		$data->bindValue( ":email", sanitize_email($email), PDO::PARAM_STR);
		$data->execute();
		if ($data->rowCount() == 1) {
			$udata = $data->fetch(PDO::FETCH_ASSOC);
			
			if (password_verify($password, $udata['password']) === true) {
				return $udata;
			} 

		}
		return false;

	}


	public function log_out(){
		session_start();
		session_unset();
		session_destroy();
		ob_start();
		setcookie('user_info_ID', 'a', time() - 1, "/");
		setcookie('user_info_email', 'a', time() - 1, "/");
	}

	public function for_logged_in_user(){
		if ($this->logged_in_user() === false) {
			Redirect()->url('login');
		}
		$GLOBALS['current_user'] = $this->current_user_data();
	}


	public function current_user_data(){
		$tbl = $this->prefix.'user';
		if ($this->logged_in_user()) {
			$user = $this->logged_in_user();
			$data = DB()->prepare("SELECT * FROM `".$tbl."` WHERE `email` = :email AND `ID` = :ID" );
			$data->bindValue( ":email", sanitize_email($user['email']), PDO::PARAM_STR);
			$data->bindValue( ":ID", (int)$user['ID'], PDO::PARAM_INT);
			$data->execute();
			$udata = $data->fetch(PDO::FETCH_OBJ);
			unset($udata->password);
			return $udata;
		}

		return false;
	}


	public function for_logout_user(){
		if ($this->logged_in_user()) {
			Redirect()->url();
		}
	}


	public function logged_in_user(){
		$cookie = 1;
		$val = [];

		if (empty($_COOKIE['user_info_id']) === false AND isset($_COOKIE['user_info_id']) === true) {
			$val['ID'] = $_COOKIE['user_info_id'];
			$cookie++;
		}

		if (empty($_COOKIE['user_info_email']) === false AND isset($_COOKIE['user_info_email']) === true) {
			$val['email'] = $_COOKIE['user_info_email'];
			$cookie++;
		}

		if ($cookie == 3) {
			return $val;
		}

		if (empty($_SESSION['user_info']) === false AND isset($_SESSION['user_info']) === true) {		
			return $_SESSION['user_info'];
		}

		return false;

	}


	public function login_start($user, $remember_me){
		$_SESSION['user_info']['email'] = $user['email'];
		$_SESSION['user_info']['ID'] 	= $user['ID'];
		if ($remember_me === true) {
			$cookie_id = "user_info_id";
			$cookie_email = "user_info_email";
			$cookie_value_id = $user['ID'];
			$cookie_value_email = $user['email'];
			setcookie($cookie_id, $cookie_value_id, time() + (86400 * 30), "/"); // 86400 = 1 day
			setcookie($cookie_email, $cookie_value_email, time() + (86400 * 30), "/"); // 86400 = 1 day
		}
	}

	public function current_user(){
		return $GLOBALS['current_user'];
	}


	function email_exists($email){
		$tbl = $this->prefix.'user';
		$data = DB()->prepare("SELECT * FROM `".$tbl."` WHERE `email` = :email" );
		$data->bindValue( ":email", sanitize_email($email), PDO::PARAM_STR);
		$data->execute();
		if ($data->rowCount() == 1) {
			return true;
		}
		return false;
	}

	public function join($value){		
		return (new DB())->insert($this->tbl, $value);
	}

	public function update($value, $where){
		return (new DB())->update($this->tbl, $value, $where);
	}

	public function delete($where){
		return (new DB())->delete($this->tbl, $where);
	}

	public function getAll(){
		$tbl = $this->prefix.'user';
		$q = DB()->prepare( "SELECT * FROM `$tbl` WHERE `ID` != :UID" );
		$q->bindValue( ":UID", User()->ID, PDO::PARAM_INT);
		$q->execute();		
		return $q->fetchAll(PDO::FETCH_CLASS);
	}

	public function defaultRole(){
		return config('defaultRole');
	}

	public function user_by_ID($user_id){
		$user = new DB();
		$user = $user->getdata($this->tbl, ['ID' => $user_id], true, 0, 1);
		return (empty($user[0]) === false) ? $user[0] : null ;
	}

	public function user_by_email($email){
		$user = new DB();
		$user = $user->getdata($this->tbl, ['email' => $email], true, 0, 1);
		return (empty($user[0]) === false) ? $user[0] : null ;
	}



	public function is_email($email){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  return true;
		} 
		return false;
	}

	public function make_password($password){
		return password_hash($password, PASSWORD_DEFAULT);
	}

	public function passwordResetRequestExists($email, $token){
		$tbl = $this->prefix.'password_reset';
		$q = DB()->prepare("SELECT * FROM `$tbl` WHERE `email` = :email AND `token` = :token");
		$q->bindValue( ":email", $email, PDO::PARAM_STR);
		$q->bindValue( ":token", $token, PDO::PARAM_STR);
		$q->execute();
		if ($q->rowCount() == 1) {
			$data = $q->fetch(PDO::FETCH_OBJ);

			$timestamp 		= date("YmdHis");
			$databasetime	= date('YmdHis', strtotime($data->exp_life));
			if ((int) $timestamp < (int) $databasetime) {
				return true;
			}
	
		}
		return false;

	}


}
