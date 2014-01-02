<?php
	//should probably try to move this to the ZeusIntercepter to make it look cleaner.
	require("../system/model.php");
	class User extends Model
	{
		public function __construct()
		{
			Model::__construct();
			//array_push($this->accessibleAttributes,"email");
		}
		
		public function index()
		{
		}
		
		public function login()
		{
	
		}
		
	}
	
?>