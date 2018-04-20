<?php
	
	function get_file_size($url) {
		 $url = parse_url($url);
		 if (empty($url['host'])) {
			 return false;
		 }
		 $url['port'] = empty($url['post']) ? 80 : $url['post'];
		 $url['path'] = empty($url['path']) ? '/' : $url['path'];
		 $fp = fsockopen($url['host'], $url['port'], $error);
		 if($fp) {
			 fputs($fp, "GET " . $url['path'] . " HTTP/1.1\r\n");
			 fputs($fp, "Host:" . $url['host']. "\r\n\r\n");
			 while (!feof($fp)) {
				 $str = fgets($fp);
				 if (trim($str) == '') {
					 break;
				 }elseif(preg_match('/Content-Length:(.*)/si', $str, $arr)) {
					 return trim($arr[1]);
				 }
			 }
			fclose ( $fp);
			return false;
		 }else {
			return false;
		 }
	}

	error_reporting(0); 

	ini_set("html_errors", false);//php.ini关闭html错误信息
	ini_set("display_errors", false);//php.ini关闭调试信息
	@ini_set("memory_limit", "-1");
	@set_time_limit(0);
	require_once "./incs/data.php";

	$_urlall = setPath();		//请求全路径后半部分
	$_zjt = $_SERVER['HTTP_HOST'] ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];//域名
	
	$urlid = $_urlall;
	$fuid = substr($urlid, 0, 1);
	if ($fuid != "/") {
		$urlid = "/" . $urlid;
	}
	$urlid = str_replace("../", "", $urlid);
	
	$uid = md5($urlid);
	$fuid = substr($uid, 0, 4);
	$fxuid = substr($fuid, 0, 2);
	$hzm = strtolower(hdhzm($urlid));		//后缀名
	$kf_id = "http://". $gourl . $urlid;  //请求目标站全路径


	//********************************************拦截静态资源做处理********************************************
	if(strpos($hzm,"css") !== false){
		$filename = l_path . "./cache/" . $fxuid . "/" . $fuid . "/" . $uid . ".css";
		if (gethchtml($filename)) {
			$htmldb = readfromfile($filename);
			header('content-type:text/css');
			$htmldb = str_replace($uzbianma, "utf-8", $htmldb); //$uzbianma设置编码
			exit($htmldb);
		} else{
			$size = get_file_size($kf_id); 
			if($size > 51200){
				 Header("Location: $kf_id");
				 exit();
			}else{
				$htmldb = get_content($kf_id);
				$htmldb = str_replace($uzbianma, "utf-8", $htmldb); //$uzbianma设置编码
				if (!is_dir(l_path . "./cache/" . $fxuid . "/" . $fuid)) {
					mkpaths("/cache/" . $fxuid . "/" . $fuid);
				}
				writetofile($filename, $htmldb);
				header('content-type:text/css');
				exit($htmldb);
			}
		}
	}else if (strstr("js txt", $hzm)) {
		if (preg_match('/nstj.js/i', $urlid)) {
			$path = l_path.$urlid;
			$jscontent = readfromfile($path);
			header('content-type:text/css');
			exit($jscontent);
		} else if (preg_match('/nstz.js/i', $urlid)) {
			$path = l_path.$urlid;
			$jscontent = readfromfile($path);
			header('content-type:text/css');
			exit($jscontent);
		} else if (preg_match('/robots.txt/i', $urlid)){
			$path = l_path.$urlid;
			$jscontent = readfromfile($path);
			exit($jscontent);
		} else{
			$filename = l_path . "./cache/" . $fxuid . "/" . $fuid . "/" . $uid . ".js";
			if (gethchtml($filename)) {
				$htmldb = readfromfile($filename);
				$htmldb = str_replace($uzbianma, "utf-8", $htmldb); //$uzbianma设置编码
				header('content-type:text/css');
				exit($htmldb);
			} else{
				$size = get_file_size($kf_id); 
				if($size > 51200){
					 Header("Location: $kf_id");
					 exit();
				}else{
					$htmldb = get_content($kf_id);
					$htmldb = str_replace($uzbianma, "utf-8", $htmldb); //$uzbianma设置编码
					echo l_path . "./cache/" . $fxuid . "/" . $fuid;
					if (!is_dir(l_path . "./cache/" . $fxuid . "/" . $fuid)) {
						mkpaths("/cache/"  . $fxuid . "/" . $fuid);
					}
					writetofile($filename, $htmldb);
					header('content-type:text/css');
					exit($htmldb);
				}
			}
		}
	} else if (strstr("gif jpg png jpeg ico", $hzm)) {
		//当请求的是图片的时候直接定位到目标站
	    Header("Location: $kf_id");
		exit();
	}
	//********************************************拦截静态资源做处理********************************************

	
	include "./incs/robot.php"; //判断蜘蛛类型并记录到incs/zhizhu.txt文件中
	$filename = l_path . "./cache" . $pid . "/" . $fxuid . "/" . $fuid . "/" . $uid . ".php"; //缓存文件路径
	
	
	//根据缓存时间判断是否有缓存
	if (gethchtml($filename, $hcsj)) {
		$htmldb = hcdecode(file_get_contents($filename));
		if($istz){
			$htmldb = preg_replace( "/<\\/head>/i", "<script type=\"text/javascript\" src=\"/nstz.js\"></script>\n</head>", $htmldb );
		}
		echo $htmldb;
		unset($htmldb);
	} else {
		
		//*****************************从目标站采集内容 start *******************************
		$url = "http://".$gourl.$urlid;
		$htmldb = get_url_content($url,$_zjt);
		
		if(!trim($htmldb)){
			if (file_exists($filename)) {
				$htmldb = hcdecode(file_get_contents($filename));
				if($istz){
					$htmldb = preg_replace( "/<\\/head>/i", "<script type=\"text/javascript\" src=\"/nstz.js\"></script>\n</head>", $htmldb );
				}
				echo $htmldb;
				unset($htmldb);
			}
			exit();
		}
		
		if(strpos($htmldb,"charset")){
			$htmldb = str_replace($uzbianma, "utf-8", $htmldb); //$uzbianma设置编码
			$htmldb = preg_replace("/charset=\"(\w+)\"/", "charset=\"utf-8\"", $htmldb);
			$htmldb = str_replace("gbk", "utf-8", $htmldb);
			$htmldb = str_replace("gb2312", "utf-8", $htmldb);
			$htmldb = str_replace("GBK", "utf-8", $htmldb);
			$htmldb = str_replace("GB2312", "utf-8", $htmldb);
		} else {
			$htmldb = preg_replace( "/<\\/head>/i", "<meta charset=\"utf-8\" />\n</head>", $htmldb );
		}

		//*****************************从目标站采集内容 end  *******************************

		$htmldb = str_replace("?<!", "<!", $htmldb); 
		$htmldb = str_replace("http://".$gourl, "", $htmldb);	// 将目标站地址替换为空 ($gourl目标网站地址)  
		
		
		
		//*********************正则替换 start ***************************************
		//当是uz的vip时候才能用正则替换，只有开启正则才能进行同义词替换
		if ($uzvip) {
			$bodydelarr = explode("[or]", encrypt($uzvip, "D", "UZCMS镜像采集系统的专用密码", 1));

			foreach ($bodydelarr as $bodydel ) {
				if (!empty($bodydel)) {
					$bodydel = explode("[to]", $bodydel);
					$bodydel1[] = repinfozz($bodydel[0]);
					$bodydel2[] = $bodydel[1];
				}
			}
			$htmldb = preg_replace($bodydel1, $bodydel2, $htmldb);
			
		}
		//*********************正则替换 end ***************************************

		
		//*********************同义词替换 start ***************************************
		if ($wyckg == 1) {
			$htmldb = keyshtml($htmldb);
		}
		//********************同义词替换 end ****************************************
		
		
		//*********************是否开启友链 start ***************************************
		if ($link == 1) {
			$link1 = repinfozz(stripslashes(encrypt($mblink, "D", "UZCMS镜像采集系统的专用密码", 1)));
			$link2 = stripslashes(encrypt($mylink, "D", "UZCMS镜像采集系统的专用密码", 1));
			$htmldb = preg_replace($link1, $link2, $htmldb);
		}
		//*********************是否开启友链 end ***************************************

		
		//*********************是否开启广告管理 start ***************************************
		if ($ads == 1) {
			$htmldb = str_replace(stripslashes(encrypt($mbad1, "D", "UZCMS镜像采集系统的专用密码", 1)), stripslashes(encrypt($myad1, "D", "UZCMS镜像采集系统的专用密码", 1)), $htmldb);//广告管理1
			$htmldb = str_replace(stripslashes(encrypt($mbad2, "D", "UZCMS镜像采集系统的专用密码", 1)), stripslashes(encrypt($myad2, "D", "UZCMS镜像采集系统的专用密码", 1)), $htmldb);//广告管理2
			$htmldb = str_replace(stripslashes(encrypt($mbad3, "D", "UZCMS镜像采集系统的专用密码", 1)), stripslashes(encrypt($myad3, "D", "UZCMS镜像采集系统的专用密码", 1)), $htmldb);//广告管理3
			$htmldb = str_replace(stripslashes(encrypt($mbad4, "D", "UZCMS镜像采集系统的专用密码", 1)), stripslashes(encrypt($myad4, "D", "UZCMS镜像采集系统的专用密码", 1)), $htmldb);//广告管理4
			$htmldb = str_replace(stripslashes(encrypt($mbad5, "D", "UZCMS镜像采集系统的专用密码", 1)), stripslashes(encrypt($myad5, "D", "UZCMS镜像采集系统的专用密码", 1)), $htmldb);//广告管理5
		}
		//*********************是否开启广告管理 end ***************************************
		
		
		

		//*********************是否开启模板替换 start ***************************************
		if ($mystyle == 1) {
			$htmldb = str_replace(stripslashes(encrypt($mbfooter, "D", "UZCMS镜像采集系统的专用密码", 1)), stripslashes(encrypt($myfooter, "D", "UZCMS镜像采集系统的专用密码", 1)), $htmldb);
			$htmldb = str_replace(stripslashes(encrypt($mbheader, "D", "UZCMS镜像采集系统的专用密码", 1)), stripslashes(encrypt($myheader, "D", "UZCMS镜像采集系统的专用密码", 1)), $htmldb);
			$htmldb = str_replace(stripslashes(encrypt($mbleft, "D", "UZCMS镜像采集系统的专用密码", 1)), stripslashes(encrypt($myleft, "D", "UZCMS镜像采集系统的专用密码", 1)), $htmldb);
			$htmldb = str_replace(stripslashes(encrypt($mbright, "D", "UZCMS镜像采集系统的专用密码", 1)), stripslashes(encrypt($myright, "D", "UZCMS镜像采集系统的专用密码", 1)), $htmldb);
			$htmldb = str_replace(stripslashes(encrypt($mbmain, "D", "UZCMS镜像采集系统的专用密码", 1)), stripslashes(encrypt($mymain, "D", "UZCMS镜像采集系统的专用密码", 1)), $htmldb);
		}
		//*********************是否开启模板替换 end ***************************************
		
		
		
		//*********************tdk替换 start ***************************************
		if($_urlall == "/"){
			$htmldb = preg_replace('@<title>(.*?)</title>@is','<title>'.$uzname.'</title>'.$nosj,$htmldb);
			if($webkey){
				$htmldb = preg_replace('/<meta\sname="keywords"[\s\S]*?>/i', "<meta name=\"keywords\" content=\"" . $webkey . "\" />", $htmldb);
			}
			if($webjs){
				$htmldb = preg_replace("/<meta\sname=\"description\"[\s\S]*?>/i", "<meta name=\"description\" content=\"" . $webjs . "\" />", $htmldb);
			}
			
		} else {
			//***********去掉key和ms**********
			$htmldb=preg_replace('@<meta([^>]*?)(name=keywords|name="keywords"|name=\'keywords\')([^>]*?)>@is','',$htmldb); 
			$htmldb=preg_replace('@<meta([^>]*?)(name=description|name="description"|name=\'description\')([^>]*?)>@is','',$htmldb);
			
			function get_keytxt($ml="txt",$keysid="1"){
				$duml = l_path."/dbs/".$ml."/";
				$files = dir($duml);
				$ii=0;

				while ($current = $files->read()){
					if (strpos($current, ".txt")!= FALSE) {
						$iurl[$ii]=$current;
						$ii++;
					}
				} 
				$ii--;
				return $duml.$iurl[$keysid%$ii];
			}
			
		
			//内页标题替换
			$start = mt_rand(1,10);		
			if($dasdqeqeq){
				$result = "";
				preg_match_all( '/<h1[\s\S]*?>(.*)<\/h1>/i', $htmldb, $result);
				if(!$result){
					echo 2;
					preg_match_all( '/<h2[\s\S]*?>(.*)<\/h2>/i', $htmldb, $result);
				}
				if($result){
					//****获取长尾词*****
					$_urlid=ceil(substr(preg_replace("/[^0-9]/","",md5($_zjt.$_urlall)),0,6));
					$ctxtfiles=get_keytxt("key",$_urlid);
					$k2=$k1=file($ctxtfiles);
					$k2s=$k1s=ceil(count($k1)-1);
					//*****获取长尾词***
					
					$__ffid=(ceil(substr(preg_replace('/[^0-9]/','',md5($_zjt.$_urlall)),0,5))%$k1s);
					$random_kyeword=trim($k1[$__ffid]);
					$htmldb=preg_replace('@<title>(.*?)</title>@is','<title>'.$random_kyeword."_".$zkwd.'</title>',$htmldb);
					$htmldb=preg_replace('/<h1[\s\S]*?>(.*)\s{0,}<\/h1>/i','<h1>'.$random_kyeword.'</h1>',$htmldb);
					$htmldb=preg_replace('/<h2[\s\S]*?>(.*)\s{0,}<\/h2>/i','<h1>'.$random_kyeword.'</h1>',$htmldb);
				}
				
			}else{
				preg_match("/<title>(.*)<\/title>/i",$htmldb, $title_temp);
				$title_arr = preg_split("/[-|_]/",$title_temp[1]);
				$title = trim($title_arr[0])."_".$zkwd;
				$htmldb=preg_replace('@<title>(.*?)</title>@is','<title>'.$title.'</title>',$htmldb);
			}
			
			//*********内容加特殊符号*************
			$htmldb = change($htmldb);
			
		}
		//*********************tdk替换 end ***************************************

		
		//************************************自定义nsjs(写入缓存) start ********************************************************
		$htmldb = preg_replace( "/<head>/i", "<head>\n<script type=\"text/javascript\" src=\"/nstj.js\"></script>\n", $htmldb );

		
		//********************* 缓存文件 start *********************
		if ($hckg) {
			if (!is_dir(l_path . "./cache/" . $pid . "/" . $fxuid . "/" . $fuid)) {
				mkpaths("/cache/" . $pid . "/" . $fxuid . "/" . $fuid);
			}

			$hcdb = set_gzip($htmldb);
			writetofile($filename, $hcdb);
		}
		//********************* 缓存文件 end *********************
		

		if($istz){
			$htmldb = preg_replace( "/<\\/head>/i", "<script type=\"text/javascript\" src=\"/nstz.js\"></script>\n</head>", $htmldb );
		}

		
		echo $htmldb;
		unset($htmldb);
	}

?>

