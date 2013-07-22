<?php
	$json = $_SERVER['HTTP_JSON'];
	echo "JSON: \n";
	echo "--------------\n";
	echo $json;
	echo "\n\n";

	$data = json_decode($json);
	echo "Array: \n";
	echo "--------------\n";
	print_r($data);
	echo "\n\n";

	$name = $data->UID;
	$pos = $data->position;
	echo "Result: \n";
	echo "--------------\n";
	echo "Name     : ".$name."\n Position : ".$pos; 
?>
