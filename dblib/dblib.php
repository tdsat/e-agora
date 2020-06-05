<?php
	
/**
 * Database Utilities Class
 */
class DBLib {

	const DB_HOST = "localhost";
	const DB_DATABASE = "agoradb";
	const DB_USERNAME = "root";
	const DB_PASSWORD = NULL;
	
	static $dblink = NULL;
		
    public static function open(){
		if (self::$dblink == NULL){    	
			self::$dblink = mysql_connect(self::DB_HOST, self::DB_USERNAME, self::DB_PASSWORD);
			if (!self::$dblink) {
			    die('Could not connect: ' . mysql_error());
			}
			mysql_query("set names utf8");
			@mysql_select_db(self::DB_DATABASE, self::$dblink) or die( "Unable to select database");
		}
    }
	
	public static function close(){
		if (self::$dblink != NULL){
			mysql_close(self::$dblink);				
		}
	}
	
	public static function execute_query($query){
		self::open();
		$result=mysql_query($query);
		if (!$result){
			die('Invalid query: ' . mysql_error());
		}
		return $result;		
	}

	public static function execute_query_auto($query, &$lastid){
		self::open();
		$result=mysql_query($query);
		if (!$result){
			die('Invalid query: ' . mysql_error());
		}
		$lir = mysql_query("SELECT LAST_INSERT_ID()");
  		$lastid = mysql_result($lir,0,0);
		return $result;		
	}
	
	public static function getresult($query, $colid = 0){
		self::open();
		$result=mysql_query($query);
		if (!$result){
			die('Invalid query: ' . mysql_error());
		}
		$num=mysql_numrows($result);
		if ($num > 0){
			$res = mysql_result($result,0,$colid);
		}else{
			$res = FALSE;
		}
		return $res;
	}
	
	public static function getrows($query, &$rows, &$num){
		self::open();
		$rows=mysql_query($query);
  		$num=mysql_numrows($rows);
	}
	
	public static function showresultfields($result){
		if ($row = mysql_fetch_object($result)) {
			$count = 0;
			echo "result fields: [";
			foreach($row as $key => $value) {
				if ($count > 0){
					echo ", ";
				}
				echo $key;
 				$count++;
			}
			echo "]<br>\n";
    		mysql_data_seek($result, 0);
		}
	}
	
}

?>
