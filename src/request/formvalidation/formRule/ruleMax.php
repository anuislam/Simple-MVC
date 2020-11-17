<?php 
namespace Src\request\formvalidation\formRule;
use FormRule;

class RuleMax extends FormRule{
	
	private $data = '';
	private $replaceMessage = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
		$this->replaceMessage = false;
	}

	public function run($perameter = ''){
		
		return mb_strlen($this->data) > (int)$perameter[0] ? false : true ;
	}


	public function message(){
		return '{field} must be a maximum of {$0}.';
	}


	public function get_error($field, $condition){
		$replace = $this->message();
		if ($this->replaceMessage) {
			return $this->replaceMessage;
		}
		$replace = str_replace('{field}', ucfirst($field), $replace);
		$replace = str_replace('{$0}', $condition[0], $replace);
		$replace = str_replace(['_','-','@'], ' ', $replace);
		return $replace;
	}

	public function replaceMessage($Message){
		if (empty($Message) === false) {
			$this->replaceMessage = $Message;
		}
		return false;
	}


}