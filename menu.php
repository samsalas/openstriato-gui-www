<?php

function showMenu($activeMenu) {
	$menuToShow = 	array(	"0"=> array("Name" => "Home", "URL" => "index.php"),
						"1" => array("Name" => "Configuration", "URL" => "configuration.php"),
						"2" => array("Name" => "Commands", "URL" => "commands.php"),
						"3" => array("Name" => "Controls", "URL" => "webservice-client.php"),
						"4" => array("Name" => "Network", "URL" => "network.php"),
						"5" => array("Name" => "Upload", "URL" => "fileupload.php")
				);
				
	echo '<!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Open Striato</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">';
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
	echo 		'          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>';
				
}
?>
