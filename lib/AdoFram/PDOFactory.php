<?php
namespace AdoFram;

class PDOFactory {
	
	public static function getMysqlConnexion() {
		
		$db = new \PDO('mysql:host=localhost;dbname=id9504489_adofram', 'id9504489_grandchef', 'LoZelda_64');
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
		return $db;
	}
}