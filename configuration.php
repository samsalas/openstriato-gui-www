<?php 
// DOWNLOAD
$config = simplexml_load_file("/home/pi/openstriato/openstriato.xml");
$values = array();
if($_POST['action'] == 'update') {
	if(isset($config)) {
		foreach ($config->action as $id => $action) {
			$uidtmp = $action['uid'];
			if ($_POST["note$uidtmp"] == "") {
				$notetmp = "no note";
			} else {
				$notetmp = $_POST["note$uidtmp"];
			}
			if ($_POST["$uidtmp"] == "") {
				$actiontmp = "no action";
			} else {
				$actiontmp = $_POST["$uidtmp"];
			}
			if ($action != $actiontmp) {
				$cmd = "/usr/bin/sudo /usr/bin/python2.7 /home/pi/openstriato/openstriato.py -m \"$actiontmp\" -u $uidtmp";
				$handle = popen($cmd, "r");
				array_push($values, fgets($handle));
				$config->action[$id] = $actiontmp;
			} 
			if ($action['note'] != $notetmp) {
				$cmd = "/usr/bin/sudo /usr/bin/python2.7 /home/pi/openstriato/openstriato.py -n \"$notetmp\" -u $uidtmp";
				$handle = popen($cmd, "r");
				array_push($values, fgets($handle));
				$config->action[$id]['note'] = $notetmp;
			}
		}
	}
}
?>

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
	showMenu(1); // See Menu.php to check the menu number
?>

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
		<th>NOTE</th>
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
			echo "<div class=\"input-group\">";
			echo "<span class=\"input-group-addon\" id=\"basic-addon\">#</span>";
			echo "<input class=\"form-control\" placeholder=\"Note\" aria-describedby=\"basic-addon1\" name=\"note".$action["uid"]."\" value=\"".$action["note"]."\" />";
			echo "</div>";	
			echo "</td>\n";
			echo "<td>";
			echo "<div class=\"input-group\">";
			echo "<span class=\"input-group-addon\" id=\"basic-addon\">@</span>";
			echo "<input class=\"form-control\" placeholder=\"Action\" aria-describedby=\"basic-addon1\" name=\"".$action["uid"]."\" value=\"$action\" />";
			echo "</div>";		
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
	
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

  </body>
</html>
