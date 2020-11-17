<?php 
namespace Src\middleware;
use User;
/**
 * login Check Middleware
 */
class GuestMiddleware
{
	
	public function handle(){
		$user = new User();
		$user->for_logout_user();
	}

}