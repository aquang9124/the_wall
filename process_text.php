<?php
	session_start();
	require_once("new_connection.php");

	if(isset($_POST['action']) && $_POST['action'] == 'messaging')
	{
		insert_message($_POST);
	}
	if(isset($_POST['action']) && $_POST['action'] == 'comments')
	{
		insert_comment($_POST);
	}

	function insert_message($post) // This is just a parameter named $post, not the actual variable $_POST
	{
		// Making sure that the message is not blank, not gonna allow people to post blank messages. That would be annoying.
		if(trim($post['message']) == "")
		{
			$_SESSION['blank'] = "Your message cannot be blank!";
			header('Location: wall.php');
			exit();
		}
		if(!trim($post['message']) == "")
		{
			$query = "INSERT INTO messages (user_id, message, created_at, updated_at) VALUES ('{$_SESSION['user_id']}', '{$post['message']}', NOW(), NOW())";
			run_mysql_query($query);
			header('Location: wall.php');
			exit();
		}
	}

	function insert_comment($post)
	{
		if(empty($post['comment']))
		{
			$_SESSION['blank'] = "Your comment cannot be blank!";
			header('Location: wall.php');
			exit();
		}
		if(!empty($post['comment']))
		{
			$query = "INSERT INTO comments (message_id, user_id, comment, created_at, updated_at) VALUES ('{$_SESSION['message_id']}', '{$_SESSION['user_id']}', '{$post['comment']}', NOW(), NOW())";
			run_mysql_query($query);
			header('Location: wall.php');
			exit();
		}
	}
?>