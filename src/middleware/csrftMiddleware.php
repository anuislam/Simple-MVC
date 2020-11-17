<?php 
namespace Src\middleware;
use User;
use ErrorPage;
/**
 * login Check Middleware
 */
class CsrftMiddleware
{
	
	public function handle(){
		$errorPage = new ErrorPage();
		$token = (empty($_POST['csrf_token']) === false) ? $_POST['csrf_token'] : '4545sds' ;
		if (verifying_csrf_token('csrf_token', $token) === false) {
		    header($_SERVER["SERVER_PROTOCOL"]." 405 Method Not Allowed", true, 405);
		    $errorPage->page405();
		    exit;
		}
	}

}