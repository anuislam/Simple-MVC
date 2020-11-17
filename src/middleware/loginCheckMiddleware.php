<?php 
namespace Src\middleware;
use User;
/**
 * login Check Middleware
 */
class loginCheckMiddleware
{
	
	public function handle(){
		$user = new User();
		return $user->for_logged_in_user();
	}

}