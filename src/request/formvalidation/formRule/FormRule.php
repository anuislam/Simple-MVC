<?php 
namespace Src\request\formvalidation\formRule;

class FormRule {
	
	private $replaceMessage;

	function __construct($data){
		$this->replaceMessage = false;
	}

	public function message(){
		return false;
	}

	public function run($perameter = ''){
		return false;
	}
	public function get_error($field, $condition){
		if ($this->replaceMessage) {
			return $this->replaceMessage;
		}
		$replace = $this->message();
		$replace = str_replace('{field}', ucfirst($field), $replace);
		$replace = str_replace(['-', '_', '#', '@'], ' ', $replace);
		return $replace;
	}

	public function replaceMessage($Message){
		if (empty($Message) === false) {
			$this->replaceMessage = $Message;
		}
		return false;
	}
}