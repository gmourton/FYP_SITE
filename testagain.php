<?php
	//this script will register the device
	
	$json = $_SERVER['HTTP_JSON'];

	$data = json_decode($json);
	$id = $data->UID;
	
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
	

	
	$query = "SELECT state FROM mobile WHERE UID = '$id'";
	$result = mysql_query($query) or die('Errant query:  '.$query);

	$return = array();
	while($r= mysql_fetch_assoc($result) ){
		$return[] = $r;
	}

	if (count($return) > 0) {
		echo json_encode($return);
	}
	else {
		echo '{"state": UNKNOWN}';
	}

	
	// $posts = array();
	  // if(mysql_num_rows($result)) {
		// while($post = mysql_fetch_assoc($result)) {
		  // $posts[] = array('post'=>$post);
		// }
	  // }

 //  header('Content-type: application/json');
    // echo json_encode(array('posts'=>$posts));
  
	  
//?>