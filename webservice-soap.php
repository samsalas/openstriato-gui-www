<?php


class DateServer{
	
	//On déclare notre méthode qui renverra la date et la signature du serveur dans un tableau associatif...
	function retourDate(){
		$sysDate = exec("date");
		$rtcDate = exec("hwclock -r -f /dev/rtc0");
		$infoDate = explode("  ", $sysDate);
		$retValue .= '<div id="date_value"><table id="frequencies_value">';
		$tmp = explode(" ", $infoDate[0]);
		$day = $tmp[0];
		$month = $tmp[1];
		$tmp = explode(" ", $infoDate[1]);
		$year = $tmp[3];
		$time = $tmp[1];
		$dayNo = $tmp[0];
		$retValue .= sprintf('<tr><td width="100">System Time</td><td><span style="color:green">%s %s %s %s %s</span></td>', $day, $dayNo, $month, $year, $time);
		$infoDate = explode("  ", $rtcDate);
		$tmp = explode(" ", $infoDate[0]);
		$day = $tmp[0];
		$month = $tmp[1];
		$tmp = explode(" ", $infoDate[1]);
		$year = $tmp[2];
		$time = $tmp[1];
		$dayNo = $tmp[0];
		$retValue .= sprintf('<tr><td width="100">RTC Time</td><td><span style="color:green">%s %s %s %s %s</span></td>', $day, $dayNo, $month, $year, $time);	
		$retValue .= '</table></div>';
		return $retValue;
	}
}


$serversoap=new SoapServer("http://127.0.0.1/exemple.wsdl");
$serversoap->setClass("DateServer");
$serversoap->handle();

?>
