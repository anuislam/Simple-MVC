<?php 
namespace Model\db;
use PDO;
/**
 * db crud
 */
class DB{
	
	private $tbl;
	private $tbl_prifix;
	private $where;

	function __construct(){
		$this->tbl_prifix = config('prefix', 'db');
		$this->count = false;
		$this->where = false;
	}

	public function insert($tablename, $val){
		$tablename = $this->tbl_prifix.$tablename;
		$val = (array)$val;
		$fieldname = [];
		$valueitems = '';
		if (is_array($val) === true) {
			foreach ($val as $valkey => $valvalue) {
				$fieldname[] = $valkey;
			}
		}

		$field  = '`';
		$field .= implode('`, `', $fieldname);			
		$field .= '`';
		$items  = ":";
		$items .= implode(", :", $fieldname);
		$mydb = DB()->prepare( "INSERT INTO `$tablename` ( $field ) VALUES ( $items ) ");
		if (is_array($val) === true) {
			foreach ($val as $valkey => $valvalue) {				
				if (is_numeric($valvalue) === true) {
					$mydb->bindValue( ":$valkey", $valvalue, PDO::PARAM_INT);
				}else{
					$mydb->bindValue( ":$valkey", $valvalue, PDO::PARAM_STR);
				}
			}
		}
		$mydb->execute();
		return DB()->lastInsertId();
	}



	public function update($tblname, $data, $tblwhere){
		$tblname = $this->tbl_prifix.$tblname;
		$query = "UPDATE `$tblname` SET ";
		$a1 = 0;		
		if (is_array( $data)) {
			foreach ( $data as $key => $value) {
				$datarcomma = ($a1 > 0) ? ", " : null ;
				$query .= "$datarcomma `$key` = :$key";
				$a1++;
			}			
		}	
		$query .= " WHERE ";
		$a2 = 0;
		if (is_array( $tblwhere)) {
			foreach ( $tblwhere as $tblwhkey => $tblwhvalue) {
				$whrcomma = ($a2 > 0) ? " AND " : null ;
				$query .= "$whrcomma `$tblwhkey` = :$tblwhkey";
				$a2++;
			}			
		}
		$updb = DB()->prepare( $query );	
		if (is_array( $data)) {
			foreach ( $data as $key => $value) {
				if (is_numeric($value) === true) {
					$updb->bindValue( ":$key", $value, PDO::PARAM_INT);
				}else{
					$updb->bindValue(  ":$key", $value, PDO::PARAM_STR);
				}
			}			
		}
		if (is_array( $tblwhere)) {
			foreach ( $tblwhere as $tblwhkey => $tblwhvalue) {
				if (is_numeric($tblwhvalue) === true) {
					$updb->bindValue( ":$tblwhkey", $tblwhvalue, PDO::PARAM_INT);
				}else{
					$updb->bindValue(  ":$tblwhkey", $tblwhvalue, PDO::PARAM_STR);
				};
			}			
		}

		$updb->execute();
	}



	public function getdata($tblname, $whereval = null, $opj = false, $offset = '', $limit = ''){
		$tblname = $this->tbl_prifix.$tblname;
		$query 	= "SELECT * FROM `$tblname`";
		if (is_array($whereval) === true) {
			$a1 = 0;
			$query 	.= "WHERE";
			foreach ($whereval as $key => $value) {
				$andval = ($a1 > 0) ? "AND" : null ;
				$query 	.= " $andval $key = :$key";
				$a1++;
			}
		}

		if (empty($limit) === false) {
			if (is_numeric($limit)) {
				$query .= " limit ".intval($limit);
			}
		}

		if (empty($offset) === false) {
			if (is_numeric($offset)) {
				$query .= " OFFSET ".intval($offset);
			}
		}

		$getdb 	= DB()->prepare( $query );	
		if (is_array($whereval) === true) {
			foreach ($whereval as $key => $value) {
				if (is_numeric($value) === true) {
					$getdb->bindValue( ":$key", $value, PDO::PARAM_INT);
				}else{
					$getdb->bindValue(  ":$key", $value, PDO::PARAM_STR);
				};
				
			}
		}
		
		$getdb->execute();
		if ($opj == true) {
			return $getdb->fetchAll(PDO::FETCH_CLASS);
		}else{
			return $getdb->fetchAll(PDO::FETCH_ASSOC);
		}
		
	}



	public function delete($tablename, $whereval){
		$tablename = $this->tbl_prifix.$tablename;
		$whereval = (array)$whereval;
		$a1 = 0;
		$query = "DELETE FROM `$tablename` WHERE ";
		if (is_array($whereval) === true) {
			foreach ($whereval as $whkey => $whvalue) {
				$andop = ($a1 > 0)? " AND " : null;
				$query .= "$andop `$whkey` = :$whkey";
				$a1++;
			}
		}
		$dldb = DB()->prepare( $query );
		if (is_array($whereval) === true) {
			foreach ($whereval as $whkey => $whvalue) {
				if (is_numeric($whvalue) === true) {
					$dldb->bindValue( ":$whkey", $whvalue, PDO::PARAM_INT);
				}else{
					$dldb->bindValue(  ":$whkey", $whvalue, PDO::PARAM_STR);
				}
			}
		}

		$dldb->execute();
	}


}