<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>OPENSTRIATO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Samuel Salas">

    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px;       }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

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
	showMenu(2); // See Menu.php to check the menu number
?>

    <div class="container">
	
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
		} else {
			echo "kill";
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
	
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>
