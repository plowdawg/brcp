<?php
//run all the tests in the test director
require("model.php");
require("controller.php");
require("../system/systemHelpers.php");
require("TestUnit.php");
external_file_loader("../config");
require("../modules/".$config["database_adapter_module"].".php");
//external_file_loader("../controllers");
external_file_loader("../models");

?>
<!DOCTYPE html>
<head>
<title> TEST RUNNER</title>
<style>body{
font-family: "Arial";font-size: 16pt;}</style>
</head>
<body>
<?php
external_file_tester("../tests/");

?>
</body>
</html>
<?php


function external_file_tester($directory)
{
	global $config;
	$diter = new DirectoryIterator($directory);
	if(!$diter->valid())
	{
		raise_error("Invalid Directory Iterator",E_ERROR);
	}
	foreach($diter as $file)
	{
		if($file->isFile())
		{
			$path = realpath($file->getPath())."/".$file;
			$file = preg_replace("/\\.php/","",$file);
			require $path;
			$obj = new $file;
		}
		else
		{
			continue;
		}
	}
}

?>