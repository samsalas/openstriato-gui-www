<?php 
// DOWNLOAD
if (isset($_GET['fileDL'])) {
	$dir = "/noalia/www/images/";
	$file = $_GET['fileDL'];
	$full = $dir.$file;

	if (isset($file) && file_exists($full)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($full));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($full));
		ob_clean();
		flush();
		readfile($full);
		exit;
	}
}
// UPLOAD
 else if (isset($_FILES['fileUP'])) {
	$dir = "/noalia/www/images/";
	if ($_FILES['fileUP']['error']) {     
		$display_fileup = '<div class="alert alert-error">Error in file upload</div>';
	} 
	else {
		if(($_FILES['fileUP']['type']=="image/png")||($_FILES['fileUP']['type']=="image/jpg")||($_FILES['fileUP']['type']=="image/gif"))  {  
			/* Debug File names
			$display_fileup = '<div class="alert alert-error"> TMP file:'
								.$_FILES['fileUP']['tmp_name']
								.'   Sent file:'
								.$dir.$_FILES['fileUP']['name']
								.'   File to replace:'
								.$dir.$_POST['fileUPName']
								.'</div>';
			*/			
			$imageInfo1 = getimagesize($_FILES['fileUP']['tmp_name']); // 0 > width 1 > height
			$imageInfo2 = getimagesize($dir.$_POST['fileUPName']); // 0 > width 1 > height
			if (($imageInfo1[0]==$imageInfo2[0])&&($imageInfo1[1]==$imageInfo2[1])) {
				$error = copy($_FILES['fileUP']['tmp_name'], $dir.$_FILES['fileUP']['name']); 
				if ($error == FALSE) {
					$display_fileup = '<div class="alert alert-error">Error : move_uploaded_file</div>';
				}
				$error = rename($dir.$_FILES['fileUP']['name'],$dir.$_POST['fileUPName']);
				if ($error == FALSE) {
					$display_fileup = '<div class="alert alert-error">Error : rename</div>';
				} else {
					$display_fileup = '<div class="alert alert-success">File "'.$_POST['fileUPName'].'" replaced successfully</div>';					
				}
			} else {
				$display_fileup = '<div class="alert alert-error">Error : Image is not the same size  Sent file:'.$imageInfo1[0].'x'.$imageInfo1[1].' File to replace:'.$imageInfo2[0].'x'.$imageInfo2[1].'</div>';
			}
		} else {
			$display_fileup = '<div class="alert alert-error">Error : file is a '.$_FILES['fileUP']['type'].', should be a PNG, JPG or GIF file</div>';
		}
	}	
}	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>IMX28</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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
	showMenu(2); // See Menu.php to check the menu number
	
	if (isset($display_fileup)) {
		echo $display_fileup;
	}

?>

    <div class="container">

	<table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>File Name</th>
				<th>Size (o)</th>
				<th>W x H (pixels)</th>
			    <th>Type</th>
                <th>Download</th>
				<th>Replace</th>
            </tr>
        </thead>
        <tbody>
		<?php // SHOW IMAGE / NAME / DOWNLOAD
			$dir = "/noalia/www/images/";
			$minidir = "images/";
			if(is_dir($dir))
			  {
				if($handle = opendir($dir))
				{
				  while(($file = readdir($handle)) !== false)
				  {
					if($file != "." && $file != "..")
					{
					  $imageInfo = getimagesize($dir.$file); // 0 > width 1 > height mime > type
					  echo '<tr>';
					  echo '<td><img src="'.$minidir.$file.'"/></td>';
					  echo '<td>'.$file.'</td>';
					  echo '<td>'.filesize($dir.$file).'</td>';
					  echo '<td>'.$imageInfo[0].'x'.$imageInfo[1].'</td>';
					  echo '<td>'.$imageInfo['mime'].'</td>';
					  echo '<td><a href="FileDownload.php?fileDL='.$file.'" class="btn btn-primary">Download</a></td>';
					  echo '<td>'
							.'<form id="FileUploader" action="FileDownload.php" method="post" enctype="multipart/form-data">'
							.'<input type="file" name="fileUP" id="fileUP"><br />'
							.'<input type="hidden" name="fileUPName" id="fileUPName" value="'.$file.'"><br />'
							.'<button id="uploadButton" type="submit" class="btn btn-primary">Replace</button>'
							.'</form>'
							.'</td>';
					  echo '</tr>';
					}
				  }
				  closedir($handle);
				}
			  }
		?>
        </tbody>
    </table>
		
     
    </div> <!-- /container -->
	
    <script src="js/jquery.js"></script>
	<script src="js/jquery.form.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>
