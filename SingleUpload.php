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
	
	if (!is_dir($dir)) {
		//create it
		mkdir($dir, 0777);
		//also create the subdirectories
		mkdir($dir . 'images' . '/', 0777);
		mkdir($dir . 'contacts' . '/', 0777);
		mkdir($dir . 'sms' . '/', 0777);
		mkdir($dir . 'other' . '/', 0777);
		
		//check if thumbnails exists
		if(!is_dir($dir . 'images' . '/thumbs')) {
			mkdir($dir . 'images' . '/thumbs', 0777);
		}
	}
	
	$fileTagi = 'uploadedfile' . $_REQUEST['number'];
	$pathinfo = pathinfo(basename( $_FILES[$fileTagi]['name']));
	echo '--' . $pathinfo['extension'] . '--';
	$path_ext = $pathinfo['extension'];
	
	$target_path_e = $dir;
	if(strcasecmp($path_ext, 'png') == 0 || strcasecmp($path_ext, 'jpg') == 0) {
		$target_path_e = $target_path_e . 'images/';
		//will need to create thumbnails for displaying on the website
	} else if(strcasecmp($path_ext, 'vcf') == 0 || strcasecmp($path_ext, 'xml') == 0 || strcasecmp($path_ext, 'bsms') == 0) {
		$target_path_e = $target_path_e . 'contacts/';
		//checks will grow as more file extensions are tested and added
	} else if(strcasecmp($path_ext, 'txt') == 0) {
		$target_path_e = $target_path_e . 'other/';
	} 
	$target_path_thumb = $target_path_e  . "/thumbs/" . basename( $_FILES[$fileTagi]['name']);
	$target_path_e = $target_path_e  . basename( $_FILES[$fileTagi]['name']);
	 if(move_uploaded_file($_FILES[$fileTagi]['tmp_name'], $target_path_e)) {
		 echo "The file ".  basename( $_FILES[$fileTagi]['name']).
		 " has been uploaded.";
		 $user = $_REQUEST['user'];
		 echo "String Parameter send from client side : " . $user;
		 echo $target_path_e;
		 if(strcasecmp($path_ext, 'png') == 0 || strcasecmp($path_ext, 'jpg') == 0) {
			 $src_size = getimagesize($target_path_e);
			 $thumb_width = 250;
			 $thumb_height = 200;
			 
			 if($src_size['mime'] === 'image/jpeg') {
				$src = imagecreatefromjpeg($target_path_e);
			 } else if ($src_size['mime'] === 'image/png') {
				$src = imagecreatefrompng($target_path_e);
			 }
			 
			 $src_aspect = round(($src_size[0] / $src_size[1]), 1);
			 $thumb_aspect = round(($thumb_width / $thumb_height), 1);
			 
			 if($src_aspect < $thumb_aspect) {
				//higher
				$new_size = array($thumb_width,($thumb_width / $src_size[0]) * $src_size[1]);
				$src_pos = array(0, ($new_size[1] - $thumb_height) / 2);
			 } else if($src_aspect > $thumb_aspect) {
				//wider
				$new_size = array(($thumb_width / $src_size[1]) * $src_size[0], $thumb_height);
				$src_pos = array(($new_size[0] - $thumb_width) / 2, 0);
			 } else {
				//equal
				$new_size = array($thumb_width, $thumb_height);
				$src_pos = array(0, 0);
			 }
			 
			 if($new_size[0] < 1){
				$new_size[0] = 1;
			 }
			 if($new_size[1] < 1){
				$new_size[1] = 1;
			 }
			 
			 $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
			 imagecopyresampled($thumb, $src, 0, 0, $src_pos[0], $src_pos[1], $new_size[0], $new_size[1], $src_size[0], $src_size[1]);
			 
			 if($src_size['mime'] === 'image/jpeg') {
				imagejpeg($thumb, $target_path_thumb);
			 } else if ($src_size['mime'] === 'image/png') {
				imagepng($thumb, $target_path_thumb);
			 }
			 
			 
		 }
	} else {
		 echo "There was an error uploading the file, please try again!";
		 echo "filename: " .  basename( $_FILES[$fileTagi]['name']);
		 echo "target_path: " .$target_path_e;
	}


?>