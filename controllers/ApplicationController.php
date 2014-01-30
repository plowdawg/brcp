<?php

class ApplicationController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->before_filter("check_login",["except"=>["index","sign_in","verify_login_json"]]);
	}
	
	public function check_login()
	{
		global $config;
		require_once("../models/User.php");
		$this->current_user = (new User())->get_user_from_session();
		//die(var_dump($this->current_user));
		if(!$this->current_user->accessibleAttributes["first_name"]) $this->redirect($config["base_uri"]."user/index");
	}
	
}