<?php
class Controller
{
	private $name;
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
	
	private function redirect($url)
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
}