<?php 
function DB(){
	return $GLOBALS['database_conn'];
}

function Route(){
	return new Src\route\Route();
}

function User(){
	return (new Model\user\User())->current_user();
}
function Redirect(){
	return new Src\request\Redirect();
}

function sanitize_url($url){
	return preg_replace('/^(http(s)?)?:?\/*/u','http$2://',trim($url));
}

function sanitize_text($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function View($file, $data = ['val' => null]){
	return (new Controller\Controller())->view($file, $data);
}
function config($option, $file = 'config'){
	return Src\Config::get($option, $file);
}

function sanitize_email($email){
	return filter_var($email, FILTER_SANITIZE_EMAIL);
}

function configSet($option, $value, $file = 'config'){
	return Src\Config::set($option, $value, $file);
}

function root_url($path = ''){
	$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/'.$path;
	return $root;
}


function assets_url($path = ''){
	return url('index').'assets/'.$path;
}

function alert_box(){
if (empty($_SESSION['alart_message']) === true) {
	return false;
}
?>
<div class="alert alert-<?php echo $_SESSION['alart_type']; ?> alert-dismissible fade show" role="alert">
  <?php echo $_SESSION['alart_message']; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<?php
unset($_SESSION['alart_message']);
unset($_SESSION['alart_type']);
}

function add_alaer_box_message($message, $type = 'success'){
	$_SESSION['alart_message'] = $message;
	$_SESSION['alart_type'] 	= $type;
}

function csrf_token($name = ''){
	$name = 'csrf_token_'.$name;
	if (empty($_SESSION[$name]) === true) {
	    $_SESSION[$name] = bin2hex(random_bytes(32));
	}
	return $_SESSION[$name];
}

function verifying_csrf_token($name, $value){
	$name = 'csrf_token_'.$name;
	if (empty($_SESSION[$name]) === true) {
		return false;
	}
	if (hash_equals($_SESSION[$name], $value)) {
		unset($_SESSION[$name]);
        return true;        
	}
	unset($_SESSION[$name]);
	return false;
}

function add_error($name, $msg){
	$_SESSION['form']['error'][$name] = $msg;
}

function get_error($name){
	if (empty($_SESSION['form']['error'][$name]) === false) {
		return $_SESSION['form']['error'][$name];
	}else{
		return false;
	}	
}

function resetForm(){
	unset($_SESSION['form']);	
}

function field_data($name){
	return (empty($_SESSION['form']['data'][$name]) === false) ? $_SESSION['form']['data'][$name] : '' ;
}

function url($name, $data = []){
	return root_url((new Src\route\Route())->url($name, $data));
}

function is_email($email){
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	  return true;
	} 
	return false;
}