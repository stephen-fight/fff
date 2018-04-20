<?php
require_once 'data.php';
$ServerName = $_SERVER ["SERVER_NAME"];
$ServerPort = $_SERVER ["SERVER_PORT"];
$serverip = $_SERVER ["REMOTE_ADDR"];
$url_this =  "http://".$_SERVER ['HTTP_HOST'].$_SERVER["REQUEST_URI"];
$Url = "http://" . $ServerName;
If ($ServerPort != "80") {
	$Url = $Url . ":" . $ServerPort;
} else {
	$Url = $_SERVER ['HTTP_REFERER'];
}
$GetLocationURL = $Url;
$agent1 = $_SERVER ["HTTP_USER_AGENT"];
$agent = strtolower ( $agent1 );
$Bot = "";

if (stripos ( $agent, "baiduspider" ) > - 1) {
	$Bot = "Baidu蜘蛛";
} else if (stripos ( $agent, "sogou" ) > - 1) {
	$Bot = "Sogou蜘蛛";
} else if (stripos ( $agent, "Yisouspider" ) > - 1) {
	$Bot = "神马蜘蛛aaaa";
} else if (stripos ( $agent, "360Spider" ) > - 1 || stripos ( $agent, "HaosouSpider" ) > - 1) {
	$Bot = "360蜘蛛";
} else if (stripos ( $agent, "bingbot " ) > - 1) {
	$Bot = "必应";
} 

date_default_timezone_set('PRC');
$shijian = date ( "Y-m-d h:i:s", time () );
define ( 'IP_FILE', "incs/zhizhu.txt" );
$ip = getip().'---'.$Bot.'---'.$url_this.'---'.$shijian;

if (!empty($Bot) && !file_exists(IP_FILE)){
	write(IP_FILE,$ip);
} else if (!empty($Bot) && file_exists(IP_FILE)){
	$i=count(file(IP_FILE));
	$oldip=read(IP_FILE);
	$newip=$ip."\r\n";
	$iplist=$newip.$oldip;
	write(IP_FILE,$iplist);
}
?>
