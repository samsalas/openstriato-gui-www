

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
	showMenu(5); // See Menu.php to check the menu number
?>

    <div class="container">

     <div id="uptime">
	<h3> Uptime </h3>
	<div id="uptime_value"></div>
     </div>

     <div id="meminfo">
	<h3> Random Access Memory </h3>
	<div id="meminfo_value"></div>
     </div>

     <div id="cpu">
	<h3> CPU </h3>
	<div>
		<pre id="cpu_value"></pre>
		<pre id="cpu_infos"></pre>
	</div>
     </div>

     <div id="ports">
	<h3> Ports </h3>
	<div id="ports_value">
		<table id="ports_value">
			
		</table>
	</div>
     </div>

    <div id="frequencies">
	<h3> Frequencies (Hz)</h3>
	<div id="frequencies_value">
		<table id="frequencies_value">
			
		</table>
	</div>
     </div>
	 
	<div id="Date">
		<h3>Date</h3>
	<?php
		$service=new SoapClient("http://127.0.0.1/exemple.wsdl");
		$taballservices=$service->retourDate();
		print_r($taballservices);
	?>
	</div>
	
    <script src="js/jquery.js"></script>
    <script src="js/soapclient.js"></script>
    <script src="js/bootstrap.js"></script>

<script language="javascript" type="text/javascript">

    $(function () {

        var getData = function () {
            $.getJSON('webservice.php', function (data) {
             
            $("#uptime_value").html(data.uptime);
			var showMem;
			showMem  = "<tr><td width=100>Used/Total</td><td><span style='color:green'>"+data.meminfo.used_mem+"/"+data.meminfo.total_mem+"</span></td></tr>";
			showMem  += "<tr><td width=100>Free/Total</td><td><span style='color:green'>"+data.meminfo.free_mem+"/"+data.meminfo.total_mem+"</span></td></tr>";
		    $("#meminfo_value").html(showMem);
		    $("#cpu_value").html(data.loadaverage);
			$("#cpu_infos").html(data.cpuinfos);
		    var freqs;
		    for(key in data.frequencies) {
				freqs  += "<tr><td width=100>" + key + "</td><td><span style='color:green'>"+data.frequencies[key]+"</span></td></tr>";
			}
			$("#frequencies_value").html(freqs);
			
		    var ports;
		    for(key in data.ports) {
		  	ports  += "<tr><td width=100>" + key + "</td><td>";
			
			if (data.ports[key] == 1)
			{
				ports +=  "<span style='color:green'> OPEN </span> </td></tr>";
			} 
			else
			{
				ports += "<span style='color:red'> CLOSED </span></td></tr>";
			}
		    }

		   $("#ports_value").html(ports);
		    
		    console.log(data);
                

                setTimeout(getData, 100);
            });
			
			
			
        }


        setTimeout(getData, 100);

    });
</script>

  </body>
</html>
