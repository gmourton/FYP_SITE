<?php
include 'core/init.php';
protect_page();

if(isset($_GET['file'])) {
	$file = $_GET['file'];
	
	//check if file exists in the dir - if not exit, this might stop dir escilation
	$files = glob('./Useruploadfiles/' . $session_user_id . '/contacts/*.*');
	for ($i=0; $i<count($files); $i++)
	{	
		$num = $files[$i];
		$file2 = basename($num); 
		
		if(strcasecmp($file, $file2) == 0 ) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($num));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($num));
			
			readfile($num);
		}
	}
			
}
?>