<?php
session_start();if(!isset($_SESSION['user']))header("Location: login.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>搜索引擎蜘蛛访问日志查看器</title>
<link rel="stylesheet" rev="stylesheet" href="css/bootstrap.min.css" type="text/css" media="screen" />
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
}
p {	
	margin: 0 0 10px 5px;
	
}
.f {color: #CCCCCC}
-->
</style>
</head>

<body>

<div class="right">
  <div class="right_main">

 <table width="98%" border="0" cellpadding="4" cellspacing="1" class="tableoutline">


 <tr nowrap class="firstalt">
   <td width="50" height="30"><div align="center">ID</div></td>
   <td width="70"><div align="center">蜘蛛</div></td>
   <td width="120"><div align="center">蜘蛛IP</div></td>
   <td>来访页面</td>
   <td width="200">来访时间</td>
   <form method="post"><td width="40"><input type="submit" name="submit_cl" value="清除所有记录" /></td></form>
 </tr>
<?php
if(isset($_POST['submit_cl'])){
file_put_contents($_SERVER['DOCUMENT_ROOT']."/incs/zhizhu.txt",'');
}
$list=file("../incs/zhizhu.txt");
$l=count($list);
if($l!=0 && file_exists("../incs/zhizhu.txt")){
		for ($i=0; $i<$l; $i++) {
	           $detail=explode("---",$list[$i]);
			   echo '<tr class="firstalt"><td align="center">'.$i.'</td><td align="center">'.$detail[1].'</td><td align="center">'.$detail[0].'</td><td><a target="_blank" href="'.$detail[2].'">'.$detail[2].'</a></td><td>'.$detail[3].'</td></tr>'."\r\n";
			   if(empty($detail[0]) || $detail[0]==''){
				break;
			   }
			  
	       }
	   }
	   else{
	       echo '<tr align=center class="firstalt"><td colspan=5>暂时还没有蜘蛛访问</td></tr>';
}
?>
 </table>
</div>
</div>
</body>
</html>
