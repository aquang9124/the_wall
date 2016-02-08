<?php
	session_start();
	require_once("new_connection.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registration and Log In</title>
	<link rel="stylesheet" type="text/css" href="normalize.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="container">
		<div class="header">
			<h1>The Wall</h1>
			<ul class="nav">
				<li><a href='process.php'>Home</a></li>
			</ul>
		</div>
		<div class="reg-wrapper">
			<h1>Register</h1>
			<?php 
				if (isset($_SESSION['errors'])) 
				{
					foreach ($_SESSION['errors'] as $errors) 
					{
						echo "<p class='error'>{$errors}</p>";
					}
					unset($_SESSION['errors']);
				}

				if (isset($_SESSION['success'])) 
				{
					echo "<p class='success'>{$_SESSION['success']}</p>";
					unset($_SESSION['success']);
				}

			?>
			<form action="process.php" method="post">
				<input type="hidden" name="action" value="registration">
				<p>Username: <input class="inputs" type="text" name="username"></p>
				<p>First Name: <input class="inputs" type="text" name="first_name"></p>
				<p>Last Name: <input class="inputs" type="text" name="last_name"></p>
				<p>Email Address: <input class="inputs" type="text" name="email"></p>
				<p>Password: <input class="inputs" type="password" name="password"></p>
				<p>Confirm Password: <input class="inputs" type="password" name="confirm_password"></p>
				<p><input class="input-btn" type="submit" value="Register"></p>
			</form>
			<div class="login-container">
				<h1>Log In</h1>
				<form action="process.php" method="post">
					<input type="hidden" name="action" value="logmein">
					<p>Username: <input class="inputs" type="text" name="username"></p>
					<p>Email Address: <input class="inputs" type="text" name="email"></p>
					<p>Password: <input class="inputs" type="password" name="password"></p>
					<p><input class="input-btn" type="submit" value="Log Me In"></p>
				</form>
		</div>
		</div>
	</div>
</body>
</html>