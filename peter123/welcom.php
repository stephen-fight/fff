<?php

session_start();if(!isset($_SESSION['user']))header("Location: login.php");

require_once "../incs/data.php";
$configs = readfromfile("../config.php");
$configs = preg_replace("/[$]ads\s*\=\s*[\"'].*?[\"'];/is", "\$toolUrl = '$toolUrl';", $configs);
$configs = preg_replace("/[$]ads\s*\=\s*[\"'].*?[\"'];/is", "\$zkwd = '$zkwd';", $configs);
$configs = preg_replace("/[$]ads\s*\=\s*[\"'].*?[\"'];/is", "\$uzname = '$uzname';", $configs);
$_zjt = $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];//域名

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>admin_index</title>
<link rel="stylesheet" href="style/admin_center.css" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>

<script>
var  highlightcolor='#eafcd5';
//此处clickcolor只能用win系统颜色代码才能成功
var  clickcolor='#51b2f6';
function  changeto(){
source=event.srcElement;
if  (source.tagName=="TR"||source.tagName=="TABLE")
return;
while(source.tagName!="TD")
source=source.parentElement;
source=source.parentElement;
cs  =  source.children;
//alert(cs.length);
if  (cs[1].style.backgroundColor!=highlightcolor&&source.id!="nc"&&cs[1].style.backgroundColor!=clickcolor)
for(i=0;i<cs.length;i++){
	cs[i].style.backgroundColor=highlightcolor;
}
}

function  changeback(){
if  (event.fromElement.contains(event.toElement)||source.contains(event.toElement)||source.id=="nc")
return
if  (event.toElement!=source&&cs[1].style.backgroundColor!=clickcolor)
//source.style.backgroundColor=originalcolor
for(i=0;i<cs.length;i++){
	cs[i].style.backgroundColor="";
}
}

function  clickto(){
source=event.srcElement;
if  (source.tagName=="TR"||source.tagName=="TABLE")
return;
while(source.tagName!="TD")
source=source.parentElement;
source=source.parentElement;
cs  =  source.children;
//alert(cs.length);
if  (cs[1].style.backgroundColor!=clickcolor&&source.id!="nc")
for(i=0;i<cs.length;i++){
	cs[i].style.backgroundColor=clickcolor;
}
else
for(i=0;i<cs.length;i++){
	cs[i].style.backgroundColor="";
}
}

</script>


<script>

	function commitData(){
		var url = '<?php echo $toolUrl ?>';
		var domain = '<?php echo $_zjt ?>';
		var keyword = '<?php echo $zkwd ?>';
		var uzname = '<?php echo $tname ?>';
		
		if(!url){
			alert("toolUrl不能为空");
			return;
		} 
		
		if(!keyword){
			alert("主关键词不能为空");
			return;
		} 
		
		if(!uzname){
			alert("用户名不能为空不能为空");
			return;
		} 
		
		if(confirm("确定提交数据吗？")){
			$.ajax({
				url: url ,
				data: {
					domain: domain.replace('www.',''),
					keyword: keyword,
					uzname: uzname
				},
				dataType: "json",
				method: "POST",
				jsonp: "jsoncallback",
				success: function(n) {
					alert(n.msg)	
				},
				error: function(n, e, r) {
					alert("请求失败")
				}
			});
		 }
		
	}

	
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
     
        <td bgcolor="#f3ffe3"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#bdbdbd" onmouseover="changeto()"  onmouseout="changeback()">
     
          <tr>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2">主机名 (IP：端口)：</td>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2"><?php echo $_SERVER['SERVER_NAME']?>(<?php echo $_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'];?>)</td>
          </tr>
          <tr>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2">程序目录：</td>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2"><?php echo dirname(dirname($_SERVER['SCRIPT_FILENAME']));?></td>
          </tr>
		  <tr>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2">Web服务器：</td>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2"><?php echo $_SERVER['SERVER_SOFTWARE']?></td>
          </tr>
		  <tr>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2">PHP 运行方式：</td>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2"><?php echo PHP_SAPI?></td>
          </tr>
		  <tr>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2">Zend Optimizer：</td>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2"><?php echo "Zend Guard Loader3.3.0"; ?></td>
          </tr>
		  <tr>
            <td width="220" height="20" bgcolor="#FFFFFF" class="STYLE2">提交网站：</td>
            <td height="20" bgcolor="#FFFFFF" class="STYLE2"><input type='button' value='提交并替换' onclick="commitData()"></td>
          </tr>
        </table></td>
       
      </tr>
    </table></td>
  </tr>
 
</table>
</body>
</html>
