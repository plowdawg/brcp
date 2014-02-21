<?php

class UserModelTest extends TestUnit
{
	public function __construct()
	{
		echo "<strong>User Model Test</strong><br />";
		$this->setup_vars();
		echo $this->assert_equals("POST username should be set",$_POST["username"],"es3Admin");
		echo $this->assert_equals("POST password should be set",$_POST["password"],"Es3es3!!");
		echo $this->assert_not_null("login in user object should not be null",$this->obj->accessibleAttributes["login"]);
		echo $this->assert_equals("login should match user object",$this->obj->accessibleAttributes["login"],"es3Admin");
		echo "<hr />";
	}
	
	public function setup_vars()
	{
		$_POST["username"] = "es3Admin";
		$_POST["password"] = "Es3es3!!";
		$user = new User();
		$this->obj = $user->sign_in();
	}
	
}