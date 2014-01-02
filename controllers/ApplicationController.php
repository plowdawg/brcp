<?php

class ApplicationController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->before_filter("check_login",["except"=>["index"]]);
	}
}