<?php
	//this script will register the device
	
	$json = $_SERVER['HTTP_JSON'];

	$data = json_decode($json);
	$id = $data->UID;
	
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
	

	
	$query = "SELECT state FROM Phone WHERE uniqueid = '$id'";
	$result = mysql_query($query) or die('Errant query:  '.$query);
	
	   $r=mysql_fetch_row($result);  
		echo $r[0];  

	// $return = array();
	// while($r= mysql_fetch_assoc($result) ){
		// $return[] = $r;
	// }

	// if (count($return) > 0) {
		// //echo json_encode($return);
		// echo var_dump($return);
	// }
	// else {
		// echo '{"state": UNKNOWN}';
	// }
?>