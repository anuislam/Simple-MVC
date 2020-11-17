<?php 
namespace Src\request\formvalidation\formRule;
use FormRule;

class RuleIs_email extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){
		
		return filter_var($this->data, FILTER_VALIDATE_EMAIL) !== false;
	}


	public function message(){
		return '{field} must be a valid email address.';
	}

}