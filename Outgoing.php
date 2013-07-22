<?php 
include 'core/init.php'; 
protect_page();
include 'includes/overall/header.php'; 

//need to create a function to return all devices assosiated with the user, then
if(empty($_POST) === false) {
	header('Location: Outgoing.php');
	exit();
}

?>

<h1>Outgoing calls</h1>
<?php 
if(is_any_devices($session_user_id) === true) {
	$uids = get_array_of_devices($session_user_id); 
	//loop through devices and just print them for now
	foreach ($uids as $uid => $value) {
		//send the device to a function to return all numbers assosiated with it then print out
		?><table><tr><td>Number</td><td>Date</td></tr><?php
		$output = get_outgoing_numbers($value);
		//loop through the output
		foreach ($output as $out => $outValue) {
			//foreach ($outValue as $key => $data) {
				echo "<tr><td>" . $outValue['number'] . "</td><td>" . $outValue['date'] . "</td></tr>";
			//}
		}
    }
	?>
	</table><?php
} else {
	echo 'There are no devices registered with this account. To register devices, install the software.';
}
		


include 'includes/overall/footer.php'; ?>