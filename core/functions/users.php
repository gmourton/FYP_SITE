<?php
	// //this function will sort out the time durations to be able to get the location data
	// function test($timesarray, $uniqueid) {
		// $count = count_major_start_dates($uniqueid)
		// $arraySize = count($timesarray);
		// if($count > 0) {
			// //loop through
			// if($count == 1) {
				// //only of size 1 : will be the only object -> current time
				// return 
			// } else {
			
				// for ($i = 0; $i < $arraySize; $i++) {
					// if($i == ($arraySize - 1)) {
						
					// }
				// }
			// }
		// } else {
			// return null;
		// }
	// }
	
	function get_outgoing_numbers($uniqueid) {
		$query = mysql_query("SELECT number, date FROM OutgoingNumbers WHERE uniqueid = '$uniqueid'");
		
		$var = array();
		while ($row = mysql_fetch_array($query)) {
			$var[] = array (
						'number' => $row['number'],
						'date' => $row['date']
			);
		}
		return $var;
		
	}
	
	
	//gets ALL of the data
	function get_all_location_Data($uniqueid) {
			$var = array();
			$results = mysql_query("SELECT lon, lat FROM location WHERE UID = '$uniqueid'");
			while ($row = mysql_fetch_assoc($results)) {
				$var[] = array (
					'lon' => $row['lon'],
					'lat' => $row['lat']
				);

			}
			return json_encode($var);
	}
	//this will need to be updated to get the values between certain dates
	function get_location_Data($uniqueid, $starttime, $endtime) {
			$var = array();
			$results = mysql_query("SELECT lon, lat FROM location WHERE UID = '$uniqueid' AND date >= '$starttime' AND date < '$endtime'");
			while ($row = mysql_fetch_array($results)) {
				$var[] = $row['lon'];
				$var[] = $row['lat'];
			}
			return $var;
	}

	function return_dates($uniqueid) {
		if(count_major_start_dates($uniqueid) == 0) {
			return 0;
		} else {
			//there are major state dates for this device
			$results = mysql_query("SELECT startdate FROM MajorStateData WHERE UID = '$uniqueid'") or die ("Error in query: $query. ".mysql_error());
			$var = array();
			while ($row = mysql_fetch_array($results)) {
				$var[] = $row['startdate'];
			}
			return $var;
		}
	}

	function count_major_start_dates($uniqueid) {
		$result = mysql_query("SELECT COUNT(startdate) FROM MajorStateData WHERE UID = '$uniqueid'");
		$count = mysql_result($result, 0);
		return $count;
	}

	function insert_major_start_dates($uniqueid) {
		date_default_timezone_set('GMT');
		$data = date("Y-m-d H:i:s");
		mysql_query("INSERT INTO MajorStateData (UID, startdate) VALUES ('$uniqueid', '$data')") or die ("Error in query: $query. ".mysql_error());

	}
	
	function get_state($uniqueid) {
		$result = mysql_query("SELECT state FROM Phone WHERE uniqueid = '$uniqueid'") or die ("Error in query: $query. ".mysql_error());
		return mysql_result($result, 0, 0);
	}

	function get_array_of_devices($user_id) {
		$query = mysql_query("SELECT uniqueid FROM Phone WHERE userid = '$user_id'");
		
		$var = array();
		while ($row = mysql_fetch_array($query)) {
			$var[] = $row['uniqueid'];
		}
		return $var;
	}

	function is_any_devices($user_id) {
		$query = mysql_query("SELECT COUNT($user_id) FROM Phone WHERE userid = '$user_id'");
		return (mysql_result($query, 0) == 1) ? true : false;
	}

	function list_devices($user_id) {
		$returnString  = "<table><tr><td>UNIQUEID</td><td>STATE</td><td>MODEL</td><td>IMEI</td></tr>";
		$user_id = (int)$user_id;
		
		$result = mysql_query("SELECT * FROM Phone WHERE userid = '$user_id'");
		while($row = mysql_fetch_array($result)) {
			$returnString = $returnString . "<tr><td>" . $row['uniqueid'] . "</td><td>" . $row['state'] . "</td><td>" . $row['model'] . "</td><td>" . $row['IMEI'] . "</tr>";
					
		}
		return $returnString . "</table>";
	}

	function change_state($uniqueid, $state) {
		mysql_query("UPDATE Phone SET state = '$state' WHERE uniqueid = '$uniqueid'");
	}

//need to encrypt later
	function change_password($user_id, $password) {
		$user_id = (int)$user_id;
		mysql_query("UPDATE User SET password = '$password' WHERE userid = '$user_id'");
	}

	function register_user($register_data) {
		//will need to encrpt password later
		array_walk($register_data, 'array_sanitize');

		$data = '\'' . implode('\', \'', $register_data) . '\'';
		$fields = implode(', ', array_keys($register_data));
		
		mysql_query("INSERT INTO User ($fields) VALUES ($data)");
	}

	function user_data($user_id) {
		$data = array();
		$user_id = (int)$user_id;
		
		$func_num_args = func_num_args();
		$func_get_args = func_get_args();
		if($func_num_args > 1) {
			unset($func_get_args[0]);
			
			$fields = implode(', ', $func_get_args);
			
			$data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM User WHERE userid = '$user_id'"));
			return $data;
		}
	}

	function logged_in() {
		return (isset($_SESSION['user_id'])) ? true : false;
	}
	
	function email_exists($email) {
		$san_email = sanitize($email);
		$query = mysql_query("SELECT COUNT(userid) FROM User WHERE email = '$san_email'");
		return (mysql_result($query, 0) == 1) ? true : false;
	}

	function user_exists($username) {
		$san_username = sanitize($username);
		$query = mysql_query("SELECT COUNT(userid) FROM User WHERE username = '$san_username'");
		return (mysql_result($query, 0) == 1) ? true : false;
	}
	
	function user_active($username) {
		$san_username = sanitize($username);
		$query = mysql_query("SELECT COUNT(userid) FROM User WHERE username = '$san_username' AND active = 1");
		return (mysql_result($query, 0) == 1) ? true : false;
	}
	
	function userid_from_username($username) {
		$san_username = sanitize($username);
		return mysql_result(mysql_query("SELECT userid FROM User WHERE username = '$san_username'"), 0, 'userid');
	}
	
	function login($username, $password) {
		$user_id = userid_from_username($username);
		
		$san_username = sanitize($username);
		//need to add encryption later
		$san_password = md5(sanitize($password));
		
		
		return (mysql_result(mysql_query("SELECT COUNT(userid) FROM User WHERE username = '$san_username' AND password = '$san_password'"), 0) == 1) ? $user_id : false;
	}

?>