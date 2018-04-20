<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" rev="stylesheet" href="./style/login.css" type="text/css" media="screen" />
    <title>uzcms镜像采集系统-管理员登录</title>
</head>
<?php
	define('l_path', dirname(__FILE__));
	
	


 if(isset($_POST['submit'])&&isset($_POST['submit'])=='确定'){
 //echo $_POST['user'];
  if($_POST['user']=='peter'&&$_POST['pwd']=='stephen123'){                //密码在这里修改 
   $_SESSION['user'] = $_POST['user'];
  echo '<script>window.location.href="index.php";</script>';
  } else{ 
   echo '用户名或密码错误！';
  }
 }else{
echo'<body><div class="bg"><div id="wrapper"><div class="logo"><img src="./style/logo.png" title="UZCMS管理员登录" alt="UZCMS管理员登录"/></div>';
echo'<div class="login"><form id="frmLogin" method="post" >';
echo'<dl><dd><label for="edtUserName">用户名:</label><input type="text" id="edtUserName" name="user" size="20" tabindex="1" /></dd>';
echo'<dd><label for="edtPassWord">密码:</label><input type="password" id="edtPassWord" name="pwd" size="20" tabindex="2" /></dd> </dl>';
echo'<dl><dd class="checkbox"><input type="checkbox" name="chkRemember" id="chkRemember"  tabindex="3" /><label for="chkRemember">保存我的登录信息</label></dd>';
echo'<dd class="submit"><input id="submit" name="submit" type="submit" value="登录" class="button" tabindex="4"/></dd></dl>';
echo'<input type="hidden" name="username" id="username" value="" />';
	echo'<input type="hidden" name="password" id="password" value="" />';
	echo'<input type="hidden" name="savedate" id="savedate" value="0" /></form></div></div></div></body>';
 }
 
 

?>

</html>
