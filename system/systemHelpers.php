<?php
function dumb_inflector($singular)
{
	return $singular."s";
}

function inflector($singular)
{
	return dumb_inflector($singular);
}

function external_file_loader($directory)
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
			require $path;
		}
		else
		{
			continue;
		}
	}
}
?>