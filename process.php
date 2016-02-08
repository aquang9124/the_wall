<?php
	session_start();
	require_once("new_connection.php");

	if(isset($_POST['action']) && $_POST['action'] == 'registration')
	{
		register_user($_POST);
	}
	else if(isset($_POST['action']) && $_POST['action'] == 'logmein')
	{
		login_user($_POST);
	}
	else
	{
		session_destroy();
		header('Location: main.php');
		exit();
	}

	function register_user($post) // This $post is just a parameter, it is not the actual $_POST
	{
		// Assigning more secure variables to important fields using escape_this_string function
		$username = escape_this_string($post['username']);
		$email = escape_this_string($post['email']);
		$password = escape_this_string($post['password']);

		
		// Beginning of validation checks
		$_SESSION['errors'] = array();
		// Attempt at validating existing information
		$check_data_query = "SELECT users.username, users.email FROM users";
		$existing_users = fetch_all($check_data_query);
		if(!empty($existing_users))
		{
			foreach($existing_users as $user)
			{
				if($username == $user['username'])
				{
					$_SESSION['errors'][] = 'This username is already taken.';
				}
				if($email == $user['email'])
				{
					$_SESSION['errors'][] = 'This email is already in use.';
				}
			}
		}
		// Validating non-existing information to make sure nothing is blank or invalid
		if(empty($username))
		{
			$_SESSION['errors'][] = "Username cannot be blank.";
		}
		if(empty($post['first_name']))
		{
			$_SESSION['errors'][] = "First name cannot be blank.";
		}
		if(empty($post['last_name']))
		{
			$_SESSION['errors'][] = "Last name cannot be blank.";
		}
		if(empty($password))
		{
			$_SESSION['errors'][] = "Password fields cannot be blank.";
		}
		if($post['password'] !== $post['confirm_password'])
		{
			$_SESSION['errors'][] = "Passwords must match.";
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$_SESSION['errors'][] = "Please use a valid email address.";
		}
		if(count($_SESSION['errors']) > 0)
		{
			header('Location: main.php');
			exit();
		}
		// End of validation checks and queries get run to insert data
		else
		{
			// Here I am gonna encrypt both the email and password and then I'm going to make a query to insert that data into the database
			$salt = bin2hex(openssl_random_pseudo_bytes(22));
			$encrypted_password = md5($password . '' . $salt);
			$query = "INSERT INTO users (username, first_name, last_name, email, password, salt, created_at, updated_at) 
			  		  VALUES ('{$username}', '{$post['first_name']}', '{$post['last_name']}', '{$email}', '{$encrypted_password}', '{$salt}', NOW(), NOW())";
			run_mysql_query($query);
			$_SESSION['success'] = "User has been successfully created!";
			header('Location: main.php');
			exit();
		}

	}

	function login_user($post)
	{
		// First the security stuff and then a query to get all of the needed data from the database
		$username = escape_this_string($post['username']);
		$email = escape_this_string($post['email']);
		$password = escape_this_string($post['password']);
		$query = "SELECT * FROM users WHERE users.username = '{$username}'";
		$user = fetch_record($query);
		// Beginning of validation checks
		if(empty($username))
		{
			$_SESSION['errors'][] = "Please enter your username";
		}
		if(empty($password))
		{
			$_SESSION['errors'][] = "Please enter your password";
		}
		if(empty($email))
		{
			$_SESSION['errors'][] = "Please enter your email";
		}
		if (count($_SESSION['errors']) > 0) 
		{
			header('Location: main.php');
			exit();
		}
		// End of validation checks

		// If $user comes back as not empty, then the inputted password gets encrypted to match the encrypted password in the database
		else if (!empty($user)) 
		{
			$encrypted_password = md5($password . '' . $user['salt']);
			if($user['password'] == $encrypted_password)
			{
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['first_name'] = $user['first_name'];
				$_SESSION['logged_in'] = true;
				header('Location: wall.php');
			}
			else
			{
				// If an error occurs then this error is shown
				$_SESSION['errors'][] = "Cannot find a matching user";
				header('Location: main.php');
				exit();
			}
		}
		
	}
?>