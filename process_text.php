<?php
	session_start();
	require_once("new_connection.php");

	if(isset($_GET['action']) && $_GET['action'] == 'messaging')
	{
		post_message($_GET);
	}
	if(isset($_GET['action']) && $_GET['action'] == 'comments')
	{
		post_comment($_GET);
	}

	function post_message($get) // This is just a parameter named $get, not the actual variable $_GET
	{
		// Making sure that the message is not blank, not gonna allow people to post blank messages. That would be annoying.
		if(empty($get['message']))
		{

		}
	}
?>