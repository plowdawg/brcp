<?php
/*This is just an abstract class for these to follow*/

class Model
{
	private $errors = array();
	private $beforeFilters = array();
	public $accessibleAttributes = array();
	protected $avalibleAttributes = array();
	public function __construct()
	{
		$this->name = $this->establishName();
		$this->connectToDatabase();
		$this->establishFieldsFromDb();
	}
	
	public function all()
	{	
		return $returnedValues = $this->dbcon->all($this->name);
	}
	
	public function addError($error)
	{
		array_push($this->errors,$error);
	}
	
	public function getErrors()
	{
		return $this->errors;
	}
	
	public function save()
	{
		//we don't need the id so...
		$this->dbcon->save(array_slice($this->avalibleAttributes,1),$this->name);
	}
	
	public function where($whereStmt)
	{
		$this->dbcon = $this->dbcon->where($whereStmt);
		return $this;
	}
	
	public function delete()
	{
		$this->dbcon->delete($this->name);
	}
	
	public function addBeforeFilter($filter)
	{
		array_push($this->beforeFilters,$filter);
	}
	
	private function connectToDatabase()
	{
		global $config;
		require_once("../modules/".$config["database_adapter_module"].".php");
		$this->dbcon = new DBModule();
	}
	private function establishName()
	{
		/*echo "<pre>";
			print_r(debug_backtrace());
		echo "</pre>";*/
		$callers = debug_backtrace();
		$object = get_class($callers[0]["object"]);
		return $object;
	}
	
	public function execute()
	{
		return $this->dbcon->execute($this->name);
	}
	
	private function  establishFieldsFromDb()
	{
		$fields = $this->dbcon->getColumnNames($this->name);
		$this->establishAvalibleFields($fields);
	}
	private function establishAvalibleFields($fieldsArray)
	{
		foreach($fieldsArray as $field)
		{
			$this->avalibleAttributes[$field[0]]=null;
		}
	}
}

?>