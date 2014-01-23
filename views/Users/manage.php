<!DOCTYPE html>
<html>
<head>
	<title>Basic Ruby Control Panel Login</title>
	<style>@import url("../css/sitelayout.css");
			@import url("../css/form.css");
	</style>
</head>
<img src="../images/background.jpg" alt="background" id="background" />
<div id="form_box">
<h1>Manage Users</h1>
<div><a href="./new_user">New User</a></div>
<table class="data">
<tr><th>User name</th></tr>
<?php foreach($users as $usr)
{
	echo "<tr><td>".$usr["login"]."</td></tr>\r\n";
}?>
</table>
</div>
</html>