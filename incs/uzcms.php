<?php
//zend54   
//Decode by www.dephp.cn  QQ 2859470
?>
<?php
!defined("l_ok") && exit("Accessed Defined!");
exit($_SERVER["QUERY_STRING"]);
$urlconf = array("domains" => $webpath, "default" => "index.php", "extents" => ".html");

if (!isset($_SERVER["REQUEST_URI"])) {
	$_SERVER["REQUEST_URI"] = substr($_SERVER["argv"][0], strpos($_SERVER["argv"][0], ";") + 1);
}

if ($_SERVER["REQUEST_URI"]) {
	if (strpos(strtolower($urlconf["domains"]), "http://") === false) {
		$URI_CONFIG_LENGTH = strlen($urlconf["domains"] . $urlconf["default"]) + 1;
		$URI_QUESTED_LENGTH = strlen($_SERVER["REQUEST_URI"]);
		$_SERVER["REQUEST_URI"] = substr($_SERVER["REQUEST_URI"], $URI_CONFIG_LENGTH, $URI_QUESTED_LENGTH - $URI_CONFIG_LENGTH);
	}
	else {
		$URI_CONFIG_LENGTH = $urlconf["domains"] . $urlconf["default"] . "/";
		$URI_QUESTED_LENGTH = "http://" . ($_SERVER["HTTP_HOST"] ? $_SERVER["HTTP_HOST"] : $_SERVER["SERVER_NAME"]) . $_SERVER["REQUEST_URI"];
		$_SERVER["REQUEST_URI"] = str_replace($URI_CONFIG_LENGTH, "", $URI_QUESTED_LENGTH);
	}

	$_SERVER["REQUEST_URI"] = str_replace($urlconf["extents"], "", $_SERVER["REQUEST_URI"]);
	$URI_REQUESTED_VARIABLES = explode("/", $_SERVER["REQUEST_URI"]);

	if ($URI_REQUESTED_VARIABLES[0]) {
		$op = addslashes($URI_REQUESTED_VARIABLES[0]);

		if ($URI_REQUESTED_VARIABLES[1]) {
			$pid = addslashes($URI_REQUESTED_VARIABLES[1]);

			if ($URI_REQUESTED_VARIABLES[2]) {
				$uid = addslashes($URI_REQUESTED_VARIABLES[2]);

				if ($URI_REQUESTED_VARIABLES[3]) {
					$sid = addslashes($URI_REQUESTED_VARIABLES[3]);
				}
			}
			else {
				$uid = $sid = "0";
			}
		}
		else {
			$pid = $uid = $sid = "0";
		}
	}
	else {
		$op = $pid = $uid = $sid = "0";
	}
}

