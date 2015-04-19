<?php

function showMenu($activeMenu) {
	$menuToShow = 	array(	"0"=> array("Name" => "Home", "URL" => "index.php"),
						"1" => array("Name" => "Configuration", "URL" => "configuration.php"),
						"2" => array("Name" => "Commands", "URL" => "commands.php"),
						"3" => array("Name" => "Controls", "URL" => "webservice-client.php"),
						"4" => array("Name" => "Network", "URL" => "network.php"),
						"5" => array("Name" => "Upload", "URL" => "fileupload.php")
				);
				
	echo '<div class="navbar navbar-inverse navbar-fixed-top">
		  <div class="navbar-inner">
			<div class="container">
			  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </a>
			  <a class="brand" href="#">OPENSTRIATO</a>
			  <div class="nav-collapse collapse">
				<ul class="nav">';
				$i = 0;
				foreach ($menuToShow as $v) {			
						if ($activeMenu==$i) {
							echo '<li class="active">';
						} else {
							echo '<li>';
						}
						echo "<a href=".$v["URL"].">".$v["Name"]."</a>";
						$i++;
				}
	echo 		'</ul>
			  </div>
			</div>
		  </div>
		</div>';
}
?>
