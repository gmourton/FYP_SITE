<?php
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
	$target_path  = './FrontImages/';
	$o_target_path  = './FrontImages/';
	$user = $_REQUEST['user'];
	
	//need to select the userid of the phone owner for the folder
	$query = "SELECT userid FROM Phone WHERE uniqueid = '$user'";
	$result = mysql_query($query) or die('Errant query:  '.$query);
	
	$res = mysql_fetch_row($result);  
	$dir = $target_path . $res[0] . '/';
	
	$pathinfo = pathinfo(basename( $_FILES['uploadedfile']['name']));
	echo '--' . $pathinfo['extension'] . '--';
	$path_ext = $pathinfo['extension'];
	
	if (!is_dir($dir)) {
		//create it
		mkdir($dir, 0777);
		//check if thumbnails exists
		if(!is_dir($dir . 'thumbs/')) {
			mkdir($dir . 'thumbs/', 0777);
		}
	} else {
		echo 'Dir already exists';
	}
	
	$target_path_thumb = $dir . "thumbs/" . basename( $_FILES['uploadedfile']['name']);
	$target_path_e = $dir . basename( $_FILES['uploadedfile']['name']);
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path_e)) {
		echo "The file ".  basename( $_FILES['uploadedfile']['name']).
	 " has been uploaded";
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
	} else{
		echo "There was an error uploading the file, please try again!";
	}

?>