<?php
	//this script will register the device
	
	$SUCCESS_CODE = "SUCCESS";
	$FAILED_CODE = "FAIL";
	$ALREADY_REG = "ALREADY";
	
	$json = $_SERVER['HTTP_JSON'];

	$data = json_decode($json);
	$usernamein = $data->USERNAME;
	$passwordin = $data->PASSWORD;
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
	//echo $usernamein;
	//echo $passwordin;
	//echo $id;
	//echo '-----------------';
	//need to first check if the username exists -> if not return error
	//then check if the password for that username is correct -> if not return error
	//if both succeed, check if the unique id has already been inserted -> will be bad if it already has - >return error if taken
	//
	
	$query = "SELECT username FROM User WHERE username = '$usernamein'";
	$result = mysql_query($query) or die('Errant query:  '.$query);
	
	$matchFound = mysql_num_rows($result) > 0 ? 'yes, username found' : 'no, username not found';
	//echo $matchFound;
	
	//check if device has been registred already
	$query2 = "SELECT uniqueid FROM Phone WHERE uniqueid = '$id'";
	$result2 = mysql_query($query2) or die('Errant query:  '.$query2);
	$matchFound2 = mysql_num_rows($result2) > 0 ? 'Phone already registered' : 'Phone not registered';
	//echo $matchFound2;
	
	//check password - this will have to be updated!
	$query3 = "SELECT password FROM User WHERE password = '$passwordin'";
	$result3 = mysql_query($query3) or die('Errant query:  '.$query3);
	
	//need to register if not found - will need password check here too
	if(mysql_num_rows($result) > 0 && mysql_num_rows($result3) > 0 && mysql_num_rows($result2) == 0) {
		//1.need to get the id from the username
		//2.insert
		//3.should now be registered
		//"INSERT INTO Persons (FirstName, LastName, Age)
		//VALUES ('Peter', 'Griffin',35)"
		
		$getuserid = "SELECT userid FROM User WHERE username = '$usernamein'";
		$useridresult = mysql_query($getuserid) or die('Errant query:  '.$getuserid);
		
		while($row = mysql_fetch_array($useridresult))
		{
			$user_id = $row['userid'];
			//insert here
			$insertquery = "INSERT INTO Phone (uniqueid, userid, state)
			VALUES ('$id', '$user_id', 'FINE')";
			
			$insert_result = mysql_query($insertquery) or die('Errant query:  '.$insertquery);
			if($insert_result )
			{
				echo $SUCCESS_CODE;
				//mysql_close($conn);	
			} else {
				echo $FAILED_CODE;
				//die('Could not enter data: ' . mysql_error());
			}
	
		}

	} else	{
		echo $FAILED_CODE;
	}

?>