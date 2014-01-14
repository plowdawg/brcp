<?php
/*This is just an abstract class for these to follow*/

class Model
{
	private $errors = array();
	private $beforeFilters = array();//[[filtername,args],...]
	private $afterFilters = array();
	public $accessibleAttributes = array();
	//protected $avalibleAttributes = array();
	public function __construct()
	{
		$this->name = $this->establishName();
		$this->connectToDatabase();
		$this->establishFieldsFromDb();
		if(func_num_args() > 0)
		{
			$set_values = func_get_args()[0][0];
			if(!is_array($set_values)) raise_error("Construct only takes an array.");
			$this->set($set_values);
		}
	}
	
	public function all()
	{	
		return $returnedValues = $this->dbcon->all($this->name);
	}
	
	public function add_error($error)
	{
		$this->errors=$error;
	}
	
	public function get_errors()
	{
		return $this->errors;
	}
	
	public function save()
	{
		if(!$this->execute_filters($this->beforeFilters))
		{ 
			return false;
		}
		$this->dbcon->save(array_slice($this->accessibleAttributes,1),$this->name);
		$this->execute_filters($this->afterFilters);
		return true;
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
	
	public function add_before_filter($filter)
	{
		if(!is_array($filter))
		{
			$filter = array($filter,array());
		}
		if(!isset($filter[1]))
		{
			$filter[1] = array();
		}
		if(!is_array($filter[1]))
		{
			trigger_error("add_before_filter's second argument must be an array.");
		}
		array_push($this->beforeFilters,$filter);
	}
	
	public function add_after_filter($filter)
	{
		array_push($this->afterFilters,$filter);
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
			$this->accessibleAttributes[$field[0]]=null;
		}
	}
	
	public function set($field_array)
	{
		//die(var_dump($field_array));
		if(isset($field_array[0]))
		{
			$field_array = $field_array[0];
		}
		if(!is_array($field_array)) trigger_error("Set takes an array.");
		foreach($field_array as $key=>$value)
		{
			$this->accessibleAttributes[$key] = $value;
		}
	}
	
	private function execute_filters($filter_array)
	{
		foreach($filter_array as $filter)
		{

			if(!call_user_func_array([$this,$filter[0]],$filter[1]))
			{
				return false;
			}
		}
		return true;
	}
	
	public function validates_presence_of($attr_name)
	{
		$this->add_before_filter(["filter_validates_presence_of",[$attr_name]]);
	}
	
	private function filter_validates_presence_of($attr_name)
	{
		//die(var_dump($attr_name));
		if(isset($this->accessibleAttributes[$attr_name]) && !empty($this->accessibleAttributes[$attr_name]))
		{
			return true;
		}
		else
		{
			$this->add_error("$attr_name cannot be blank.");
			return false;
		}
	}
	
	public function update()
	{
		return $this->dbcon->update($this->accessibleAttributes,$this->name);
	}
}

?>