#!/bin/sh

showCommand()
{
	echo "<h2>$1 : </h2><table>"
	eval "$2 | grep -v "sed" |  sed -e 's/\(\([^ ]\+\)\+\) */<td>\1<\/td>/g' -e 's/^\(.*\)/<tr>\1<\/tr>/g'"
	echo "</table><br/><br/>"
}
echo "Content-type: text/html"
echo ""
echo ""
echo "<html><head>
<link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px;       }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
</head><body>"
echo '
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">IMX53</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
			  <li class="active"><a href="index.php">Home</a></li>
              <li><a href="FileUpload.php">Upload configuration file</a></li>
			  <li><a href="FileDownload.php">Download files</a></li>
			  <li><a href="sysinfo.sh">Monitor via CGI</a></li>
			  <li><a href="sysinfo.php">Monitor via PHP</a></li>
			<li><a href="LedState.php">user Led State</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>'

echo '<div class="container">'
showCommand "Processes" 'ps aux' 
showCommand "Filesystem" 'df -h'
showCommand "Root folder" 'ls -la /'
echo '</div>'

echo "<script type=\"text/javascript\">"
echo 'setTimeout("location.reload(true);",1000);'
echo "</script>"
echo "</body></html>"


