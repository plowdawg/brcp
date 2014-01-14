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
	
	public function admin_panel()
	{
		$this->renderView();
	}
	
	public function sign_in()
	{
		$user = new User();
		$data["user"] = $user->sign_in();
		if(isset($data["user"]->accessibleAttributes["login"]))
		{
			$data["user"]->accessibleAttributes["session_id"] = session_id();
			if($data["user"]->update())
			{
				if($data["user"]->accessibleAttributes["user_level"] == 1)
				{
					$this->redirect("admin_panel");
				}
				else
				{
					$this->redirect("user_panel");
				}
			}
			else
			{
				$this->render("index",["alert"=>"Problem updating DB."]);
			}
		}
		else
		{
			$this->render("index",array("alert"=>"Invalid user name or password."));
		}
	}
	
	public function new_user()
	{
		if(!isset($data))
		{
			$data["user"] = new User();
		}
		$this->renderView($data);
	}
	
	public function create()
	{
		$data["user"] = new User(["login"=>$_POST["username"],"first_name"=>$_POST["first_name"],"last_name"=>$_POST["last_name"],
		"email"=>$_POST["email"],"password"=>md5($_POST["password"]),"user_level"=>$_POST["level"]]);
		if($data["user"]->save())
		{
			$this->render("new_user",["alert"=>"Successfully created user."]);
		}
		else
		{
			$this->render("new_user",["alert"=>"Failed to create user."]);
		}
	}
	
	
}