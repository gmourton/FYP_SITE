<?php 
include 'core/init.php';
protect_page();

$files = glob('./Useruploadfiles/' . $session_user_id . '/other/*.*');
//$redirect = "./FrontImages/" . $session_user_id . "/";

include 'includes/overall/header.php'; ?>
<nav>
	<ul>
		<li><a href="images.php">Images</a></li>
		<li><a href="frontimage.php">Front Images</a></li>
		<li><a href="contactfiles.php">Contact Files</a></li>
	</ul>
</nav>    <br /><br />

<div>

	<table>
		<tr>
			<th>File Name</th>
		</tr>
		<?php
		for ($i=0; $i<count($files); $i++)
		{	
		?>
		<tr>
			<td>
			<?php
				$num = $files[$i];
				$file = basename($num); 
				echo "<a href=\"downloadother.php?file=$file\">$file</a><br />"; ?>
			<td>
		</tr>
			<?php
		}
		?>
	</table>

</div>

<?php include 'includes/overall/footer.php'; ?>