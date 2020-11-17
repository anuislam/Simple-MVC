<?php 
namespace Model\db;
use pdo;
/**
 * Database connection
 */
class Dbconnect{
	



	public function db(){
		$db = '';
		$dbhost = config('dbhost', 'db');
		$dbname = config('dbname', 'db');
		$dbusername = config('dbusername', 'db');
		$dbpassword = config('dbpassword', 'db');
		try {
			$db = new pdo('mysql:host='.$dbhost.';dbname='.$dbname, $dbusername, $dbpassword);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
		} catch (PDOException $e) {
			die('Database error');
		}

		$GLOBALS['database_conn'] = $db;
	}

	public function close(){
		unset($GLOBALS['database_conn']);
	}
}



