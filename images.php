<?php 
include 'core/init.php';
protect_page();

$images = glob('./Useruploadfiles/' . $session_user_id . '/images/thumbs/*.*');
$redirect = "./Useruploadfiles/" . $session_user_id . "/images/";

include 'includes/overall/header.php'; ?>
<nav>
	<ul>
		<li><a href="frontimage.php">Front Images</a></li>
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