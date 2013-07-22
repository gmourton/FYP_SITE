<?php 
include 'core/init.php'; 
protect_page();
include 'includes/overall/header.php'; 

if(empty($_POST) === false) {
	echo 'Posted data';
	$varuid = $_POST['uniquids'];
	$varstate = $_POST['states'];
	//echo $varuid;
	//echo $varstate;
	
	//perhaps get the state,
	if(strcasecmp($varstate, "MAJOR") == 0) {
		//echo
		if(strcasecmp(get_state($varuid), "MINOR") == 0 || strcasecmp(get_state($varuid), "FINE") == 0) {
			//insert start date
			//change to major
			change_state($varuid, $varstate);
			insert_major_start_dates($varuid);
		}
	} else {
		change_state($varuid, $varstate);
	}
	header('Location: devices.php');
	exit();
}

?>
<h1>Devices</h1>

<?php 
if(is_any_devices($session_user_id) === true) {
	$list = list_devices($session_user_id);
	echo $list;
	$uids = get_array_of_devices($session_user_id);
	//$test = get_state("9dfb68f844434fa9");
	//echo $test;
	?>
	<br />
	<br />
	<form action="devices.php" method="post">
		<ul id="changestate">
			<select name="uniquids">
				<?php
					foreach ($uids as $uid => $value) {
						echo '<option value="'. $value .'">'. $value .'</option>';
					}
				?>
			</select>
			<select name="states">
				<option value="FINE">FINE</option>
				<option value="MINOR">MINOR</option>
				<option value="MAJOR">MAJOR</option>
			</select>
			<input type="submit" value="Submit">
		</ul>
	</form>
	
	
	<?php
} else {
	echo 'There are no devices registered with this account. To register devices, install the software.';
}

include 'includes/overall/footer.php'; ?>