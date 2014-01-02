<?php

class UserModelTest extends TestUnit
{
	public function __construct()
	{
		echo "<strong>User Model Test</strong><br />";
		$this->setupFalseGetPost();
		$this->instance = new ReflectionClass('User');
		$this->obj = new User();
		echo "Check Credentials Should Return True: ",$this->assert_equals($this->test_checkCredentials(),true),"<br />";
		echo "Check login Should return false: ",$this->assert_equals($this->test_checkLogin(),false),"<br />";
		echo "Get Redirect Path Should Return a value: ",$this->assert_not_null($this->obj->getRedirectPath()),"<br />";
		echo "Login Should Return True: ",$this->assert_equals($this->obj->login(),true),"<br />";
		echo "Login key should be 'full_password' :",$this->assert_equals($this->testArraySearch(),"full_password");
		echo "<hr />";
	}
	
	private function test_checkCredentials()
	{
		return $this->checkVoidFunction("checkCredentials",$this->obj);
	}
	
	private function test_checkLogin()
	{
		return $this->checkVoidFunction("checkLogin",$this->obj);
	}
	
	private function setupFalseGetPost()
	{
		$_POST["user"] = "dummy@dummytest.com";
		$_POST["password"] = "Es3Mars!";
	}
	
	private function testArraySearch()
	{
		global $config;
		return array_search($_POST["password"],$config);
	}
	
	
}