<?php

   //These variable values come from your hosting account.
	$hostname = "**************************";
	$username = "*******************";
	$password = "****************";
	$dbname = "******************";


	mysql_connect($hostname, $username, $password);// or die(mysql_error());
	mysql_select_db($dbname);

?>