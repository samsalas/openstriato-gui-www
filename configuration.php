<?php 
// DOWNLOAD
$config = simplexml_load_file("/home/pi/openstriato/openstriato.xml");
$values = array();
if($_POST['action'] == 'update') {
	if(isset($config)) {
		foreach ($config->action as $id => $action) {
			$uidtmp = $action['uid'];
			$actiontmp = $_POST["$uidtmp"];
			if ($action != $actiontmp) {
				$cmd = "/usr/bin/sudo /usr/bin/python2.7 /home/pi/openstriato/openstriato.py -m \"$actiontmp\" -u $uidtmp";
				$handle = popen($cmd, "r");
				array_push($values, fgets($handle));
				$config->action[$id] = $actiontmp;
			}
		}
	}
}
?>

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
	showMenu(1); // See Menu.php to check the menu number
?>
	
    <div class="container">

<?php
	if (count($values) > 0) {
		$displayformupdate = "none";
		$displayformrefresh = "block";
		echo "<div class=\"alert alert-success\">\n
			Modifications uploaded successfully <br />\n
			<ul>\n";
		foreach($values as $value){
			echo "<li />$value\n";
		}
		echo "</ul>\n
			</div>\n";
	} else {
		$displayformupdate = "block";
		$displayformrefresh = "none";
	}
?>


<?php 
	echo "<form id=\"updatexml\" action=\"configuration.php\" method=\"post\" style=\"display: $displayformupdate\">"
?>
	<table class="table">
        <thead>
            <tr>
                <th>UID</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
	
<?php // SHOW IMAGE / NAME / DOWNLOAD
	if (isset($config)) {
		foreach ($config->action as $action) {
			echo "<tr>\n";
			echo "<td>";
			echo $action["uid"];
			echo "</td>\n";
			echo "<td>";
			echo "<input class=\"input-xxlarge\" type=\"text\" name=\"".$action["uid"]."\" value=\"$action\" />";
			echo "</td>\n";
			echo "</tr>\n";
		}
	}
?>

        </tbody>
    </table>
		
	<input type="hidden" name="action" value="update" />
	<button id="validateReboot" type="submit" class="btn btn-primary">Update</button>
	</form> 
<?php 
	echo "<form id=\"refreshxml\" action=\"configuration.php\" method=\"post\" style=\"display: $displayformrefresh\">"
?>
	<input type="hidden" name="action" value="refresh" />
	<button id="validateReboot" type="submit" class="btn btn-primary">OK</button>
	</form> 
    </div> <!-- /container -->
	
    <script src="js/jquery.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>
