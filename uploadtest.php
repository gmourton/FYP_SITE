<?php
	//These variable values come from your hosting account.
	//This has been blanked out as it contained sensitive info
	$hostname = "***********************";
	$username = "***********************";
	$dbname = "***********************";
	//These variable values need to be changed by you before deploying
	$password = "***********************";
	$usertable = "mobile";
	$yourfield = "state";

	//Connecting to your database
	mysql_connect($hostname, $username, $password) OR DIE ("Unable to 
	connect to database! Please try again later.");
	mysql_select_db($dbname);
	$target_path  = './Useruploadfiles/';
	$o_target_path  = './Useruploadfiles/';
	$user = $_REQUEST['user'];
	
	//need to select the userid of the phone owner for the folder
	$query = "SELECT userid FROM Phone WHERE uniqueid = '$user'";
	$result = mysql_query($query) or die('Errant query:  '.$query);
	
	$res = mysql_fetch_row($result);  
	$dir = $target_path . $res[0] . '/';
	
	//do stuff with the result
	//-see if the users folder already exists
	//--if not, create it with all required folders inside such as contacts, images, other and sms
	if (!is_dir($dir)) {
		//create it
		mkdir($dir, 0777);
		//also create the subdirectories
		mkdir($dir . 'images' . '/', 0777);
		mkdir($dir . 'contacts' . '/', 0777);
		mkdir($dir . 'sms' . '/', 0777);
		mkdir($dir . 'other' . '/', 0777);
		mkdir($dir . 'othersnot' . '/', 0777);
	} else {
		echo 'Dir already exists';
	}
	echo $_REQUEST['numOfFiles'];
	echo '++ ' . $dir . ' ++';
	
	
	for ($i = 0; $i < $_REQUEST['numOfFiles']; $i++) {
		$fileTagi = 'uploadedfile' . $i;
		$pathinfo = pathinfo(basename( $_FILES[$fileTagi]['name']));
		echo '--' . $pathinfo['extension'] . '--';
		$path_ext = $pathinfo['extension'];
		
		$target_path_e = $dir;
		if(strcasecmp($path_ext, 'png') == 0 || strcasecmp($path_ext, 'jpg') == 0) {
			$target_path_e = $target_path_e . 'images/';
		} else if(strcasecmp($path_ext, 'vcf') == 0 || strcasecmp($path_ext, 'xml') == 0 || strcasecmp($path_ext, 'bsms') == 0) {
			$target_path_e = $target_path_e . 'contacts/';
			//checks will grow as more file extensions are tested and added
		} else if(strcasecmp($path_ext, 'txt') == 0) {
			$target_path_e = $target_path_e . 'other/';
		} else {
			$target_path_e = $target_path_e . 'othersnot/';
		}

		
	    $target_path_e = $target_path_e  . basename( $_FILES[$fileTagi]['name']);
		 if(move_uploaded_file($_FILES[$fileTagi]['tmp_name'], $target_path_e)) {
			 echo "The file ".  basename( $_FILES[$fileTagi]['name']).
			 " has been uploaded.";
			 $user = $_REQUEST['user'];
			 echo "String Parameter send from client side : " . $user;
		} else {
			 echo "There was an error uploading the file, please try again!";
			 echo "filename: " .  basename( $_FILES[$fileTagi]['name']);
			 echo "target_path: " .$target_path_e;
		}
	} 
	
?>