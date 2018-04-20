<?php
//zend54   
//Decode by www.dephp.cn  QQ 2859470
?>
<?php
session_start();

if (!isset($_SESSION["user"])) {
	header("Location: login.php");
}

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n<head>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n<title>UZCMS镜像采集系统旗舰版</title>\r\n\r\n<link rel=\"stylesheet\" href=\"css/index.css\" type=\"text/css\" media=\"screen\" />\r\n<link rel=\"shortcut icon\" href=\"/favicon.ico\"> \r\n<script type=\"text/javascript\" src=\"js/jquery.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"js/tendina.min.js\"></script>\r\n<script type=\"text/javascript\" src=\"js/common.js\"></script>\r\n</head>\r\n";
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
}
*/
echo "";
echo "<body>\r\n    <!--顶部-->\r\n\r\n    <div class=\"layout_top_header\">\r\n            <div style=\"float: left\">
	<span style=\"font-size: 16px;line-height: 45px;padding-left: 20px;color: #8d8d8d\">UZCMS镜像采集系统管理后台</h1></span><span style=\"font-size: 10px;line-height: 45px;padding-left: 20px;color: #8d8d8d\">本后台为HTML5编写 使用低版本IE浏览器可能会出现显示不全以及错位等错误</span> </div>\r\n   \r\n\t\t\t\t\t\t
 <div id=\"ad_setting\" class=\"ad_setting\">\r\n\t\t\t\t\r\n        <a class=\"ad_setting_a\" href=\"logout.php\">\r\n       	        <i class=\"icon-user glyph-icon\" style=\"font-size: 20px\"></i>\r\n      <span>退出系统</span>\r\n     <i class=\"icon-chevron-down glyph-icon\"></i>\r\n                </a>\r\n            </div>\r\n\t\t\t 
 <div id=\"ad_setting\" class=\"ad_setting\">\r\n\t\t\t              <a class=\"ad_setting_a\" href=\"/\" target=\"_blank\">\r\n        <i class=\"icon-user glyph-icon\" style=\"font-size: 20px\"></i>\r\n      <span>网站首页</span>\r\n                    <i class=\"icon-chevron-down glyph-icon\"></i>\r\n                </a>\r\n\t\t\t\t</div>\r\n    </div>\r\n    <!--顶部结束-->\r\n    
 <!--菜单-->\r\n\r\n    <div class=\"layout_left_menu\">\r\n        <ul id=\"menu\">\r\n\t\t\r\n                                      <li class=\"childUlLi\">\r\n                <a href=\"#\"  target=\"menuFrame\"> <i class=\"glyph-icon icon-reorder\"></i>配置网站</a>\r\n                <ul>\r\n              \r\n                    <li><a href=\"admin.php?action=config\" target=menuFrame><i class=\"glyph-icon icon-chevron-right\"></i>镜像设置</a></li>\r\n                    <li><a href=\"admin.php?action=program\" target=menuFrame><i class=\"glyph-icon icon-chevron-right\"></i>网站功能</a></li>\r\n\t\t\t\t\t<li><a href=\"admin.php?action=ads\" target=menuFrame><i class=\"glyph-icon icon-chevron-right\"></i>广告管理</a></li>\r\n\t\t\t\t\t<li><a href=\"admin.php?action=link\" target=menuFrame><i class=\"glyph-icon icon-chevron-right\"></i>友链管理</a></li>\r\n                    <li><a href=\"admin.php?action=style\" target=menuFrame><i class=\"glyph-icon icon-chevron-right\"></i>模板替换</a></li>\r\n\t\t\t\t\t<li><a href=\"admin.php?action=replace\" target=menuFrame><i class=\"glyph-icon icon-chevron-right\"></i>正则匹配</a></li>\r\n             </ul>\r\n            </li>\r\n\r\n            <li class=\"childUlLi\">\r\n                <a href=\"#\" target=\"menuFrame\"> <i class=\"glyph-icon icon-reorder\"></i>系统管理</a>\r\n                <ul>\r\n                    <li><a href=\"user.php\" target=menuFrame><i class=\"glyph-icon icon-chevron-right\"></i>修改密码</a></li>\r\n                           </ul>\r\n            </li>\r\n            <li class=\"childUlLi\">\r\n                <a href=\"#\"> <i class=\"glyph-icon  icon-location-arrow\"></i>常用功能</a>\r\n                <ul>\r\n                    <li><a href=\"cache.php\" target=menuFrame><i class=\"glyph-icon icon-chevron-right\"></i>清理缓存</a></li>\r\n                    <li><a href=\"zhizhu.php\" target=menuFrame><i class=\"glyph-icon icon-chevron-right\"></i>蜘蛛记录</a></li>\r\n     <li><a href=\"welcom.php\" target=\"menuFrame\"><i class=\"glyph-icon icon-chevron-right\"></i>网站提交</a></li>\r\n             </ul>\r\n            </li>      </ul>\r\n\r\n    </div>\r\n\r\n\t<!--菜单-->\r\n\r\n    <div id=\"layout_right_content\" class=\"layout_right_content\">\r\n\r\n        <div class=\"route_bg\">\r\n            <a href=\"#\">当前位置：</a><i class=\"glyph-icon icon-chevron-right\"></i>\r\n        </div>\r\n        <div class=\"mian_content\">\r\n            <div id=\"page_content\">\r\n                <iframe id=\"menuFrame\" name=\"menuFrame\" src=\"admin.php?action=config\" style=\"overflow:visible;\" scrolling=\"aotu\" frameborder=0 width=\"100%\" height=\"100%\" onload=\"javascript:this.height=document.frames(this.name).document.body.scrollHeight+30;\"></iframe>\r\n            </div>\r\n        </div>\r\n    </div>\r\n    <div class=\"layout_footer\">\r\n        <p>Copyright © 2014 - UZCMS镜像采集系统</p>\r\n    </div>\r\n\r\n</body>\r\n</html>";

