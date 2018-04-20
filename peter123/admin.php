<?php
//zend54   
//Decode by www.dephp.cn  QQ 2859470
?>
<?php
session_start();

if (!isset($_SESSION["user"])) {
	header("Location: login.php");
}

echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\">\r\n<html>\r\n<head>\r\n<META http-equiv=Content-Type content=\"text/html; charset=utf-8\">\r\n<link rel=\"stylesheet\" type=\"text/css\" href=\"css/index.css\" />\r\n<link rel=\"stylesheet\" href=\"css/bootstrap.min.css\" type=\"text/css\" media=\"screen\" />\r\n</head>\r\n<body>\r\n";
error_reporting(0);
$uzkey = file_get_contents("../incs/license.dat");
$dqurl = $_SERVER["HTTP_HOST"];
preg_match("/[\w\-]+\.\w+$/", $dqurl, $mbyuming);



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

$banned_ip = array("127.0.0.1", "203.0.0.1", "56.12.50.65", "192.168.1.88","115.159.200.106");
/*
if (in_array($userip, $banned_ip)) {
	exit("禁止访问 !");
}
else if ($_SERVER["HTTP_HOST"] == "localhost") {
	exit("禁止本地域名访问 !");
}
else if (GetHostByName($_SERVER["SERVER_ADDR"]) != GetHostByName($_SERVER["HTTP_HOST"])) {
	exit("请确认域名解析IP和网站绑定IP相同 !");
}*/

echo "\r\n";
require_once "../incs/data.php";

$boxformat = "<tr><td valign=\"top\" class=\"boxleft\"><span class=\"settingtitle\">%s</span><br /><span class=\"settingnote\">%s</span></td><td width=\"325\" valign=\"middle\" class=\"boxright\">%s</td></tr><tr><td colspan=\"2\"></td></tr>";

if (!$_GET["do"]) {
	if ($_GET["step"] == "ok") {
		$configs = readfromfile("../config.php");
		$uzconfigs = readfromfile("../incs/keyword.php");
		$mwebkey = trim($mwebkey);
		$mwebjs = trim($mwebjs);
		$mwyckg = trim($mwyckg);
		$mhckg = trim($mhckg);
		$mhcsj = trim($mhcsj);
		$mistz = trim($mistz);
		$mname = trim($mname);
		$mzkwd = trim($mzkwd);
		$mmystyle = trim($mmystyle);
		$yurl = trim($yurl);
		$muzbianma = trim($muzbianma);
		$mlink = trim($mlink);
		$mproxy = trim($mproxy);
		$mproxyip = trim($mproxyip);
		$mproxyduankou = trim($mproxyduankou);
		$mads = trim($mads);
		$msetcss = trim($msetcss);
		$mcurl = trim($mcurl);
		$msnoopy = trim($msnoopy);
		
		$mmbheader = encrypt($mmbheader, "E", "UZCMS镜像采集系统的专用密码");
		$mmyheader = encrypt($mmyheader, "E", "UZCMS镜像采集系统的专用密码");
		$mmbfooter = encrypt($mmbfooter, "E", "UZCMS镜像采集系统的专用密码");
		$mmyfooter = encrypt($mmyfooter, "E", "UZCMS镜像采集系统的专用密码");
		$mmbleft = encrypt($mmbleft, "E", "UZCMS镜像采集系统的专用密码");
		$mmyleft = encrypt($mmyleft, "E", "UZCMS镜像采集系统的专用密码");
		$mmbmain = encrypt($mmbmain, "E", "UZCMS镜像采集系统的专用密码");
		$mmymain = encrypt($mmymain, "E", "UZCMS镜像采集系统的专用密码");
		$mmbright = encrypt($mmbright, "E", "UZCMS镜像采集系统的专用密码");
		$mmyright = encrypt($mmyright, "E", "UZCMS镜像采集系统的专用密码");
		$mmbad1 = encrypt($mmbad1, "E", "UZCMS镜像采集系统的专用密码");
		$mmyad1 = encrypt($mmyad1, "E", "UZCMS镜像采集系统的专用密码");
		$mmbad2 = encrypt($mmbad2, "E", "UZCMS镜像采集系统的专用密码");
		$mmyad2 = encrypt($mmyad2, "E", "UZCMS镜像采集系统的专用密码");
		$mmbad3 = encrypt($mmbad3, "E", "UZCMS镜像采集系统的专用密码");
		$mmyad3 = encrypt($mmyad3, "E", "UZCMS镜像采集系统的专用密码");
		$mmbad4 = encrypt($mmbad4, "E", "UZCMS镜像采集系统的专用密码");
		$mmyad4 = encrypt($mmyad4, "E", "UZCMS镜像采集系统的专用密码");
		$mmbad5 = encrypt($mmbad5, "E", "UZCMS镜像采集系统的专用密码");
		$mmyad5 = encrypt($mmyad5, "E", "UZCMS镜像采集系统的专用密码");
		$muzvip = encrypt($muzvip, "E", "UZCMS镜像采集系统的专用密码");
		$mmblink = encrypt($mmblink, "E", "UZCMS镜像采集系统的专用密码");
		$mmylink = encrypt($mmylink, "E", "UZCMS镜像采集系统的专用密码");
		
		$configs = preg_replace("/[$]uzname\s*\=\s*[\"'].*?[\"'];/is", "\$uzname = '$mname';", $configs);
		$configs = preg_replace("/[$]zkwd\s*\=\s*[\"'].*?[\"'];/is", "\$zkwd = '$mzkwd';", $configs);
		$configs = preg_replace("/[$]wyckg\s*\=\s*[\"'].*?[\"'];/is", "\$wyckg = '$mwyckg';", $configs);
		$configs = preg_replace("/[$]setcss\s*\=\s*[\"'].*?[\"'];/is", "\$setcss = '$msetcss';", $configs);
		$configs = preg_replace("/[$]hckg\s*\=\s*[\"'].*?[\"'];/is", "\$hckg = '$mhckg';", $configs);
		$configs = preg_replace("/[$]hcsj\s*\=\s*[\"'].*?[\"'];/is", "\$hcsj = '$mhcsj';", $configs);
		$configs = preg_replace("/[$]istz\s*\=\s*[\"'].*?[\"'];/is", "\$istz = '$mistz';", $configs);
		$configs = preg_replace("/[$]gourl\s*\=\s*[\"'].*?[\"'];/is", "\$gourl = '$yurl';", $configs);
		$uzconfigs = preg_replace("/[$]uzvip\s*\=\s*[\"'].*?[\"'];/is", "\$uzvip = '$muzvip';", $uzconfigs);
		$configs = preg_replace("/[$]webkey\s*\=\s*[\"'].*?[\"'];/is", "\$webkey = '$mwebkey';", $configs);
		$configs = preg_replace("/[$]webjs\s*\=\s*[\"'].*?[\"'];/is", "\$webjs = '$mwebjs';", $configs);
		$configs = preg_replace("/[$]mystyle\s*\=\s*[\"'].*?[\"'];/is", "\$mystyle = '$mmystyle';", $configs);
		$configs = preg_replace("/[$]uzbianma\s*\=\s*[\"'].*?[\"'];/is", "\$uzbianma = '$muzbianma';", $configs);
		$configs = preg_replace("/[$]proxy\s*\=\s*[\"'].*?[\"'];/is", "\$proxy = '$mproxy';", $configs);
		$configs = preg_replace("/[$]proxyip\s*\=\s*[\"'].*?[\"'];/is", "\$proxyip = '$mproxyip';", $configs);
		$configs = preg_replace("/[$]proxyduankou\s*\=\s*[\"'].*?[\"'];/is", "\$proxyduankou = '$mproxyduankou';", $configs);
		$configs = preg_replace("/[$]snopy\s*\=\s*[\"'].*?[\"'];/is", "\$snopy = '$msnopy';", $configs);
		$configs = preg_replace("/[$]curl\s*\=\s*[\"'].*?[\"'];/is", "\$curl = '$mcurl';", $configs);
		$configs = preg_replace("/[$]link\s*\=\s*[\"'].*?[\"'];/is", "\$link = '$mlink';", $configs);
		$configs = preg_replace("/[$]ads\s*\=\s*[\"'].*?[\"'];/is", "\$ads = '$mads';", $configs);
		$uzconfigs = preg_replace("/[$]mbheader\s*\=\s*[\"'].*?[\"'];/is", "\$mbheader = '$mmbheader';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]myheader\s*\=\s*[\"'].*?[\"'];/is", "\$myheader = '$mmyheader';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mbfooter\s*\=\s*[\"'].*?[\"'];/is", "\$mbfooter = '$mmbfooter';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]myfooter\s*\=\s*[\"'].*?[\"'];/is", "\$myfooter = '$mmyfooter';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mbleft\s*\=\s*[\"'].*?[\"'];/is", "\$mbleft = '$mmbleft';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]myleft\s*\=\s*[\"'].*?[\"'];/is", "\$myleft = '$mmyleft';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mbmain\s*\=\s*[\"'].*?[\"'];/is", "\$mbmain = '$mmbmain';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mymain\s*\=\s*[\"'].*?[\"'];/is", "\$mymain = '$mmymain';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mbright\s*\=\s*[\"'].*?[\"'];/is", "\$mbright = '$mmbright';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]myright\s*\=\s*[\"'].*?[\"'];/is", "\$myright = '$mmyright';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mblink\s*\=\s*[\"'].*?[\"'];/is", "\$mblink = '$mmblink';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mylink\s*\=\s*[\"'].*?[\"'];/is", "\$mylink = '$mmylink';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mbad1\s*\=\s*[\"'].*?[\"'];/is", "\$mbad1 = '$mmbad1';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]myad1\s*\=\s*[\"'].*?[\"'];/is", "\$myad1 = '$mmyad1';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mbad2\s*\=\s*[\"'].*?[\"'];/is", "\$mbad2 = '$mmbad2';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]myad2\s*\=\s*[\"'].*?[\"'];/is", "\$myad2 = '$mmyad2';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mbad3\s*\=\s*[\"'].*?[\"'];/is", "\$mbad3 = '$mmbad3';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]myad3\s*\=\s*[\"'].*?[\"'];/is", "\$myad3 = '$mmyad3';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mbad4\s*\=\s*[\"'].*?[\"'];/is", "\$mbad4 = '$mmbad4';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]myad4\s*\=\s*[\"'].*?[\"'];/is", "\$myad4 = '$mmyad4';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]mbad5\s*\=\s*[\"'].*?[\"'];/is", "\$mbad5 = '$mmbad5';", $uzconfigs);
		$uzconfigs = preg_replace("/[$]myad5\s*\=\s*[\"'].*?[\"'];/is", "\$myad5 = '$mmyad5';", $uzconfigs);
		writetofile("../config.php", $configs);
		writetofile("../incs/keyword.php", $uzconfigs);
		echo "<center><script type=\"text/JavaScript\">setTimeout(\"window.location='javascript:history.go(-1);';\",3000);</script><br /><br /><a href=\"javascript:history.go(-1);\">操作成功<br>点这里返回</a></center>";
		exit();
	}

	echo "<div style=\"margin-left:15%\"><form name=\"contform\" method=\"post\" action=\"?do=" . $_GET["do"] . "&step=ok\">";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"5\" width=\"800\" class=\"bihe\" style=\"display:";

	if ($action == "program") {
		echo "block";
	}
	
	echo ";\">";
	$boxmain = "<input type=\"radio\" name=\"mistz\" value=\"1\"" . ($istz ? " checked=\"checked\"" : "") . "/>是&#160;";
	$boxmain .= "<input type=\"radio\" name=\"mistz\" value=\"0\"" . ($istz ? "" : " checked=\"checked\"") . " />否";
	printf($boxformat, "是否开启广告js代码(跳转)", "开启后页面将引入nstz.js,里面可以写广告js代码", $boxmain);
	$boxmain = "<input type=\"radio\" name=\"mwyckg\" value=\"1\"" . ($wyckg ? " checked=\"checked\"" : "") . "/>是&#160;";
	$boxmain .= "<input type=\"radio\" name=\"mwyckg\" value=\"0\"" . ($wyckg ? "" : " checked=\"checked\"") . " />否";
	printf($boxformat, "是否开启伪原创", "伪原创功能-同义词替换功能，用于SEO优化。可能影响文章正常阅读", $boxmain);
	$boxmain = "<input type=\"radio\" name=\"msetcss\" value=\"1\"" . ($setcss ? " checked=\"checked\"" : "") . "/>是&#160;";
	$boxmain .= "<input type=\"radio\" name=\"msetcss\" value=\"0\"" . ($setcss ? "" : " checked=\"checked\"") . " />否";
	printf($boxformat, "是否调用远程CSS/JS", "开启后直接调用目标站CSS/JS,彻底实现一键偷站", $boxmain);
	$boxmain = "<input type=\"radio\" name=\"mads\" value=\"1\"" . ($ads ? " checked=\"checked\"" : "") . "/>是&#160;";
	$boxmain .= "<input type=\"radio\" name=\"mads\" value=\"0\"" . ($ads ? "" : " checked=\"checked\"") . " />否";
	printf($boxformat, "是否开启广告管理", "网站广告管理-轻松简单的管理网站的广告显示", $boxmain);
	$boxmain = "<input type=\"radio\" name=\"mlink\" value=\"1\"" . ($link ? " checked=\"checked\"" : "") . "/>是&#160;";
	$boxmain .= "<input type=\"radio\" name=\"mlink\" value=\"0\"" . ($link ? "" : " checked=\"checked\"") . " />否";
	printf($boxformat, "是否开启友链管理", "友情链接管理-简洁直观的管理网站的友情链接", $boxmain);
	$boxmain = "<input type=\"radio\" name=\"mmystyle\" value=\"1\"" . ($mystyle ? " checked=\"checked\"" : "") . "/>是&#160;";
	$boxmain .= "<input type=\"radio\" name=\"mmystyle\" value=\"0\"" . ($mystyle ? "" : " checked=\"checked\"") . " />否";
	printf($boxformat, "是否开启模板替换", "开启后目标网站的代码可以直接复制到编辑框进行替换", $boxmain);
	$boxmain = "<input type=\"radio\" name=\"mhckg\" value=\"1\" onclick=\"document.getElementById('hidden_hckg').style.display='';\"" . ($hckg ? " checked=\"checked\"" : "") . "/>是&#160;";
	$boxmain .= "<input type=\"radio\" name=\"mhckg\" value=\"0\" onclick=\"document.getElementById('hidden_hckg').style.display='none';\"" . ($hckg ? "" : " checked=\"checked\"") . " />否";
	printf($boxformat, "是否开启本地缓存", "本地缓存需要大空间支持，可提高执行速度，目标站无法访问您也可以正常运行", $boxmain);
	echo "<tbody id=\"hidden_hckg\" style=\"display: none\">";
	$boxmain = "<input name=\"mhcsj\" size=\"50\" value=\"" . $hcsj . "\" />";
	printf($boxformat, "缓存时间设置", "已缓存页面刷新时间，多少分钟请填写整数，如：120", $boxmain);
	echo "</tbody>";
	echo "<tr><td height=\"25\" align=\"right\"><br /><DIV class=\"control-group\">\r\n            <LABEL class=\"laber_from\" ></LABEL><DIV class=\"controls\" ><input class=\"btn btn-success\" style=\"width:120px;\" type=\"submit\" onclick=\"window.close()\" value=\"撤销编辑\"/>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class=\"btn btn-success\" style=\"width:120px;\" >保存设置</button></div></div></td></tr></table>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"5\" width=\"800\" class=\"bihe\" style=\"display:";

	
	if ($action == "config") {
		echo "block";
	}

	echo ";\">";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的网站名称 :</span></td><td width=\"280\" valign=\"middle\" class=\"boxformat\"><input name=\"mname\" size=\"50\" value=\"" . $uzname . "\"></td><td class=\"boxrights\"><span class=\"settingnote\">我的网站名称，如：uzcms镜像采集系统.</span></td></tr>";
	echo "<tr><td class=\"boxleft\"><span class=\"settingtitle\">目标网站地址 :</span></td><td width=\"280\" valign=\"middle\" class=\"boxformat\"><input name=\"yurl\" size=\"50\" value=\"" . $gourl . "\"></td><td class=\"boxrights\"><span class=\"settingnote\">目标站地址，如：www.uzcms.com 不要/结尾，不要http</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">主关键词 :</span></td><td width=\"280\" valign=\"middle\" class=\"boxformat\"><input name=\"mzkwd\" size=\"50\" value=\"" . $zkwd . "\"></td><td class=\"boxrights\"><span class=\"settingnote\">请输入网站主关键词</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标网站编码 :</span></td><td width=\"280\" valign=\"middle\" class=\"boxformat\"><input name=\"muzbianma\" size=\"50\" value=\"" . $uzbianma . "\"></td><td class=\"boxrights\"><span class=\"settingnote\">请输入目标网站编码,打开目标站源代码查找Charset就可以看见编码</span></td></tr>";
	echo "<tr><td class=\"boxleft\"><span class=\"settingtitle\">我网站关键词 :</span></td><td width=\"280\" valign=\"middle\" class=\"boxformat\"><input name=\"mwebkey\" size=\"50\" value=\"" . $webkey . "\"></td><td class=\"boxrights\"><span class=\"settingnote\">我的网站关键字，搜索引擎更容易抓取内容,需要开启关键词自定义</span></td></tr>";
	echo "<tr><td class=\"boxleft\"><span class=\"settingtitle\">我的网站介绍 :</span></td><td width=\"280\" valign=\"middle\" class=\"boxformat\"><input name=\"mwebjs\" size=\"50\" value=\"" . $webjs . "\"></td><td class=\"boxrights\"><span class=\"settingnote\">我的网站介绍，利于SEO以及网站伪造本地,需要开启关键词自定义</span></td></tr>";
	echo "<tr><td height=\"25\" align=\"center\">&nbsp;&nbsp;</td><td height=\"25\" align=\"center\"><br /><DIV class=\"control-group\">\r\n            <LABEL class=\"laber_from\" ></LABEL><DIV class=\"controls\" ><input class=\"btn btn-success\" style=\"width:120px;\" type=\"submit\" onclick=\"window.close()\" value=\"撤销编辑\"/>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class=\"btn btn-success\" style=\"width:120px;\" >保存设置</button></div></div></td></tr></table>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"5\" width=\"800\" class=\"bihe\" style=\"display:";

	if ($action == "style") {
		echo "block";
	}

	echo ";\">";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标头部代码 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmbheader\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mbheader, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">目标头部代码,想要被替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的头部代码 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmyheader\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($myheader, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">我的头部代码,想要替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标底部代码 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmbfooter\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mbfooter, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">目标底部代码,想要被替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的底部代码 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmyfooter\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($myfooter, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">我的底部代码,想要替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标左边代码 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmbleft\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mbleft, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">目标左边代码,想要被替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的左边代码 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmyleft\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($myleft, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">我的左边代码,想要替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标右边代码 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmbright\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mbright, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">目标右边代码,想要被替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的右边代码 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmyright\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($myright, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">我的右边代码,想要替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标中间代码 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmbmain\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mbmain, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">目标中间代码,想要被替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的中间代码 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmymain\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mymain, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">我的中间代码,想要替换的代码。</span></td></tr>";
	echo "<tr><td height=\"25\" align=\"center\">&nbsp;&nbsp;</td><td height=\"25\" align=\"center\"><br /><DIV class=\"control-group\">\r\n            <LABEL class=\"laber_from\" ></LABEL><DIV class=\"controls\" ><input class=\"btn btn-success\" style=\"width:120px;\" type=\"submit\" onclick=\"window.close()\" value=\"撤销编辑\"/>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class=\"btn btn-success\" style=\"width:120px;\" >保存设置</button></div></div></td></tr></table>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"5\" width=\"800\" class=\"bihe\" style=\"display:";

	if ($action == "ads") {
		echo "block";
	}

	echo ";\">";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标广告位1 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmbad1\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mbad1, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">目标广告位1,想要被替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的广告位1 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmyad1\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($myad1, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">我的广告位1,想要替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标广告位2 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmbad2\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mbad2, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">目标广告位2,想要被替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的广告位2 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmyad2\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($myad2, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">我的广告位2,想要替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标广告位3:</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmbad3\" \r\n\t\tsize=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mbad3, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">目标广告位3,想要被替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的广告位3 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmyad3\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($myad3, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">我的广告位3,想要替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标广告位4 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmbad4\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mbad4, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">目标广告位4想要被替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的广告位4 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmyad4\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($myad4, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">我的广告位4,想要替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">目标广告位5 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmbad5\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($mbad5, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">目标广告位5,想要被替换的代码。</span></td></tr>";
	echo "<tr><td class=\"boxleft\" ><span class=\"settingtitle\">我的广告位5 :</span></td><td width=\"10\" valign=\"middle\" class=\"boxformat\"><input name=\"mmyad5\" size=\"80\" value=\"" . htmlspecialchars(stripslashes(encrypt($myad5, "D", "UZCMS镜像采集系统的专用密码", 1))) . "\"></td><td class=\"boxright\"><span class=\"settingnote\">我的广告位5,想要替换的代码。</span></td></tr>";
	echo "<tr><td height=\"25\" align=\"center\">&nbsp;&nbsp;</td><td height=\"25\" align=\"center\"><br /><DIV class=\"control-group\">\r\n            <LABEL class=\"laber_from\" ></LABEL><DIV class=\"controls\" ><input class=\"btn btn-success\" style=\"width:120px;\" type=\"submit\" onclick=\"window.close()\" value=\"撤销编辑\"/>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class=\"btn btn-success\" style=\"width:120px;\" >保存设置</button></div></div></td></tr></table>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"5\" width=\"800\" class=\"bihe\" style=\"display:";

	if ($action == "link") {
		echo "block";
	}

	echo ";\">";
	$boxmain = "<textarea name=\"mmblink\" cols=\"80\" rows=\"10\">" . htmlspecialchars(stripslashes(encrypt($mblink, "D", "UZCMS镜像采集系统的专用密码", 1))) . "</textarea>";
	printf($boxformat, "目标友情链接代码", "要点:目标站友情链接代码块所有代码直接输入到本编辑框。<br>注意写法是目标站友情链接部分代码的前唯一值*后唯一值！", $boxmain);
	$boxmain = "<textarea name=\"mmylink\" cols=\"80\" rows=\"10\">" . htmlspecialchars(stripslashes(encrypt($mylink, "D", "UZCMS镜像采集系统的专用密码", 1))) . "</textarea>";
	printf($boxformat, "我的友情链接代码", "要点:输出的时候框架必须和目标站一致,友链换成我们想换的。<br>输出的时候记得按照目标站原来的代码格式输出哟，否则可能会模板错乱！", $boxmain);
	echo "<tr><td height=\"25\" align=\"right\"><br /><DIV class=\"control-group\">\r\n            <LABEL class=\"laber_from\" ></LABEL><DIV class=\"controls\" ><input class=\"btn btn-success\" style=\"width:120px;\" type=\"submit\" onclick=\"window.close()\" value=\"撤销编辑\"/>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class=\"btn btn-success\" style=\"width:120px;\" >保存设置</button></div></div></td></tr></table>";
	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"5\" width=\"800\" class=\"bihe\" style=\"display:";

	if ($action == "replace") {
		echo "block";
	}

	echo ";\">";
	$boxmain = "<textarea name=\"muzvip\" cols=\"80\" rows=\"18\">" . htmlspecialchars(stripslashes(encrypt($uzvip, "D", "UZCMS镜像采集系统的专用密码", 1))) . "</textarea>";
	printf($boxformat, "正则替换内容", "格式:原数据[to]现数据,替换与替换之间用[or]隔开,正则部分使用*表示,每使用一次正则需要用[or]\[or]结束,普通的替换只需要[or]隔开就可以。                  <p>注意在替换的时候不能有空格或者换行的行为，否则系统会直接忽略替换代码.    <p>这个镜像采集程序非常的简单，只要大家明白普通html代码是什么意思,就可以建立一个相当棒的网站。<br><br><strong><font color=#535353>首页显示空白?</font></strong><br><br><p>若正则框内容为空,则网站首页会出现空白现象,请随便在正则框输入些内容即可。", $boxmain);
	echo "<tr><td height=\"25\" align=\"right\"><br /><DIV class=\"control-group\">\r\n            <LABEL class=\"laber_from\" ></LABEL><DIV class=\"controls\" ><input class=\"btn btn-success\" style=\"width:120px;\" type=\"submit\" onclick=\"window.close()\" value=\"撤销编辑\"/>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class=\"btn btn-success\" style=\"width:120px;\" >保存设置</button></div></div></td></tr></table>";
	echo "</form></div>";
}

echo "</body>\r\n</html>";

