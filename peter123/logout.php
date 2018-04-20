<?php
 session_start();
 session_destroy();
 echo "<script language=javascript>alert('退出成功！');window.location='login.php'</script>";
 ?>
