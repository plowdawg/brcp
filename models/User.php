<?php
	//should probably try to move this to the ZeusIntercepter to make it look cleaner.
	class User extends Model
	{
		//private $salt = "LaJIa37azfb4umxf2sCg";
		public function __construct()
		{
			Model::__construct();
		}
		
		public function sign_in()
		{
			//return $this->where(["login"=>$_POST["username"],"password"=>password_hash($_POST["password"],PASSWORD_BCRYPT,['salt'=>$this->salt])])->execute();
			return $this->where(["login"=>$_POST["username"],"password"=>md5($_POST["password"])])->execute();
		}
		
	}
	
?>