<?php
	session_start();
	require_once("new_connection.php");
	$join_tables_query = "SELECT users.first_name, users.last_name, messages.message, messages.created_at, messages.id as message_id
					  	  FROM users
						  JOIN messages ON users.id = messages.user_id
						  WHERE users.id = {$_SESSION['user_id']}";
	$messages = fetch_all($join_tables_query);

	$comments_query = "SELECT users.first_name, users.last_name, comments.comment, comments.created_at, comments.message_id as message_id
				       FROM users
					   JOIN messages ON users.id = messages.user_id
					   JOIN comments on messages.id = comments.message_id
					   WHERE users.id = {$_SESSION['user_id']}";
	$comments = fetch_all($comments_query);
	
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
				<form class="message-form" action="process_text.php" method="post">
					<input type="hidden" name="action" value="messaging">
					<textarea class="text-input" name="message" rows="4"></textarea>
					<p class="post-btn"><input class="message-btn" type="submit" value="Post a message"></p>
				</form>
				<?php 
					if(isset($_SESSION['blank'])) 
					{ 
						echo "<p class=blank>{$_SESSION['blank']}</p>"; 
						unset($_SESSION['blank']); 
					} 
				?>
			</div>
			<div class="messages-box">
<?php 				if(isset($messages) && !empty($messages)) { 
?>						<ol class="o-list">
<?php					foreach($messages as $message) { ?>
							<li><p class="content-m"><?= $message['message'] ?></p>
							<small>by <?= $message['first_name'] ?> | <?= $message['created_at'] ?></small> 
							<ul>					
<?php						foreach($comments as $comment) { ?>
<?php							if($comment['message_id'] == $message['message_id']) { ?>
									<li><p class="content-c"><?= $comment['comment'] ?></p>
									<small>by <?= $comment['first_name'] ?> | <?= $comment['created_at'] ?></small>
									</li>
<?php 						} ?>
						<?php	} ?>
								<li>
									<form action="process_text.php" method="post">
										<input type="hidden" name="action" value="comments">
										<input type="hidden" name="message_id" value="<?= $message['message_id']; ?>">
										<input type="text" name="comment">
										<button class="comment-btn" type="submit">Comment</button>
									</form>
								</li>
							</ul>
				<?php   } ?>
						</ol>
				<?php } ?>
			</div>
		</div>
	</div>
</body>
</html>