  
<?php 


####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### #######

// Convertisseur d'octet
// $entree = 'octet' ou 'kotect'
function convert_octet($intOctet, $entree, $intPrecision = 2)
{
	if ($entree == 'octet')
	{
		if ($intOctet >= 1073741824)
		{
			$resultat = $intOctet / 1073741824;
			$resultat_unit = ' Go';
		}
		elseif ($intOctet >= 1048576)
		{
			$resultat = $intOctet / 1048576;
			$resultat_unit = ' Mo';
		}
		else
		{
			$resultat = $intOctet / 1024;
			$resultat_unit = ' Ko';
		}
	}
	elseif ($entree == 'koctet')
	{
		if ($intOctet >= 1073741824)
		{
			$resultat = $intOctet / 1073741824;
			$resultat_unit = ' To';
		}
		elseif ($intOctet >= 1048576)
		{
			$resultat = $intOctet / 1048576;
			$resultat_unit = ' Go';
		}
		elseif ($intOctet >= 1024)
		{
			$resultat = $intOctet / 1024;
			$resultat_unit = ' Mo';
		}
		else
		{
			$resultat = $intOctet;
			$resultat_unit = ' Ko';
		}	
	}

	return round($resultat, $intPrecision).$resultat_unit;
}


####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### #######


// Retourne l'uptime
// echo uptime();
function uptime()
{
	$result = NULL;
	
	$fd = fopen('/proc/uptime', 'r');
	$ar_buf = split(' ', fgets($fd, 4096));
	fclose($fd);

	$sys_ticks = trim($ar_buf[0]);
	$min = $sys_ticks / 60;
	$heures = $min / 60;
	$jours = floor($heures / 24);
	$heures = floor($heures - ($jours * 24));
	$min = floor($min - ($jours * 60 * 24) - ($heures * 60));
	
	$text['jours'] = 'day(s)';
	$text['heures'] = 'hour(s)';
	$text['minutes'] = 'minute(s)';

	if ($jours != 0)
	{
		if ($jours < 2) $text['jours'] = 'day(s)';
		$result .= $jours.' '.$text['jours'].' ';
	}

	if ($heures != 0)
	{
		if ($heures < 2) $text['heures'] = 'hour(s)';
   		$result .= $heures.' '.$text['heures'].' ';
	}

	if ($min < 2) $text['minutes'] = 'minute(s)';

	$result .= $min.' '.$text['minutes'];

	return $result;
}


####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### #######

// Retourne la charge du CPU
// echo loadaverage();
function loadaverage()
{
	exec('uptime', $exec); // On exécute la commande "uptime"
	
	preg_match('/(load.*)/', $exec[0], $LA); // On cherche le load average
	
	$result = strstr($LA[1], ':'); // On cherche les :
	$result = substr($result, 1); // On les enlève
	
	return $result;
}


####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### #######

// Retourne les infos sur la Ram en fonction du $choix
// Ex. : echo meminfo('pourcent_used');
function meminfo()
{
	$meminfo = file('/proc/meminfo');
	
	for ($i = 0; $i < count($meminfo); $i++)
	{
		list($item, $data) = split(':', $meminfo[$i], 2);
		$item = chop($item);
		$data = chop($data);
		if ($item == 'MemTotal') $total_mem = $data;
		if ($item == 'MemFree') $free_mem = $data;
		if ($item == 'SwapTotal') $total_swap = $data;
		if ($item == 'SwapFree') $free_swap = $data;
		if ($item == 'Buffers') $buffer_mem = $data;
		if ($item == 'Cached') $cache_mem = $data;
		if ($item == 'MemShared') $shared_mem = $data;
	}
	
	$used_mem = $total_mem - $free_mem;
	$used_swap = $total_swap - $free_swap;
	
	$pourcent_free = round($free_mem / $total_mem * 100).'%';
	$pourcent_used = (100 - $pourcent_free).'%';
	$pourcent_swap = round(($total_swap - $free_swap) / $total_swap * 100).'%';
	$pourcent_swap_free = (100 - $pourcent_swap).'%';
	$pourcent_buff = round($buffer_mem / $total_mem * 100).'%';
	$pourcent_cach = round($cache_mem / $total_mem * 100).'%';
	$pourcent_shar = round($shared_mem / $total_mem * 100).'%';
	
	
	$used_mem = str_replace('kB', '', $used_mem);
	$used_swap = str_replace('kB', '', $used_swap);
	$total_mem = str_replace('kB', '', $total_mem);
	$total_swap = str_replace('kB', '', $total_swap);
	
	
	$used_mem = convert_octet($used_mem, 'koctet');
	$used_swap = convert_octet($used_swap, 'koctet');
	$free_mem = convert_octet($free_mem, 'koctet');
	$free_swap = convert_octet($free_swap, 'koctet');
	$total_mem = convert_octet($total_mem, 'koctet');
	$total_swap = convert_octet($total_swap, 'koctet');
	
	$array = array("used_mem" => $used_mem, "used_swap" => $used_swap, "free_mem" => $free_mem, 
		     "free_swap" => $free_swap, "total_mem" => $total_mem, "total_swap" => $total_swap);



	return $array;

}


####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### #######

// Retourne le statut d'un port (ONLINE ou OFFLINE)
// echo check_port(21);
function check_port($port, $tempsmax = 5)
{
	$ip = 'localhost';
	
	$sock = @fsockopen($ip, $port, $num, $error, $tempsmax);

	if ($sock)
	{
		fclose($sock);
		return 1;
	}
	else
	{
		return 0;
	}
	
}

// Retourne les fréquences de CPU (Samuel Salas)
function getfrequencies()
{	
	$cpuclk = @file_get_contents("/sys/devices/system/cpu/cpu0/cpufreq/scaling_cpuclk");
	$lcdclk = exec("cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_lcdclk");
	$cpuclk1 = substr($cpuclk, 5,9);
	$cpuclk2 = substr($cpuclk, 20,9);
	$cpuclk3 = substr($cpuclk, 34,9);
	$cpuclk4 = substr($cpuclk, 49,9);
	
	$arrayclk = array("CPU"=>$cpuclk1,"EMI"=>$cpuclk2,"APBX"=>$cpuclk3,"APBH"=>$cpuclk4,"LCD"=>$lcdclk);
	
	return $arrayclk;
	
}

// Retourne les infos de CPU (Samuel Salas)
function getcpuinfos()
{	
	$cpuinfo = @file_get_contents("/proc/cpuinfo");
	
	return $cpuinfo;
	
}

####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### ####### #######
#  WEBSERVICE
###############################################################################################################

if ($_GET["query"] == "uptime")
{
	$uptime = array("uptime", uptime());
	echo json_encode($uptime);
}
else if ($_GET["query"] == "loadaverage")
{
	$loadaverage = array("loadaverage", loadaverage());
	echo json_encode($loadaverage);
}
else if ($_GET["query"] == "meminfo")
{
	$meminfo = meminfo();
	echo json_encode($meminfo);
}
else if ($_GET["query"] == "services")
{
	$ports = array("ssh" => check_port(22), "http" => check_port(80),"ftp" => check_port(21));
	echo json_encode($ports);
}
else if ($_GET["query"] == "frequencies")
{
	$frequencies = getfrequencies();
	echo json_encode($frequencies);
}
else if ($_GET["query"] == "cpuinfos")
{
	$getcpuinfos = getcpuinfos();
	echo json_encode($getcpuinfos);
}
else 
{
	$all = 	array(	"uptime"=> uptime(), 
			"loadaverage" => loadaverage(),
			"meminfo" => meminfo(),
			"ports" => array("ssh" => check_port(22), "http" => check_port(80), "ftp" => check_port(21)),
			"frequencies" => getfrequencies(),
			"cpuinfos" => getcpuinfos()
		     );

	echo json_encode($all);
}


?>

























