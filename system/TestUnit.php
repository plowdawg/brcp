<?php
/*Test Unit is the class that tests can inherit from*/

class TestUnit
{
	public function __construct()
	{
	}
	
	protected function trueFalse($val)
	{
		if($val == 1) return "true";
		else return "false";
	}
	
	protected function checkVoidFunction($name,$obj)
	{
		$method = $this->instance->getMethod($name);
		$method->setAccessible(true);
		try
		{
			return $method->invoke($obj);
		}
		catch(Exception $ex)
		{
			echo "<pre>",print_r($ex),"</pre>";
		}
	}
	
	protected function assert_equals($real,$expected)
	{
		if($real == $expected)
		{
			return '<span style="color: green">OK</span>';
		}
		else
		{
			$debugArray = debug_backtrace();
			echo '<span style="color:red;">Fail</span><pre>',print_r($this->obj),"</pre>";
		}
	}
	
	protected function assert_not_null($real)
	{
		if($real == NULL)
		{
			$debugArray = debug_backtrace();
			echo '<span style="color:red;">Fail</span><pre>',print_r($this->obj),"</pre>";
		}
		else
		{
			return '<span style="color: green">OK</span>';
		}
	}
}

?>