<?php

class UsersController extends ApplicationController
{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		//this is a function to check the login
		/*Note: I had no way to determine the variable user dynamically in Controller.php without giving it
		to an array (similar to CI) therefore $data will be used as a convention in array.  It can be used as $user in view*/
		$data['user'] = new User();
		$this->renderView($data);
	}
	
	public function sign_in()
	{
		$user = new User();
		
		$this->render("index",array("alert"=>"Invalid user name or password."));
	}
	
	
	
}