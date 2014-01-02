<!DOCTYPE html>
<html>
<head>
	<title>Basic Ruby Control Panel Login</title>
	<style>@import url("../css/sitelayout.css");
			@import url("../css/login.css");
	</style>
</head>
<img src="../images/background.jpg" alt="background" id="background" />
<div id="login_box">
<h1>User Login</h1>
<form method="post">
	<table>
		<tr><td>Login:</td><td><input name="username" /></td></tr>
		<tr><td>Password:</td><td><input name="password" type="password" /></td></tr>
		<tr><td colspan="2"><input type="submit" value="Sign In" /></td></tr>
	</table>
</form>
</div>
</html>