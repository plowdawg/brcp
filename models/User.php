<?php
	//should probably try to move this to the ZeusIntercepter to make it look cleaner.
	require("../system/model.php");
	class User extends Model
	{
		public function __construct()
		{
			Model::__construct();
		}
		
		public function sign_in()
		{
			
		}
		
	}
	
?>