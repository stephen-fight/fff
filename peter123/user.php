<?php
error_reporting(0);
session_start();if(!isset($_SESSION['user']))header("Location: login.php");
if(isset($_POST[submit])){
	if(is_file("login.php")){
		$content = file_get_contents("login.php");
		preg_match("/_POST\[(\'|\")pwd\\1\][\s]?==[\s]?(\'|\")(.*?)\\2/", $content, $match);
		$oldpass = $match[3];
		if($_POST[pwd]==$oldpass){
			$newcontent = preg_replace("/_POST\[(\'|\")pwd\\1\][\s]?==[\s]?(\'|\").*?\\2/", "_POST['pwd']=='$_POST[newpass]'", $content,1);
			file_put_contents("login.php", $newcontent);
			echo "修改密码成功！";
		}else{
			echo "用户名或者原密码有误！";
		}
	}else{
		exit;
	}   
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" rev="stylesheet" href="css/bootstrap.min.css" type="text/css" media="screen" />
    <title>UZCMS镜像采集系统-管理密码修改</title>
</head>

<div class="div_from_aoto" style="width:100%" align=center>
    <form action='' method='post' name='myform' onsubmit='return checkpost();'>
        <DIV class="control-group">
            <label class="laber_from">用户名</label>
            <DIV  class="controls" ><input class="input_from" type=text name='user' placeholder="请输入用户名"><P class=help-block></P></DIV>
        </DIV>
        <DIV class="control-group">
            <LABEL class="laber_from">原密码</LABEL>
            <DIV  class="controls" ><INPUT class="input_from" type=text placeholder=" 请输入原密码" name='pwd'><P class=help-block></P></DIV>
        </DIV>
        <DIV class="control-group">
            <LABEL class="laber_from" >新密码</LABEL>
            <DIV  class="controls" ><INPUT class="input_from" type=password placeholder=" 请输入新密码" name='newpass'><P class=help-block></P></DIV>
        </DIV>
        <DIV class="control-group">
            <LABEL class="laber_from" ></LABEL>
            <DIV class="controls" ><input class="btn btn-success" name='submit' type='submit' style="width:120px;" value='确认'>
			
        </DIV>
    </FORM>
</div>

</html>