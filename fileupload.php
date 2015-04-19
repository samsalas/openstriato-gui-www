<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OPENSTRIATO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Samuel Salas">
    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <!-- Fav and touch icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="../assets/ico/favicon.png">
  </head>

  <body>

<?php 
	include('menu.php');
	showMenu(5); // See Menu.php to check the menu number
?>

    <div class="container">
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
    <script src="js/jquery.js"></script>
	<script src="js/jquery.form.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>
