<?php 
namespace Src\request\formvalidation\formRule;
use FormRule;

class RuleUrl extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){
		$value = filter_var($this->data, FILTER_VALIDATE_URL);
		if (empty($value) === false) {
			return true;
		}
		return false;
	}


	public function message(){
		return '{field} must be a valid URL.';
	}

}