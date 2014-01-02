<?php
	class Login extends Module
	{
		public function __construct()
		{
			add_method("check_login");
			before_filter("check_login",["except"=>"index"]);
		}
		
		

	}
	
?>