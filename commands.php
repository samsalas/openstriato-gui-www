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
	showMenu(2); // See Menu.php to check the menu number
?>


	
	 <?php 

	// VIDEO
	if (isset($_POST['VIDEO'])) {
		//$cmd = "/usr/bin/sudo /usr/bin/python /home/pi/openstriato/openstriato.py -d 8D73F44C";
		$cmd = "/usr/bin/sudo /usr/bin/omxplayer -o hdmi /home/pi/video/ouioui.mp4";
		echo "Action($handle): $cmd";
		$handle = popen($cmd, "r");
	}
	// MUSIC
	if (isset($_POST['MUSIC'])) {
		$cmd = "/usr/bin/sudo /usr/bin/omxplayer -o hdmi /home/pi/music/example.mp3";	
		echo "Action($handle): $cmd";
		$handle = popen($cmd, "r");
	}
	// IMAGE
	if (isset($_POST['IMAGE'])) {
		$cmd = "/usr/bin/sudo /usr/bin/fim -a /home/pi/images/openstriato.jpg";	
		echo "Action($handle): $cmd";
		$handle = popen($cmd, "r");
	}
	// REBOOT
	if (isset($_POST['REBOOT'])) {
		if ($_POST['REBOOT']=='OK') {
			$cmd = "/usr/bin/sudo reboot";
			$handle = popen($cmd, "r");
		}
	}
	// POOLING
	if (isset($_POST['POOLING'])) {
		if ($_POST['POOLING']=="START") {
			$cmd = "/usr/bin/sudo /usr/bin/python2.7 /home/pi/openstriato/openstriato.py -r start";
			$handle = popen($cmd, "r");
			echo $cmd;
		} else if ($_POST['POOLING']=="STOP") {
			$cmd = "/usr/bin/sudo /usr/bin/python2.7 /home/pi/openstriato/openstriato.py -s";
			$handle = popen($cmd, "r");
			echo $cmd;
		}
	}	
	
	echo '
	<form action="commands.php" method="post">
	
	<table>
		<tr>
			<td><h3>Test</h3></td>
			<td>
			<table>
				<tr>
				<td><INPUT TYPE = "Submit" class="btn btn-primary" Name = "VIDEO" VALUE = "VIDEO"></td>
				<td><INPUT TYPE = "Submit" class="btn btn-primary" Name = "MUSIC" VALUE = "MUSIC"></td>
				<td><INPUT TYPE = "Submit" class="btn btn-primary" Name = "IMAGE" VALUE = "IMAGE"></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td><h3>Reboot</h3></td>
			<td>
			<table>
				<tr>
				<td><INPUT TYPE = "Submit" class="btn btn-primary" Name = "REBOOT" VALUE = "OK"></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td><h3>Pooling</h3></td>
			<td>
			<table>
				<tr>
				<td><INPUT TYPE = "Submit" class="btn btn-primary" Name = "POOLING" VALUE = "START"></td>
				<td><INPUT TYPE = "Submit" class="btn btn-primary" Name = "POOLING" VALUE = "STOP"></td>
				</tr>
			</table>
			</td>
		</tr>
	</table>	
	</form>
	'	
	?>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
