<?php 
namespace Model\user;

/**
 * User role management
 */
class Role{
	
	// function __construct(){
	// 	# code...
	// }

	static function can($role, $permission){
		$roleCheck = self::permission();
		$roleCheck = (empty($roleCheck[$role]) === false) ? $roleCheck[$role] : '' ;
		if ($roleCheck == 'all') {
			return true;
		}
		if (empty($roleCheck[$permission]) === true) {
			return false;
		}
		if ($roleCheck[$permission] === true) {
			return true;
		}
		unset($roleCheck);
		return false;
	}

	static function others($currentUser, $otherUser, $permission){
		if ($otherUser->role == "administrator") {
			return false;
		}
		if ((int)$currentUser->ID != (int)$otherUser->ID ) {
			if (self::can($currentUser->role, $permission) === false) {
				return false;
			}
		}		

		return true;
	}

	private static function permission(){
		return [
			'administrator' => 'all',
			'admin' 		=> [
				'view_site' 		=> true,				
				'edith_user' 		=> true,
				'add_new_user' 		=> true,
				'edith_other_user' 	=> true,
				'delete_user' 		=> true,
				'delete_other_user' => true,
				'manage_shop' 		=> true,
				'delete_shop' 		=> true,
				'make_cotation' 	=> true,
				'delete_cotation' 	=> true,
				'make_invoice' 		=> true,
				'delete_invoice' 	=> true,
			],
			'worker' => [
				'view_site' => true,
				'edith_user' => true,
			]
		];
	}

	static function currentUserCan($permission, $route = '') {
		self::can(User()->role, $permission) === false ? Redirect()->url($route) : '' ;		
	}
}