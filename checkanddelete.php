<?php
	$SUCCESS_CODE = "SUCCESS";
	$FAILED_CODE = "FAIL";
	
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
	
	//check if device has been registred already
	$query2 = "SELECT uniqueid FROM Phone WHERE uniqueid = '$id'";
	$result2 = mysql_query($query2) or die('Errant query:  '.$query2);
	$matchFound2 = mysql_num_rows($result2) > 0 ? $SUCCESS_CODE : $FAILED_CODE;
	echo $matchFound2;
	//now delete it
	// $result=mysql_query("DELETE FROM Phone WHERE uniqueid = '$id'");
	// echo $result;
?>