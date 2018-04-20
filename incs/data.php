<?php

function getUnicodeFromOneUTF8($word) {  
    //获取其字符的内部数组表示，所以本文件应用utf-8编码!  
    if (is_array( $word))  
        $arr = $word;  
    else  
        $arr = str_split($word);  
    //此时，$arr应类似array(228, 189, 160)  
    //定义一个空字符串存储  
    $bin_str = '';  
    //转成数字再转成二进制字符串，最后联合起来。  
    foreach ($arr as $value)  
        $bin_str .= decbin(ord($value));  
    //此时，$bin_str应类似111001001011110110100000,如果是汉字"你"  
    //正则截取  
    $bin_str = preg_replace('/^.{4}(.{4}).{2}(.{6}).{2}(.{6})$/','$1$2$3', $bin_str);  
      
    //此时， $bin_str应类似0100111101100000,如果是汉字"你"  
    return bindec($bin_str);  
    //返回类似20320， 汉字"你"  
    //return dechex(bindec($bin_str));  
    //如想返回十六进制4f60，用这句  
} 


function toUnicode($str){
	$length = mb_strlen($str, 'utf-8');
	$back ;
	for ($i=0; $i<$length; $i++) {
		$temp = mb_substr($str, $i, 1, 'utf-8');
		$back = $back."&#".getUnicodeFromOneUTF8($temp).";";
	}	
	return $back;
}

function filter($string, $force = 0)
{
	if (!$GLOBALS["magic_quotes_gpc"] || $force) {
		if (is_array($string)) {
			foreach ($string as $key => $val ) {
				$string[$key] = filter($val, $force);
			}
		}
		else {
			$string = addslashes($string);
		}
	}

	return $string;
}

function mkpaths($paths)
{
	if ($paths) {
		$listpath = explode("/", $paths);
		$mkpath = "";

		for ($i = 1; $i <= count($listpath); $i++) {
			$mkpath = $mkpath . "/" . $listpath[$i];

			if (!is_dir(l_path . "." . $mkpath)) {
				if (!@mkdir(l_path . "." . $mkpath, 511)) {
					exit("&#x6307;&#x5b9a;&#x76ee;&#x5f55;&#x4e0d;&#x5b58;&#x5728;&#x6216;&#x4e0d;&#x5141;&#x8bb8;&#x64cd;&#x4f5c;&#x2c;&#x8bf7;&#x68c0;&#x67e5;&#x76ee;&#x5f55;&#x6743;&#x9650;&#x662f;&#x5426;&#x4e3a;&#x20; 0777");
				}
			}
		}
	}
}

function ispage($number)
{
	return !empty($number) && preg_match("/^([0-9]+)$/", $number);
}

function writetofile($file_name, $data, $method = "w")
{
	if ($filenum = @fopen($file_name, $method)) {
		flock($filenum, LOCK_EX);
		$file_data = fwrite($filenum, $data);
		fclose($filenum);
		return $file_data;
	}
	else {
		exit("不能写入文件 请把网站根目录 Everyone 写入权限打开");
	}
}

function readfromfile($file)
{
	if (!@$fp = fopen($file, "r")) {
		return false;
	}
	else {
		$str = @fread($fp, filesize($file));
		fclose($fp);
		return $str;
	}
}

function set_gzip($content)
{
	if (extension_loaded("zlib") && strstr($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")) {
		$content = gzencode($content, 9);
	}

	return $content;
}

function hcdecode($data)
{
	$flags = ord(substr($data, 3, 1));
	$headerlen = 10;
	$extralen = 0;
	$filenamelen = 0;

	if ($flags & 4) {
		$extralen = unpack("v", substr($data, 10, 2));
		$extralen = $extralen[1];
		$headerlen += 2 + $extralen;
	}

	if ($flags & 8) {
		$headerlen = strpos($data, chr(0), $headerlen) + 1;
	}

	if ($flags & 16) {
		$headerlen = strpos($data, chr(0), $headerlen) + 1;
	}

	if ($flags & 2) {
		$headerlen += 2;
	}

	$unpacked = @gzinflate(substr($data, $headerlen));

	if ($unpacked === false) {
		$unpacked = $data;
	}

	return $unpacked;
}

function cw_404()
{
	$webwzurl = &$GLOBALS["webwzurl"];
	echo "<script>\n";
	echo "window.location=\"" . $webwzurl . "\/error\/404.html\";\n";
	echo "</script>";
	exit();
}

function js_reload()
{
	echo "<script type='text/javascript'>parent.document.location.reload();;</script>";
}

function get_encoding($data, $to)
{
	
	$encode_arr = array("UTF-8", "ASCII", "GBK", "GB2312", "BIG5", "JIS", "eucjp-win", "sjis-win", "EUC-JP", "gbk", "gb2312");
	$encoded = mb_detect_encoding($data, $encode_arr);
	$data = mb_convert_encoding($data, $to, $encoded);
	return $data;
}

function gethchtml($filename, $evryhour = 0)
{
	if (file_exists($filename)) {
		if ($evryhour == 0) {
			return "ok";
		}
		else if ((time() - filemtime($filename)) < ($evryhour * 60)) {
			return "ok";
		}
	}
}

function FixPath($aim, $baseUrl)
{
	$strSource = $baseUrl;

	if (preg_match_all("/([^:\/]+)\//", $strSource, $aryResult1, PREG_PATTERN_ORDER)) {
		$intUrlLevel = count($aryResult1[0]);
	}
	else {
		$intUrlLevel = 0;
		preg_match_all("/http:\/\/(.+?)$/", $strSource, $aryResult1, PREG_PATTERN_ORDER);
		$aryResult1[0][0] = $aryResult1[1][0] . "/";
	}

	$strSource = $aim;

	if (substr($strSource, 0, 7) == "http://") {
		return $aim;
	}
	else {
		if (preg_match_all("/^\//", $strSource, $aryResult2, PREG_PATTERN_ORDER)) {
			$strAimUrl = "http://" . $aryResult1[1][0] . str_replace("../", "", $aim);
		}
		else {
			preg_match_all("/(\.\.\/)/", $strSource, $aryResult2, PREG_PATTERN_ORDER);
			$intAimUrlLevel = count($aryResult2[0]);

			if ($intUrlLevel <= $intAimUrlLevel) {
				$strAimUrl = "http://" . $aryResult1[0][0] . str_replace("../", "", $aim);
			}
			else {
				$strAimUrl = "http://" . implode("", array_slice($aryResult1[0], 0, $intUrlLevel - $intAimUrlLevel)) . str_replace("../", "", $aim);
			}
		}

		return $strAimUrl;
	}
}

function compress_html($string) {
    return ltrim(rtrim(preg_replace(array("/> *([^ ]*) *</","//","'/\*[^*]*\*/'","/\r\n/","/\n/","/\t/",'/>[ ]+</'),array(">\\1<",'','','','','','><'),$string)));
}

function geshuaurl($body, $url)
{
	preg_match_all("/(href|HREF)=[\"|'|]((.*)\.(html|htm|shtml|asp|php|jsp))/isU", $body, $urls_array);

	if (count($urls_array[2])) {
		$curls = array_unique($urls_array[2]);

		foreach ($curls as $key => $urlid ) {
			$nurlid = fixpath($urlid, $url);
			$body = str_replace($urlid, $nurlid, $body);
		}
	}

	return $body;
}

function get_content($url){
	$charset = &$GLOBALS["charset"];
	if (function_exists("file_get_contents")) {
		$file_contents = file_get_contents($url);
		$file_contents = get_encoding($file_contents, $charset);
		return $file_contents;
	} 
}


function get_url_content($url,$_zjt = "")
{
	
	$charset = &$GLOBALS["charset"];
	$ch = curl_init();
	$timeout = 15;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$file_contents = curl_exec($ch);
	
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	if($httpCode == 404 && $_zjt) {
		header("Location: http://" . $_zjt);
		exit();
	}
	curl_close($ch);
	$file_contents = get_encoding($file_contents, $charset);
	return $file_contents;
}

function cut($string, $start, $end)
{
	$message = explode($start, $string);
	$message = explode($end, $message[1]);
	return trim($message[0]);
}

function cutdel($string, $start, $end)
{
	$message = explode($start, $string);
	$message = explode($end, $message[1]);
	return $message[0];
}

function showpage($add, $patt, $page, $allpage)
{
	$re1 = "<div class=\"pages\">";
	$re = "";

	for ($i = $page - 5; $i <= $allpage; $i++) {
		if (0 < $i) {
			if ($i == $page) {
				$re .= " <strong>$i</strong> ";
			}
			else {
				$re .= " <a href=\"" . $add . $patt . "/" . $i . "/\">$i</a> ";
			}
		}
	}

	$ss = 1;

	if (6 < $page) {
		$re = "<a href=\"" . $add . $patt . "/" . $ss . "/\" title=\"首页\">首页</a> ..." . $re;
	}

	if (($page + 5) < $allpage) {
		$re .= "... <a href=\"" . $add . $patt . "/" . $allpage . "/\" title=\"尾页\">尾页</a>";
	}

	$re = $re1 . $re . "</div>";

	if ($allpage <= 1) {
		$re = "";
	}

	return $re;
}

function get_szi($str, $c = "")
{
	if ($c) {
		$urlidno = strstr($str, ",");

		if ($urlidno) {
			$str = str_replace(",", "/", $str);
		}
		else {
			$ks = explode("-", $str);
			$str = $ks[0] * 8888;

			if ($ks[1]) {
				$str = $str + $ks[1];
			}
		}
	}
	else {
		$urlidno = strstr($str, "/");

		if ($urlidno) {
			$str = str_replace("/", ",", $str);
		}
		else {
			$str = floor($str / 8888) . "-" . ($str % 8888);
		}
	}

	return $str;
}

function skeptic($str, $de = 0)
{
	if ($de) {
		return base64_decode($str);
	}
	else {
		return base64_encode($str);
	}
}

function get_data($dataname)
{
	include l_path . "./db/" . $dataname . ".php";
	return $weblistdb;
}

function set_data($dataname, $dataarray)
{
	$datafile = l_path . "./db/" . $dataname . ".php";
	$datacontent = "<?php\r\n\$weblistdb=" . var_export($dataarray, true) . ";\r\n?>";
	return writetofile($datafile, $datacontent);
}

function del_data($dataname, $dataarray, $delid = 0)
{
	array_splice($dataarray, intval($delid), 1);

	if (set_data($dataname, $dataarray)) {
		return "ok";
	}
	else {
		return "error";
	}
}

function Getpics($body)
{
	$picurl = &$GLOBALS["picurl"];
	$img_array = array();
	preg_match_all("/(src|SRC)=[\"|'| ]{0,}((http|HTTP):\/\/(.*)\.(gif|jpg|GIF|JPG|png))/isU", $body, $img_array);
	$img_array = array_unique($img_array[2]);

	foreach ($img_array as $key => $value ) {
		$url = $value;
		$fileurl = "/pic.php?s=" . base64_encode($url);
		$body = str_replace($url, $fileurl, $body);
	}

	return $body;
}

function get_keys($n = 8)
{
	$picurl = &$GLOBALS["picurl"];
	$sourl = &$GLOBALS["sourl"];
	$keyss = file(l_path . "./incs/key.txt");

	if (count($keyss) < $n) {
		$n = count($keyss);
	}

	$r_keys = array_rand($keyss, $n);

	for ($i = 0; $i < $n; $i++) {
		$keys .= "<span><a href='/" . $sourl . skeptic(skeptic(trim($keyss[$r_keys[$i]]))) . "/'>" . trim($keyss[$r_keys[$i]]) . "</a></span>";
	}

	return $keys;
}

function repinfozz($text)
{
	$text = str_replace("*", "(.*?)", $text);
	$text = str_replace("/", "\/", $text);
	$text = "/" . $text . "/is";
	return $text;
}

function rephtml($content, $htmltrim)
{
	$htmlarr = explode(",", $htmltrim);

	foreach ($htmlarr as $curhtml ) {
		if (in_array($curhtml, array("br", "img"))) {
			$searcharray[] = "/<" . $curhtml . "([^>]*?)>/is";
			$replacearray[] = "";
		}
		else if (in_array($curhtml, array("script", "style", "iframe"))) {
			$searcharray[] = "/<" . $curhtml . "([^>]*?)>([\s\S]*)<\/" . $curhtml . ">/is";
			$replacearray[] = "";
		}
		else {
			$searcharray[] = "/<" . $curhtml . "([^>]*?)>(.*?)<\/" . $curhtml . ">/is";
			$replacearray[] = "\$2";
		}
	}

	return preg_replace($searcharray, $replacearray, $content);
}

function keyshtml($htmldb)
{
	$keyword_arr = &$GLOBALS["keyword_arr"];
	return strtr($htmldb, $keyword_arr);
	unset($keyword_arr);
}

function getip()
{
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
		$ip = getenv("HTTP_CLIENT_IP");
	}else {
		if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}else {
			if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
				$ip = getenv("REMOTE_ADDR");
			}else {
				if (isset($_SERVER["REMOTE_ADDR"]) && $_SERVER["REMOTE_ADDR"] && strcasecmp($_SERVER["REMOTE_ADDR"], "unknown")) {
					$ip = $_SERVER["REMOTE_ADDR"];
				}else {
					$ip = "unknown";
				}
			}
		}
	}

	return $ip;
}

function write($f, $infoata, $method = "w")
{
	$filenum = @fopen($f, $method);
	@flock($filenum, LOCK_EX);
	$file_data = @fwrite($filenum, $infoata);
	@fclose($filenum);
	return $file_data;
}

function read($f)
{
	$filenum = @fopen($f, "r");
	@flock($filenum, LOCK_SH);
	$file_data = @fread($filenum, filesize($f));
	@fclose($filenum);
	return $file_data;
}

function hdhzm($file)
{
	$extend = explode(".", $file);
	$va = count($extend) - 1;
	return $extend[$va];
}

function encrypt($string, $operation, $key = "")
{
	$key = md5($key);
	$key_length = strlen($key);
	$string = ($operation == "D" ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string);
	$string_length = strlen($string);
	$rndkey = $box = array();
	$result = "";

	for ($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($key[$i % $key_length]);
		$box[$i] = $i;
	}

	for ($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for ($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ $box[($box[$a] + $box[$j]) % 256]);
	}

	if ($operation == "D") {
		if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
			return substr($result, 8);
		}
		else {
			return "";
		}
	}
	else {
		return str_replace("=", "", base64_encode($result));
	}
}

function formaturl($l1, $l2)
{
	if (preg_match_all("/(<img[^>]+src=\"([^\"]+)\"[^>]*>)|(<a[^>]+href=\"([^\"]+)\"[^>]*>)|(<img[^>]+src='([^']+)'[^>]*>)|(<a[^>]+href='([^']+)'[^>]*>)/i", $l1, $regs)) {
		foreach ($regs[0] as $num => $url ) {
			$l1 = str_replace($url, lIIIIl($url, $l2), $l1);
		}
	}

	return $l1;
}

function lIIIIl($l1, $l2)
{
	if (preg_match("/(.*)(href|src)\=(.+?)( |\/\>|\>).*/i", $l1, $regs)) {
		$I2 = $regs[3];
	}

	if (0 < strlen($I2)) {
		$I1 = str_replace(chr(34), "", $I2);
		$I1 = str_replace(chr(39), "", $I1);
	}
	else {
		return $l1;
	}

	$url_parsed = parse_url($l2);
	$scheme = $url_parsed["scheme"];

	if ($scheme != "") {
		$scheme = $scheme . "://";
	}

	$host = $url_parsed["host"];
	$l3 = $scheme . $host;

	if (strlen($l3) == 0) {
		return $l1;
	}

	$path = dirname($url_parsed["path"]);

	if ($path[0] == "\\") {
		$path = "";
	}

	$pos = strpos($I1, "#");

	if (0 < $pos) {
		$I1 = substr($I1, 0, $pos);
	}

	if (preg_match("/^(http|https|ftp):(\/\/|\\\\)(([\w\/\\\\+\-~`@:%])+\.)+([\w\/\\\\.\=\?\+\-~`@\':!%#]|(&amp;)|&)+/i", $I1)) {
		return $l1;
	}
	else if ($I1[0] == "/") {
		$I1 = $l3 . $I1;
	}
	else if (substr($I1, 0, 3) == "../") {
		while (substr($I1, 0, 3) == "../") {
			$I1 = substr($I1, strlen($I1) - strlen($I1) - 3, strlen($I1) - 3);

			if (0 < strlen($path)) {
				$path = dirname($path);
			}
		}

		$I1 = $l3 . $path . "/" . $I1;
	}
	else if (substr($I1, 0, 2) == "./") {
		$I1 = $l3 . $path . substr($I1, strlen($I1) - strlen($I1) - 1, strlen($I1) - 1);
	}
	else {
		if ((strtolower(substr($I1, 0, 7)) == "mailto:") || (strtolower(substr($I1, 0, 11)) == "javascript:")) {
			return $l1;
		}
		else {
			$I1 = $l3 . $path . "/" . $I1;
		}
	}

	return str_replace($I2, "\"$I1\"", $l1);
}


function indexOf($sorce, $chinese)
{
	return mb_strpos($sorce, $chinese, NULL, "UTF-8");
}

function indexOf2($sorce, $chinese)
{
	return @mb_strpos($sorce, $chinese, NULL, "UTF-8");
}

function charAt($sorce, $numpos)
{
	return mb_substr($sorce, $numpos, 1, "UTF-8");
}

function get_fh( )
{
    $chars = "";
    $max = 3;
    $hash = "";
    $i = 0;
    for ( ; $i < mt_rand( 3, 5 ); ++$i )
    {
        $hash .= $chars[mt_rand( 0, $max )];
    }
    return $hash;
}

function change($htmldb){
	$str = '';
	$arr_tmp = explode('，',$htmldb);
	$i = 0;
	foreach($arr_tmp as $v){
		$i++;
		$fh = get_fh();
		$str = $str.$v;
		if($i != count($arr_tmp)){
			$str = $str.$fh."，";
		}
	}
	
	$arr_tmp = explode('。',$str);
	$str = '';
	$i = 0;
	foreach($arr_tmp as $v){
		$i++;
		$fh = get_fh();
		$str = $str.$v;
		if($i != count($arr_tmp)){
			$str = $str.$fh."。";
		}
	}
	return $str;
}

function setPath() {
	$path = "";
	if (isset($_SERVER['REQUEST_URI'])) {
		$path = $_SERVER['REQUEST_URI'];
	} else if (isset($_SERVER['argv'])) {
		$path = $_SERVER['PHP_SELF'] . "?" . $_SERVER['argv'][0];
	} else {
		$path = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];
	} 
	if (isset($_SERVER['SERVER_SOFTWARE']) && false !== stristr($_SERVER['SERVER_SOFTWARE'], "IIS")) {
		if (function_exists("mb_convert_encoding")) {
			$path = mb_convert_encoding($path, "UTF-8", "GBK");
		} else {
			$path = iconv("GBK", "UTF-8", @iconv("UTF-8", "GBK", $path)) == $path ? $path : iconv("GBK", "UTF-8", $path);
		} 
	} 
	$r = explode("#", $path, 2);
	$path = $r[0];
	$path = str_ireplace("index.php?404;", "", $path);
	$path = str_ireplace("d58api.php?404;", "", $path);
	$path = str_ireplace("http://" . ($_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']) . "/", "", $path);
	$path = str_ireplace("http://" . ($_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME']) . ":" . $_SERVER['SERVER_PORT'] . "/", "", $path);
	$path = str_ireplace("index.php", "", $path);
	$path = str_ireplace("d58api.php", "", $path);
	$path = str_ireplace("index.html", "", $path);
	$path = str_ireplace("index.htm", "", $path);
	return $path;
} 


error_reporting(1 | 2 | 4);
set_magic_quotes_runtime(0);
define("l_path", substr(dirname(__FILE__), 0, -4));
define("l_ok", true);

if (PHP_VERSION < "4.1.0") {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
	$_COOKIE = &$HTTP_COOKIE_VARS;
	$_SERVER = &$HTTP_SERVER_VARS;
	$_ENV = &$HTTP_ENV_VARS;
	$_FILES = &$HTTP_POST_FILES;
}

$magic_quotes_gpc = get_magic_quotes_gpc();
$register_globals = @ini_get("register_globals");
if (!$register_globals || !$magic_quotes_gpc) {
	@extract(filter($_POST));
	@extract(filter($_GET));

	if (!$magic_quotes_gpc) {
		$_FILES = filter($_FILES);
	}
}

require_once l_path . "./config.php";
require_once l_path . "incs/keyword.php";

