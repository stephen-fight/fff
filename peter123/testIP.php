<?php
	function check_ip(){  
		$ALLOWED_IP = array('127.0.0.1','203.177.139.12');  
		$IP=getIP();  
		$check_ip_arr= explode('.',$IP);//要检测的ip拆分成数组  
		#限制IP  
		if(!in_array($IP,$ALLOWED_IP)) {  
			foreach ($ALLOWED_IP as $val){  
				if(strpos($val,'*')!==false){//发现有*号替代符  
					 $arr=array();//  
					 $arr=explode('.', $val);  
					 $bl=true;//用于记录循环检测中是否有匹配成功的  
					 for($i=0;$i<4;$i++){  
						if($arr[$i]!='*'){//不等于*  就要进来检测，如果为*符号替代符就不检查  
							if($arr[$i]!=$check_ip_arr[$i]){  
								$bl=false;  
								break;//终止检查本个ip 继续检查下一个ip  
							}  
						}  
					 }//end for   
					 if($bl){//如果是true则找到有一个匹配成功的就返回  
						return;  
						die;  
					 }  
				}  
			}//end foreach  
			header('HTTP/1.1 403 Forbidden');  
			//echo "Access forbidden";  
			return false;
		} else {
			return true;
		}
	}  
	
	function getIP() {  
		return isset($_SERVER["HTTP_X_FORWARDED_FOR"])?$_SERVER["HTTP_X_FORWARDED_FOR"] :(isset($_SERVER["HTTP_CLIENT_IP"])?$_SERVER["HTTP_CLIENT_IP"]  :$_SERVER["REMOTE_ADDR"]);  
	}
	
	if(!check_ip()){
		echo "Access forbidden";  
		exit();
	}
 ?>