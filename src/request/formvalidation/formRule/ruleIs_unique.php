<?php 
namespace Src\request\formvalidation\formRule;
use FormRule;
use PDO;

class RuleIs_unique extends FormRule{
	
	private $data = '';


	function __construct($data){
		parent::__construct($data);
		$this->data = $data;
	}

	public function run($perameter = ''){
		$pera1 = '';
		$pera2 = '';
		if (empty($perameter[2]) === false AND empty($perameter[3]) === false) {
			$pera1 = $perameter[2];
			$pera2 = $perameter[3];
		}
		
		return $this->query($perameter[0], $perameter[1], $pera1, $pera2);
	}


	public function message(){
		return '{field} must be an unique value.';
	}

	public function query($tbl, $row, $withOutRow = '', $withOutThis = ''){
		$query = '';
		if (empty($withOutThis) === false AND empty($withOutRow) === false) {
			$query = " AND `".$withOutRow."` != :withOutThis";
		}

	
		$data = DB()->prepare("SELECT COUNT(*) FROM `".$tbl."` WHERE `".$row."` = :data ".$query );
		if (is_numeric($this->data) === true) {
			$data->bindValue( ":data", $this->data, PDO::PARAM_INT);

			if (empty($withOutThis) === false AND empty($withOutRow) === false) {
				$data->bindValue( ":withOutThis", $withOutThis, PDO::PARAM_INT);
			}

		}else{
			$data->bindValue( ":data", $this->data, PDO::PARAM_STR);
			if (empty($withOutThis) === false AND empty($withOutRow) === false) {
				$data->bindValue( ":withOutThis", $withOutThis, PDO::PARAM_STR);
			}
		}
		$data->execute();
		$count = $data->fetchColumn();
		return ($count == 1) ? false : true;
	}

}