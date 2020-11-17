<?php 
namespace Src\request\formvalidation\formRule;
use FormRule;

class RuleNumber extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){
		if (is_numeric($this->data) === true) {
			return true;
		}
		return false;
	}


	public function message(){
		return '{field} must be a number.';
	}

}