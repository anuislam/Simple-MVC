<?php 
namespace Controller;
use Controller;
use User;

class Page404Controller extends Controller{
		private $user;
	function __construct(){
		parent::__construct();	

		$this->user = new User();
	}

	public function page404(){
		$this->user->for_logged_in_user();
		$page_data = [];
		$page_data['page_title'] = '404 not found';		
		$page_data['page_content_title'] = '404';
		$page_data['page_content'] = 'Page Not Found';

		$this->view('header', $page_data);
		$this->view('error/404Error', $page_data);
		$this->view('footer', $page_data);
		resetForm();
	}

	public function page405(){
		$this->user->for_logged_in_user();
		$page_data = [];
		$page_data['page_title'] = '405 Method Not Allowed';
		$page_data['page_content_title'] = '405';
		$page_data['page_content'] = 'Method Not Allowed';
		$this->view('header', $page_data);
		$this->view('error/404Error', $page_data);
		$this->view('footer', $page_data);
		resetForm();
	}

}