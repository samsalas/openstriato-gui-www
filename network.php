<?php
	// Fonctions
	// Vérifie si la chaîne ressemble à une adresse IP
	function IPValidate($IPtoValidate) {
		//if (preg_match('#^([0-9]{1,3}\.){3}[0-9]{1,3}$#', $IPtoValidate)) {
		if (filter_var($IPtoValidate, FILTER_VALIDATE_IP)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	// show ifconfig
	$str_ifconfig2 = shell_exec("/sbin/ifconfig");

	// lecture fichier /etc/network/interfaces et affichage
	$str_ifconfig 	= @file_get_contents("/etc/network/interfaces");
	$modif = FALSE;
	$str_ifconfig_tmp = strstr($str_ifconfig, 'eth0');
	$conf_str = strstr($str_ifconfig_tmp, 'dhcp', TRUE); // Cherche la première occurence de 'dhcp' et renvoie ce qu'il y a avant
	if (strstr($conf_str, 'eth0')) { // Si 'eth0 est dans la chaîne
		$str_ifconfig_tmp = 'DHCP';
	} else {
		$conf_str = strstr($str_ifconfig_tmp, 'static', TRUE); // Cherche la première occurence de 'static' et renvoie ce qu'il y a avant
		if (strstr($conf_str, 'eth0')) { // Si 'eth0 est dans la chaîne
			$conf_str = strstr($str_ifconfig_tmp, 'static'); // Cherche la première occurence de 'static' et renvoie ce qu'il y a après
			if (strstr($conf_str, 'address')) {
				$address = strstr($conf_str, 'address');
				preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $address, $matches); 
				$address = $matches[0]; 
				if(isset($_POST['address'])) {
					if ((IPValidate($_POST['address'])==TRUE)) {
						if ($address != $_POST['address']) { //Verifie si l'adresse est différente
							$prefix = 'address ';
							$str_ifconfig = str_replace($prefix.$address, $prefix.$_POST['address'],$str_ifconfig);
							$modif = TRUE;
							$address = $_POST['address'];
						}
					} else {
						$display_network .= '<div class="alert alert-error">Error in address</div>';
					}
				}
			}
				
			if (strstr($conf_str, 'netmask')) {
				$netmask = strstr($conf_str, 'netmask');
				preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $netmask, $matches); 
				$netmask = $matches[0]; 
				if(isset($_POST['netmask'])) {
					if ((IPValidate($_POST['netmask'])==TRUE)) {
						if ($netmask != $_POST['netmask']) { //Verifie si l'adresse est différente
							$prefix = 'netmask ';
							$str_ifconfig = str_replace($prefix.$netmask, $prefix.$_POST['netmask'],$str_ifconfig);
							$modif = TRUE;
							$netmask = $_POST['netmask'];
						}
					} else {
						$display_network .= '<div class="alert alert-error">Error in netmask</div>';
					}
				}
			}		
			if (strstr($conf_str, 'network')) {
				$network = strstr($conf_str, 'network');
				preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $network, $matches); 
				$network = $matches[0]; 
				if(isset($_POST['network'])) {
					if (IPValidate($_POST['network'])==TRUE) {
						if ($network != $_POST['network']) { //Verifie si l'adresse est différente
							$prefix = 'network ';
							$str_ifconfig = str_replace($prefix.$network, $prefix.$_POST['network'],$str_ifconfig);
							$modif = TRUE;
							$network = $_POST['network'];
						}
					} else {
						$display_network .= '<div class="alert alert-error">Error in network</div>';
					}
				}
			}
			if (strstr($conf_str, 'gateway')) {
				$gateway = strstr($conf_str, 'gateway');
				preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $gateway, $matches); 
				$gateway = $matches[0]; 
				if(isset($_POST['gateway'])) {
					if (IPValidate($_POST['gateway'])==TRUE) {
						if ($gateway != $_POST['gateway']) { //Verifie si l'adresse est différente
							$prefix = 'gateway ';
							$str_ifconfig = str_replace($prefix.$gateway, $prefix.$_POST['gateway'],$str_ifconfig);
							$modif = TRUE;
							$gateway = $_POST['gateway'];
						}
					} else {
						$display_network .= '<div class="alert alert-error">Error in gateway</div>';
					}
				}
			}		
			if (strstr($conf_str, 'broadcast')) {
				$broadcast = strstr($conf_str, 'broadcast');
				preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", $broadcast, $matches); 
				$broadcast = $matches[0]; 
				if(isset($_POST['broadcast'])) {
					if (IPValidate($_POST['broadcast'])==TRUE) {
						if ($broadcast != $_POST['broadcast']) { //Verifie si l'adresse est différente
							$prefix = 'broadcast ';
							$str_ifconfig = str_replace($prefix.$broadcast, $prefix.$_POST['broadcast'],$str_ifconfig);
							$modif = TRUE;
							$broadcast = $_POST['broadcast'];
						}
					} else {
						$display_network .= '<div class="alert alert-error">Error in broadcast</div>';
					}
				}
			}
		} else {
			$display_network = '<div class="alert alert-error">ERROR: not a static configuration and/or an eth0 device</div>';
		}
		if ($modif == TRUE) {
			file_put_contents("/etc/network/interfaces", $str_ifconfig);
			$display_network = '<div class="alert alert-success">File "/etc/network/interfaces" updated successfully</div>';
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
    <meta name="author" content="">

    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px;       
		}
	  td {
		padding-left: 20px;
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
	showMenu(6);
	if (isset($display_network)) {
		echo $display_network;
	}
?>

	<div class="container">
		<form id="networkFileUpdate" action="network.php" method="post">
		<table><tr>
			<td><h3>Network interfaces</h3></td>
			<td><button id="validateReboot" type="submit" class="btn btn-primary">Modify all infos</button></td>
		</tr></table>
		<div class="container" class="alert alert-success">
		<table>
		 <?php
			echo '<tr><td><h4>IP Address</h4></td><td><input type="text" value="'.$address.'" name="address" id="address"></td></tr>';
			echo '<tr><td><h4>Mask</h4></td><td><input type="text" value="'.$netmask.'" name="netmask" id="netmask"></td></tr>';
			echo '<tr><td><h4>Network</h4></td><td><input type="text" value="'.$network.'" name="network" id="network"></td></tr>';
			echo '<tr><td><h4>Gateway</h4></td><td><input type="text" value="'.$gateway.'" name="gateway" id="gateway"></td></tr>';
			echo '<tr><td><h4>Broadcast</h4></td><td><input type="text" value="'.$broadcast.'" name="broadcast" id="broadcast"></td></tr>';		
		?>
		</table>
		
		</div> <!-- /container -->
		</form>
	</div>

	<div class="container">
		<h3>ifconfig</h3>
		<div class="container" class="alert alert-success">
		<pre>
		<?php echo $str_ifconfig2;?>
		</pre>			
		</div> <!-- /container -->

	</div>
	
	<div class="container">
		<h3>/etc/network/interfaces</h3>
		<div class="container" class="alert alert-success">
		<pre>
		<?php echo $str_ifconfig;?>
		</pre>			
		</div> <!-- /container -->

	</div>

	<div class="container">
		<form id="rebootNetwork" action="network.php" method="post">		
		<table><tr>	
			<td><h3>Validate and reboot</h3></td>
			<td><button id="validateReboot" type="submit" class="btn btn-primary">Validate File and Reboot</button></td>
		</tr></table>
		<input type="hidden" value="OK" name="reboot" id="reboot">
		
		<div class="container" class="alert alert-success">
		<?php 
			if ((isset($_POST['reboot']))&&($_POST['reboot']=='OK')) {
				exec("reboot");
			}
			echo '';
		?>		
		</div> <!-- /container -->
		</form>
	</div>	
	
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>
