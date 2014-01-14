<?php
	//should probably try to move this to the ZeusIntercepter to make it look cleaner.
	class User extends Model
	{
		//private $salt = "LaJIa37azfb4umxf2sCg";
		public function __construct()
		{
			if(func_num_args() > 0)
			{
				parent::__construct(func_get_args());
			}
			else
			{
				parent::__construct();
			}
			$this->add_before_filter("validates_password");
			$this->validates_presence_of("login");
			$this->validates_presence_of("first_name");
			$this->validates_presence_of("last_name");
			$this->validates_presence_of("email");
		}
		
		public function sign_in()
		{
			//return $this->where(["login"=>$_POST["username"],"password"=>password_hash($_POST["password"],PASSWORD_BCRYPT,['salt'=>$this->salt])])->execute();
			return $this->where(["login"=>$_POST["username"],"password"=>md5($_POST["password"])])->execute();
		}
		
		public function validates_email()
		{
			if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
			{
				return true;
			}
			else
			{
				$this->add_error("Email address is not valid");
			}
		}
		
		public function validates_password()
		{
			if($_POST["password"] != $_POST["confirm_password"])
			{
				//die("passwords don't match");
				$this->add_error("Passwords do not match");
				return false;
			}
			return true;
		}
		
		
	}
	
?>