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
		$this->whereStatement = $sqlWhere;
		return $this;
	}
	
	public function delete($table)
	{
		$table = inflector(strtolower($table));
		$st = $this->con->prepare("DELETE FROM $table WHERE ".$this->whereStatement);
		if(!$st)
		{
			trigger_error("MySQL Adapter Error in Delete. Error Info: ".print_r($st->errorInfo()),E_USER_ERROR);
			die();
		}
		$st->execute() or trigger_error("MySQL Adapter in Delete: ".print_r($st->errorinfo()),E_USER_ERROR);
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