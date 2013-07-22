<?php 
include 'core/init.php'; 
protect_page();

if(empty($_POST) === false) {
	echo 'Posted data';
	$varuid = $_POST['uniquids'];
	$varstate = $_POST['dates'];
	echo $varuid;
	echo $varstate;
	//die();
	header('Location: locate.php');
	exit();
}
?>
<!doctype html>
<html>
	<script type="text/javascript">

	//must create an array of values from php and loop through them in the function below
	//prob going to have to be a json array
		function showLocations(js)
		{
			//var myLatlng = new google.maps.LatLng(52.814941200319, -2.1009076940144);
			for (var key in js)
			{
			   if (js.hasOwnProperty(key))
			   {
				  // here you have access to
				  var lon = js[key].lon;
				  var lat = js[key].lat;
				  console.log(lon + " " + lat);
				  var myLatlng = new google.maps.LatLng(lat, lon);
				  var marker = new google.maps.Marker({
					position: myLatlng,
					map: map,
					title:"TEST!"
					});
			   }
			}
			// var marker = new google.maps.Marker({
			// position: myLatlng,
			// map: map,
			// title:"TEST!"
			// });
			
		  
		}
    </script>
<?php 
if(is_any_devices($session_user_id) === true) {
	//$list = list_devices($session_user_id);
	$uids = get_array_of_devices($session_user_id);
	//CHANGE THIS 
	if($uids != null) {
		$test = return_dates($uids[0]);
	}
	?>
<?php  include 'includes/head.php'; ?>
<body onload="initialize()">
    <?php  include 'includes/header.php'; ?>
    <div id="container">
        
		<aside>
			<?php 
			if(logged_in() === true) {
				include 'includes/widgets/loggedin.php';
				include 'includes/widgets/locationcontrols.php';
			} else {
				include 'includes/widgets/login.php';
			}		
			?>
		</aside>
		
		<div id="map-canvas"></div>	
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100%;}
      body { height: 540px; margin: 0; padding: 0 }
      #container { height: 100%
				 }
	  #map-canvas { height: 100%
				 }
	  
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_1mLXrdFHnq2h2c6mFtziNmRIEOHUmsg&sensor=false">
    </script>
    <script type="text/javascript">
	var map = 0;
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(52.814941200319, -2.1009076940144),
          zoom: 14,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map-canvas"),
            mapOptions);
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
	<?php }
	else {
	 include 'includes/head.php'; ?>
	<body>
		<?php  include 'includes/header.php'; ?>
		<div id="container">
			
			<aside>
				<?php 
				if(logged_in() === true) {
					include 'includes/widgets/loggedin.php';
					include 'includes/widgets/locationcontrols.php';
				} else {
					include 'includes/widgets/login.php';
				}		
				?>
			</aside> <?php
			echo 'There are no devices registered with this account. To register devices, install the software.';
		}?>
    </body>



</div>
	<?php include 'includes/footer.php'; ?>
</body>
</html>