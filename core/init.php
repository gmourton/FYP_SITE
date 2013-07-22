<?php
	ob_start();
	session_start();
	//error_reporting(0);
	
	require 'database/connect.php';
	require 'functions/general.php';
	require 'functions/users.php';
	
	if(logged_in() === true) {
		$session_user_id = $_SESSION['user_id'];
		$user_data = user_data($session_user_id, 'userid', 'username', 'password', 'fname', 'lname', 'email');
		
		if(user_active($user_data['username']) === false) {
			session_destroy();
			header('Location: index.php');
			exit();
		}
	}
	
	$errors = array();
?>