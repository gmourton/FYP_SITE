<?php 
include 'core/init.php'; 
protect_page();


if(empty($_POST) === false) {
	$required_fields = array('currentpassword', 'password', 'passwordagain');
		foreach($_POST as $key=>$value) {
		if(empty($value) && in_array($key, $required_fields) ===true) {
			$errors[] = 'Fields marked with an asterisk are required';
			break 1;
		}
	}
	
	if($_POST['currentpassword'] === $user_data['password']) {
		if(trim($_POST['password']) !== trim($_POST['passwordagain'])) {
			$errors[] = 'New passwords do not match';
		} else if(strlen($_POST['password']) < 6) {
			$errors[] = 'Password needs to be greater than 6';
		}
	} else {
		$errors[] = 'Current password is incorrect';
	}
}


include 'includes/overall/header.php'; ?>
<h1>Change Password</h1>   
<?php 
	if(isset($_GET['success']) && empty($_GET['success'])) {
		echo 'You have successfully changed your password.';
	} else {
	if(empty($_POST) === false && empty($errors) === true) {
		change_password($session_user_id, $_POST['password']);
		header('Location: changepassword.php?success');
	} else if(empty($errors) === false) {
		print_r($errors);
	}
?>
<form action="" method="post">
	<ul>
		<li>
			Current Password*:<br>
			<input type="password" name="currentpassword">
		</li>
		<li>
			New Password*:<br>
			<input type="password" name="password">
		</li>
		<li>
			New Password again*:<br>
			<input type="password" name="passwordagain">
		</li>
		<input type="submit" value="Change password">
	</ul>
</form>


<?php
}
 include 'includes/overall/footer.php'; ?>