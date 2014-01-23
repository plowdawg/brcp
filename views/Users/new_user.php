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
<h1>New User</h1>
<?php if(isset($alert))
{?>
	<div class="alert"><?php echo $alert;
		foreach($user->get_errors() as $error)
			{
				echo $error."<br />";
			}?>
	</div>
<?php } ?>
<form method="post" action="create">
	<table>
		<tr><td>Login:</td><td><input name="username" /></td></tr>
		<tr><td>First Name:</td><td><input name="first_name" /></td></tr>
		<tr><td>Last Name:</td><td><input name="last_name" /></td></tr>
		<tr><td>Email:</td><td><input name="email" type="email" /></td></tr>
		<tr><td>Password:</td><td><input name="password" type="password" /></td></tr>
		<tr><td>Confirm Password:</td><td><input name="confirm_password" type="password" /></td></tr>
		<tr><td>Domain:</td><td><input name="domain" /></td></tr>
		<tr><td>User Level:</td><td><select name="level">
										<option value="1">User</option>
										<option value="2">Administrator</option>
									</select>
							</td></tr>
		
		<tr><td colspan="2"><input type="submit" value="Create" /></td></tr>
	</table>
</form>
</div>
</html>