<?php 
include 'core/init.php';
protect_page();

$images = glob('./FrontImages/' . $session_user_id . '/thumbs/*.*');
$redirect = "./FrontImages/" . $session_user_id . "/";

include 'includes/overall/header.php'; ?>
<nav>
	<ul>
		<li><a href="images.php">Images</a></li>
		<li><a href="contactfiles.php">Contact Files</a></li>
		<li><a href="other.php">Other</a></li>
	</ul>
</nav>    <br /><br />

<div>
	<?php
	
	for ($i=0; $i<count($images); $i++)
	{	
		$num = $images[$i];
		$file = basename($num); 
		echo '<a href="'.$redirect . $file.'"><img src="'.$num.'" alt="random image"></a>'."&nbsp;&nbsp;";
	}

	
	?>
</div>

<?php include 'includes/overall/footer.php'; ?>