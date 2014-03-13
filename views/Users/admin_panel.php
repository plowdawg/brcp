<?php $prefix = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	  $port = isset($_SERVER["SERVER_PORT"]) ? $_SERVER["SERVER_PORT"] : 80;?>
<!DOCTYPE html>
<html>
	<head>
		<title>Basic Ruby Control Panel Administrtion</title>
		<style>@import url("../css/sitelayout.css");
				@import url("../css/panel_layout.css");
		</style>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> 
	</head>
	<body>
		<img src="../images/background.jpg" name="background" alt="background" id="background" />
		<div id="action_panel">
			<div class="action_item"><a href="./manage"><img src="../images/icons/user.png" alt="New User">Manage Users</a></div>
			<div class="action_item"><img src="../images/icons/ruby.png" alt="install ruby">Manage Rubies</div>
			<div class="action_item"><a href="filemanager_sign_in" target="_blank"><img src="../images/icons/folder.png" alt="Folder" />File Manager</a></div>
			<div class="action_item"><a href="./sign_out"><img src="../images/icons/exit.png" alt="sign out">Sign Out</a></div>
		</div>
	</body>
</html>