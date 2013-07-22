<?php
	$json = $_SERVER['HTTP_JSON'];

	$data = json_decode($json);
	$id = $data->UID;
	$lon = $data->lon;
	$lat = $data->lat;
	$thedate = $data->thedate;
	
	//This has been blanked out as it contained sensitive info
	$hostname = "***********************";
	$username = "***********************";
	$dbname = "***********************";
	//These variable values need to be changed by you before deploying
	$password = "***********************";
	$usertable = "mobile";
	$yourfield = "state";

        
    //Connecting to your database
    $conn = mysql_connect($hostname, $username, $password) OR DIE ("Unable to 
    connect to database! Please try again later.");
    mysql_select_db($dbname);
			

	$query = "INSERT INTO location (UID, lon, lat, date)
			  VALUES ('$id', '$lon', '$lat', '$thedate')";
	$result = mysql_query($query) or die('Errant query:  '.$query);
	
	if(! $result )
	{
	  die('Could not enter data: ' . mysql_error());
	}
	echo "Entered data successfully\n";
	mysql_close($conn);
?>