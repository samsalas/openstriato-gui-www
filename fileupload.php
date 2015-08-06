<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>OPENSTRIATO</title>
    <meta name="description" content="">
    <meta name="author" content="Samuel Salas">

<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<style>
	body {
	padding-top: 60px;       }
	</style>
  </head>

  <body>
    <div class="container">

<?php 
	include('menu.php');
	showMenu(5); // See Menu.php to check the menu number
?>

		<h3>Upload a file to the webserver</h3>
		Upload the file in the webserver
<?php
	if (isset($_FILES['file']))
	{
		if ($_FILES['file']['error']) 
		{
			echo '<pre>';
			echo print_r($_FILES);
			echo '</pre>';
			echo '<div class="alert alert-error">Error in file upload, size should be <10M</div>';
		} 
		else 
		{
			if(($_FILES['file']['type']=="image/png")||($_FILES['file']['type']=="image/jpg")
				||($_FILES['file']['type']=="image/jpeg")||($_FILES['file']['type']=="image/gif"))  {
				$imageInfo = getimagesize($chemin_destination.$_FILES['file']['tmp_name']); // 0 > width 1 > height mime > type
				$chemin_destination = '/home/pi/images/';     
				move_uploaded_file($_FILES['file']['tmp_name'], $chemin_destination.$_FILES['file']['name']);	
				echo '<pre>';
				echo print_r($_FILES);
				echo '</pre>';
				echo '<div class="alert alert-success">File uploaded successfully</div>';					
			} else if(($_FILES['file']['type']=="video/mp4"))  {
				$chemin_destination = '/home/pi/video/';     
				move_uploaded_file($_FILES['file']['tmp_name'], $chemin_destination.$_FILES['file']['name']);
				echo '<pre>';
				echo print_r($_FILES);
				echo '</pre>';
				echo '<div class="alert alert-success">File uploaded successfully</div>';					
			} else if(($_FILES['file']['type']=="audio/mp3"))  { // audio/x-ms-wma
				$chemin_destination = '/home/pi/music/';     
				move_uploaded_file($_FILES['file']['tmp_name'], $chemin_destination.$_FILES['file']['name']);
				echo '<pre>';
				echo print_r($_FILES);
				echo '</pre>';
				echo '<div class="alert alert-success">File uploaded successfully</div>';					
			} else {
				echo '<div class="alert alert-error">Error : file is a '.$_FILES['file']['type'].', should be an image (PNG, JPG or GIF), video (mp4) or music (mp3)</div>';
			}
		}
	}
?>

		<form id="FileUploader" action="fileupload.php" method="post" enctype="multipart/form-data">
			<input type="file" name="file" id="file"><br>
			<button id="uploadButton" type="submit" class="btn btn-primary">Upload</button>
		</form>
     
    </div>

    <div class="container">
		<h3>Upload a YOUYUBE video to the webserver</h3>
		Put in the following field the complet YOUTUBE URL
<?php 
if ($_POST['action'] == 'youtube') {
	$cmd = "/usr/bin/sudo /usr/bin/python2.7 /home/pi/openstriato/openstriato.py -y ".$_POST['ytid'];
	$handle = popen($cmd, "r");

	echo '<div class="alert alert-success">YOUTUBE video uploaded successfully<br />';
	echo fgets($handle);
	echo '</div>';
}
?>

 
		<form id="FileUploader" action="fileupload.php" method="post" enctype="multipart/form-data">
			<input type="hidden" name="action" value="youtube"><br>
			<input type="text" name="ytid" value="">
			<button id="uploadButton" type="submit" class="btn btn-primary">Upload youtube video</button>
		</form>
    </div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
