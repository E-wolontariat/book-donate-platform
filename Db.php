<?php
class Db{
	var $DbHost;
	var $DbUser;
	var $DbPass;
	var $DbName;
	var $DbPrefix;
	var $DbH;
	var $DbQuery;
	function __construct($DbHost, $DbUser, $DbPass, $DbName, $DbPrefix){
		$this->DbHost = $DbHost;
		$this->DbUser = $DbUser;
		$this->DbPass = $DbPass;
		$this->DbName = $DbName;
		$this->DbPrefix = $DbPrefix;		
	}
	function dbConnect(){
		$error = 0;
		$this->DbH = @mysql_connect($this->DbHost, $this->DbUser, $this->DbPass);
		if (!$this->DbH)
			$error = 1;
		else
			@mysql_select_db($this->DbName, $this->DbH) or $error = 2;
		return $error;
	}
	function dbQuery($query){
		$this->DbQuery = mysql_query($query);
	}
	function dbFetchArray(){
		$t = mysql_fetch_array($this->DbQuery);
		return $t;
	}
	function dbSelect($table, $select=NULL, $where=NULL, $sort=NULL, $sortCol=NULL, $limit=NULL){
		if(is_null($select))
			$select="*";
		$query="SELECT ".$select." FROM ".$this->DbPrefix.$table;
		if(!is_null($where))
			$query .= " WHERE ".$where;
		if(!(is_null($sort) || is_null($sortCol)))
			$query .= " ORDER BY ".$sortCol." ".$sort;
		if(!is_null($limit))
			$query .= " LIMIT ".$limit;
		$this->DbQuery = mysql_query($query);
	}
	function dbSelectID($table, $select=NULL, $id){
		if(is_null($select))
			$select="*";
		$query="SELECT ".$select." FROM ".$this->DbPrefix.$table." WHERE id=".$id;
		$this->DbQuery = mysql_query($query);
	}
	function dbDelete($table, $where = NULL){
		$query = "DELETE FROM ".$this->DbPrefix.$table;
		if(!is_null($where))
			$query .= " WHERE ".$where;
		$this->DbQuery = mysql_query($query);
	}
	function dbDeleteId($table, $id){
		$query = "DELETE FROM ".$this->DbPrefix.$table." WHERE id=".$id;
		$this->DbQuery = mysql_query($query);
	}
	function dbUpdate($table, $set, $where = NULL){
		$query = "UPDATE ".$this->DbPrefix.$table." SET ".$set;
		if(!is_null($where))
			$query .= " WHERE ".$where;
		$this->DbQuery = mysql_query($query);
	}
	function dbUpdateId($table, $set, $id){
		$query = "UPDATE ".$this->DbPrefix.$table." SET ".$set." WHERE id=".$id;
		$this->DbQuery = mysql_query($query);
	}
	function dbInsert($table, $values, $cols=NULL){
		$query = "INSERT INTO ".$this->DbPrefix.$table;
		if(!is_null($cols))
			$query .= " (".$cols.")";
		$query .= " VALUES (".$values.")";
		$this->DbQuery = mysql_query($query);
	}
	function dbNumRows(){
		$t = mysql_num_rows($this->DbQuery);
		return $t;
	}
	function clearText($text){
		//TODO
		//db protection (sql injection, etc)
		return $text;
	}
}
?>