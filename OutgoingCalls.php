<?php
	$json = $_SERVER['HTTP_JSON'];

	$data = json_decode($json);
	$number = $data->NUMBER;
	$thedate = $data->THEDATE;
	$uniqueid = $data->UID;

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

	$insertquery = "INSERT INTO OutgoingNumbers (uniqueid, number, date)
			VALUES ('$uniqueid', '$number', '$thedate')";
			
	$insert_result = mysql_query($insertquery) or die('Errant query:  '.$insertquery);
	if($insert_result )
	{
		echo $SUCCESS_CODE;
		//mysql_close($conn);	
	} else {
		echo $FAILED_CODE;
		//die('Could not enter data: ' . mysql_error());
	}

?>