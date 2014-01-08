<?php

class DBModule
{
	public function __construct()
	{
		global $config;
		$this->con = new PDO("mysql:host=".$config["database_host"].";dbname=".$config["database_name"],$config["database_user_name"],$config["database_password"]);
	}
	public function save($array,$table)
	{
		$table = inflector(strtolower($table));
		$prepstring = "INSERT INTO $table (";
		$values = array();
		//die("<pre>".print_r($array)."</pre>");
		$keys = "";
		$questMarkString = "(";
		$counter = 0;
		foreach($array as $key=>$value)
		{
			if($counter != (count($array)-1))
			{
				$keys .= $key.", ";
				$questMarkString .= "?,";
			}
			else
			{
				$keys .= $key.") VALUES ";
				$questMarkString .= "?)";
			}
			array_push($values,$value);
			++$counter;
		}
		$st = $this->con->prepare($prepstring.$keys.$questMarkString);
		if(!$st)
		{
			trigger_error("MySQL Error in save info: ".$st->errorinfo(),E_USER_ERROR);
			die();
		}
		return $st->execute($values) or trigger_error("COULD NOT WRITE TO DB: ".print_r($st->errorinfo()),E_USER_ERROR);
	}
	
	public function all($table)
	{
		$table = inflector(strtolower($table));
		$st = $this->con->prepare("SELECT * FROM $table");
		$st->execute() or trigger_error("MySql Adapter Error in All: ".print_r($st->errorinfo()),E_USER_ERROR);
		return $st->fetchAll();
	}
	
	public function where($sqlWhere)
	{
		if(!is_array($sqlWhere))
		{
			trigger_error("Where statement must be an array");
		}
		if(!isset($this->whereStatement))
		{
			$this->whereStatement = "WHERE ";
		}
		$results = $this->where_statement_formater($sqlWhere);
		$this->whereStatement .= $results[0];
		return $this;
	}
	
	
	public function where_statement_formater($sqlWhere)
	{
		//returns array(string,array)  where string is a question marked string and array are all values
		
		if(!isset($this->whereValues)) $this->whereValues = array();
		$wherestmt = "";
		foreach($sqlWhere as $key=>$value)
		{
			$wherestmt .= " AND $key=?";
			array_push($this->whereValues,$value);
		}
		
		
		return [$this->sanitize_where_statement($wherestmt),$this->whereValues];
		
	}
	
	private function sanitize_where_statement($whereStmt)
	{
		$patterns = array();
		$patterns[0] = '/WHERE  AND/';
		$patterns[1] = '/^ AND/';
		$patterns[2] = '/WHERE WHERE/';
		$replacements = array();
		$replacements[0] = 'WHERE';
		$replacements[1] = "";
		$replacements[2] = $replacements[0];
		$whereStmt = preg_replace($patterns,$replacements,$whereStmt);
		return $whereStmt;
	}
	
	
	public function delete($table)
	{
		$table = inflector(strtolower($table));
		$st = $this->con->prepare("DELETE FROM $table ".$this->whereStatement,$this->whereValues);
		if(!$st)
		{
			trigger_error("MySQL Adapter Error in Delete. Error Info: ".print_r($st->errorInfo()),E_USER_ERROR);
			die();
		}
		$st->execute() or trigger_error("MySQL Adapter in Delete: ".print_r($st->errorinfo()),E_USER_ERROR);
	}
	
	public function execute($table)
	{
		if(!isset($this->whereStatement))
		{
			trigger_error("No where statement set");
		}
		
		$table = inflector(strtolower($table));
		$st = $this->con->prepare("SELECT * FROM $table ".$this->whereStatement);
		for($i = 0; $i < count($this->whereValues); $i++)
		{
			$st->bindParam($i+1,$this->whereValues[$i]);
		}
		$st->execute() or trigger_error("MySql Adapter Error in All: ".print_r($st->errorinfo()),E_USER_ERROR);;
		return $st->fetchAll()[0];
	}
	
	public function getColumnNames($table)
	{
		$table = inflector(strtolower($table));
		$prepstring = "SELECT column_name FROM information_schema.columns WHERE table_name = '$table'";
		//echo "SQL STATEMENT IS: ".$prepstring;
		$st = $this->con->prepare($prepstring);
		if(!$st)
		{
			trigger_error("MySQL Adapter Error in getColumnNames. Error Info: ".print_r($st->errorInfo()),E_USER_ERROR);
			die();
		}
		$st->execute();
		$columnNames = $st->fetchAll();
		return $columnNames;
	}
	
}

?>