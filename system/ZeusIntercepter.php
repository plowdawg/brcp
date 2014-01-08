<?php
/*The Zeus Intercepter is where all requests must come before the are processed
Request > Controller > Model then
Model > Controller then
Controller > View*/
require("systemHelpers.php");
error_reporting(0);
@session_start();
if(isset($_GET["zeus_uri"]))
{
	php_self_overrider();
	external_file_loader("../config");
	date_default_timezone_set ($config["timezone"]);
	set_error_handler("zeus_error_handler");
	register_shutdown_function("zeus_fatal_handler");
	//support for ID needs to be added and needs to be made into a router module.
	
	require("../config/database.php");
	require("./Controller.php");
	require("../controllers/ApplicationController.php");
	require("./model.php");
	require("./modules/controller/module.php");
	require("./router.php");
	$router = new Router($_GET["zeus_uri"]);
	$controller = $router->getController();
	require("../controllers/".$controller.".php");
	$action = $router->getAction();
	$controller_instance = new $controller;
	//here we need to load before_filters of the controller
	call_user_func(array($controller_instance,$action));
	//then after mehtod of controllers
}

function php_self_overrider()
{	
	$_SERVER["PHP_SELF"] = preg_replace("/system\\/ZeusIntercepter.php\\z/",$_GET["zeus_uri"],$_SERVER["PHP_SELF"],-1);
}

function zeus_fatal_handler()
{
	$errfile = "Unknown file";
	$errstr = "shutdown";
	$errno = E_CORE_ERROR;
	$errline = 0;
	
	$error = error_get_last();
	
	if($error != NULL)
	{
		$errno = $error["type"];
		$errfile = $error["file"];
		$errline = $error["line"];
		$errstr = $error["message"];
		zeus_error_handler($errno,$errstr,$errfile,$errline);
	}
}

function zeus_error_handler($errno,$errstr,$errfile,$errline)
{	
	global $config;
	if($config["error_level"] == 0)
	{
		include "errorTemplate.php";
	}
	else
	{
		//For security in production all errors are 404.
		header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
		header("Status: 404 Not Found");
		mail($config["production_error_email_address"],"ZEUS FRAMEWORK ERROR","THE ZEUS FRAMEWORK ENCOUNTERED AN ERROR: $errstr <br />in $$errfile on line $errline");
		include "404ErrorTemplate.php";
	}
	die();
	return false;
}