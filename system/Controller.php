<?php
class Controller
{
	private $name;
	private $notice;
	private $alert;
	
	public function __construct()
	{
		$this->modelRequireer();
	}
	
	public function renderView()
	{
	    //This function appears to be complete don't touch...
		//NOTE: Variables can be passed in here and they will go to the view...
		if(func_num_args() > 0) foreach(func_get_args()[0] as $key => $value) $$key = $value;
		global $config;
		$viewFolder = $this->getCallingClass(debug_backtrace());
		$function = $this->getCallingFunction(debug_backtrace());
		if(isset($this->notice)) $notice = $this->notice;
		if(isset($this->alert)) $alert = $this->alert;
		include("../views/".$viewFolder."/".$function.".php");
	}
	
	private function modelRequireer()
	{
		//meant to import the correct model file
		$model = $this->constructGetName();
		require("../models/".$model.".php");
	}
	
	private function getCallingClass($debugArray)
	{
		$callers=$debugArray;
		$controller = $callers[1]["class"];
		$viewFolder = preg_replace("/Controller\\z/","",$controller,-1);
		return $viewFolder;
	}
	
	private function getCallingFunction($debugArray)
	{
		$callers = $debugArray;
		$function = $callers[1]["function"];
		return $function;
	}
	
	private function constructGetName()
	{
		//We cannot rely on the same method as getName
		$callers = debug_backtrace();
		$object = get_class($callers[0]["object"]);
		$modelName = preg_replace("/sController\\z/","",$object,-1);
		return $modelName;
	}
	
	public function redirect($url)
	{
		Header("location: $url");
	}
	
	private function load_controller_modules()
	{
		//load modules from /modules/controller_name
	}
	
	
	public function before_filter()
	{
	}
	
	public function render()
	{
		$args = func_get_args();
		if(count($args)==1)
		{
			call_user_func(array($this,$args[0]));
		}
		if(count($args) == 2)
		{
			if(!is_array($args[1]))
			{
				trigger_error("Second argument of render must be an array");
			}
			foreach($args[1] as $key=>$value)
			{
				$this->$key = $value;
			}
			call_user_func(array($this,$args[0]));
		}
	}
}