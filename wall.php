<?php
	session_start();
	require_once("new_connection.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>The Wall</title>
	<link rel="stylesheet" type="text/css" href="normalize.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="container">
		<div id="header">
			<h1 class="wall-logo">The Wall</h1>
			<h4 class="logged-user"><?= "Welcome {$_SESSION['first_name']}" ?></h4>
			<a class="log-me-out" href="process.php">Log Off</a>
		</div>
		<div id="main-content">
			<div class="post-box">
				<h3>Post a message</h3>
				<form class="message-form" action="process_text.php" method="get">
					<textarea class="text-input" name="message" rows="4"></textarea>
					<input type="hidden" value="action" value="messaging">
					<p class="post-btn"><input class="message-btn" type="submit" value="Post a message"></p>
				</form>
			</div>
			<div class="messages-box">
				
			</div>
		</div>
	</div>
</body>
</html>