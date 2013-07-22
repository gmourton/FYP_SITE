<?php
	include 'core/init.php'; 
	logged_in_redirect();
	if(empty($_POST) === false) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		if(empty($username) === true || empty($password) === true) {
			$errors[] = 'Please enter a username and password';
		} else if(user_exists($username) === false) {
			$errors[] = 'Incorrect username';
		} else if(user_active($username) === false) {
			$errors[] = 'Not active';
		} else {
			//comment this out -----
			if(strlen($password) > 32) {
				$errors[] = 'password too long';
			}
			//------			
		
			$login = login($username, $password);
			if($login === false) {
				$errors[] = 'Username or password incorrect';
			} else {
				$_SESSION['user_id'] = $login;
				header('Location: index.php');
				exit();
			}
		}
		
	} else {
		$errors[] = 'No data';
	}
	include 'includes/overall/header.php';
	?>
	<?php 
	if(empty($errors) === false) {
	 ?><h2>We tried to log you in but...</h2> <?php
		echo output_errors($errors);
	}
	?>
	<?php
	include 'includes/overall/footer.php';
?>