
<?php


if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
	$userip = getenv("HTTP_CLIENT_IP");
}
else {
	if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
		$userip = getenv("HTTP_X_FORWARDED_FOR");
	}
	else {
		if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
			$userip = getenv("REMOTE_ADDR");
		}
		else {
			if (isset($_SERVER["REMOTE_ADDR"]) && $_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknown")) {
				$userip = $_SERVER["REMOTE_ADDR"];
			}
		}
	}
}

$banned_ip = array("203.177.139.14","","127.0.0.1");
if (!in_array($userip, $banned_ip)) {
	echo "您的ip为:".$banned_ip;
	exit("禁止访问 !");
} 


require_once "../incs/data.php";

/**
	uzname我的网站介绍
	gourl目标站地址
	zkwd主关键词
	uzbianma编码
	webkey我网站关键词
	webjs我的网站描述
	
	uzvip正则替换
**/
$mbheader = stripslashes(encrypt($mbheader, "D", "UZCMS镜像采集系统的专用密码", 1));
$myheader = stripslashes(encrypt($myheader, "D", "UZCMS镜像采集系统的专用密码", 1));
$mbfooter = stripslashes(encrypt($mbfooter, "D", "UZCMS镜像采集系统的专用密码", 1));
$myfooter = stripslashes(encrypt($myfooter, "D", "UZCMS镜像采集系统的专用密码", 1));
$mbleft = stripslashes(encrypt($mbleft, "D", "UZCMS镜像采集系统的专用密码", 1));
$myleft = stripslashes(encrypt($myleft, "D", "UZCMS镜像采集系统的专用密码", 1));
$mbright = stripslashes(encrypt($mbright, "D", "UZCMS镜像采集系统的专用密码", 1));
$myright = stripslashes(encrypt($myright, "D", "UZCMS镜像采集系统的专用密码", 1));
$mbmain = stripslashes(encrypt($mbmain, "D", "UZCMS镜像采集系统的专用密码", 1));
$mymain = stripslashes(encrypt($mymain, "D", "UZCMS镜像采集系统的专用密码", 1));

$mbad1 = stripslashes(encrypt($mbad1, "D", "UZCMS镜像采集系统的专用密码", 1));
$myad1 = stripslashes(encrypt($myad1, "D", "UZCMS镜像采集系统的专用密码", 1));
$mbad2 = stripslashes(encrypt($mbad2, "D", "UZCMS镜像采集系统的专用密码", 1));
$myad2 = stripslashes(encrypt($myad2, "D", "UZCMS镜像采集系统的专用密码", 1));
$mbad3 = stripslashes(encrypt($mbad3, "D", "UZCMS镜像采集系统的专用密码", 1));
$myad3 = stripslashes(encrypt($myad3, "D", "UZCMS镜像采集系统的专用密码", 1));
$mbad4 = stripslashes(encrypt($mbad4, "D", "UZCMS镜像采集系统的专用密码", 1));
$myad4 = stripslashes(encrypt($myad4, "D", "UZCMS镜像采集系统的专用密码", 1));
$mbad5 = stripslashes(encrypt($mbad5, "D", "UZCMS镜像采集系统的专用密码", 1));
$myad5 = stripslashes(encrypt($myad5, "D", "UZCMS镜像采集系统的专用密码", 1));

$mblink = stripslashes(encrypt($mblink, "D", "UZCMS镜像采集系统的专用密码", 1));
$mylink = stripslashes(encrypt($mylink, "D", "UZCMS镜像采集系统的专用密码", 1));

$uzvip = stripslashes(encrypt($uzvip, "D", "UZCMS镜像采集系统的专用密码", 1));


$arr = array ('uzname'=>$uzname,'gourl'=>$gourl,'zkwd'=>$zkwd,'uzbianma'=>$uzbianma,'webkey'=>$webkey,'webjs'=>$webjs,
			  'header'=>array($mbheader,$myheader),'footer'=>array($mbfooter,$myfooter),'left'=>array($mbleft,$myleft),'right'=>array($mbright,$myright),'main'=>array($mbmain,$mymain),
			  'ad1'=>array($mbad1,$myad1),'ad2'=>array($mbad2,$myad2),'ad3'=>array($mbad3,$myad3),'ad4'=>array($mbad4,$myad4),'ad5'=>array($mbad5,$myad5),
			  'link'=>array($mblink,$mylink),'uzvip'=> $uzvip);
		
echo json_encode($arr);

?>
