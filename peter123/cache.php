<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML><HEAD><TITLE>UZCMS - 您身边的镜像程序专家</TITLE>
<LINK href="./style/bs.css" type=text/css rel=stylesheet>
<STYLE type=text/css>
.a2 {
	BACKGROUND-COLOR: #a4b6d7
}
BODY {
	BACKGROUND: #fff; MARGIN: 0px
}
</STYLE>
<?php 
function delFile($fpath) { 
$filesize = array(); 
$filepath = iconv('gb2312', 'utf-8', $fpath); 
if (is_dir($fpath)) { 
if ($dh = opendir($fpath)) { 
while (($file = readdir($dh)) !== false) { 
if($file != '.' && $file != '..') { 
$filesize[] = delFile($fpath.'/'.$file); 
} 
} 
closedir($dh); 
} 
/* 
* 方便统计目录数 
*/ 
$filesize['file'] = 0; 
if(@rmdir($fpath) === true) { 
echo "{$filepath}................删除成功<br>\n"; 
} else { 
echo "{$filepath}................删除失败<br>\n"; 
} 
} else { 
if(is_file($fpath)) { 
$filesize[] = $fsize = filesize($fpath); 
if(@unlink($fpath) === true) { 
echo "{$filepath}...{$fsize}B................删除成功<br>\n"; 
} else { 
echo "{$filepath}...{$fsize}B................删除失败<br>\n"; 
} 
} 
} 
return $filesize; 
} 
/* 
* function getArrSum(array &$arr) 数组求和 
* array &$arr 被处理数组 
*/ 
function getArrSum(&$arr) { 
if(is_array($arr)) { 
foreach ($arr as &$value) { 
$value = getArrSum($value); 
} 
return array_sum($arr); 
} else { 
return $arr; 
} 
} 
$fpath = '../cache'; 
$filesize = delFile($fpath); 
$size = getArrSum($filesize); 
printf('为您节省：%.3fM 空间', $size/(1024*1024)); 
?> 
