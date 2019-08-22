<?php

/* * **************************
 * NAME:    ntm.php
 * TEAM:    COMODO WEB TEAM
 * VERSION: 3.0.1 - release
 * DATE:    24-12-2013
 * ************************** */
// REFERENCES:
// FV: http://www.featureblend.com/javascript-flash-detection-library.html
// IP: http://www.phpclasses.org/package/3342-PHP-Determine-the-country-of-an-IP-address-using-Whois.html
// http://stackoverflow.com/questions/2858123/how-to-extract-data-from-google-analytics-and-build-a-data-warehouse-webhouse-f
include_once 'dburl.inc.php';
include_once 'check-browser.php';
$referrer = '';
//retrieve referrer sent via ajax
if (isset($_POST['dataReferrer'])) {
	$referrer = urldecode($_POST['dataReferrer']);
}
//retrieve and call function
if (isset($_POST['usf'])) {
	$usrFunc = $_POST['usf'];
	if (is_callable($usrFunc)) {
		call_user_func($usrFunc);
	}
}

//--------------------------------------------------------------------------------------------------------------
// RETRIEVE ALL THE INFO ABOUT THE USER FROM SERVER AND HEADERS
//--------------------------------------------------------------------------------------------------------------
function retrieveInfo() {
	global $referrer;
	$inactive = 300; // the time in seconds a session will contain relevant information
	if (session_id() == '') {
		session_start();
	}
	if (isset($_SESSION['n_qry'])) {
		$session_life = time() - $_SESSION['n_timeout'];
		if ($session_life > $inactive) { //after session time expired destroy the qry and retrieve info again
			unset($_SESSION['n_qry']);
			retrieveInfo();
			return;
		}
		$_SESSION['n_timeout'] = time();
		echo $_SESSION['n_qry'];
	} else {
		$vt = getVisitorType();
		$str = '';
		$str.= 'n_sha=' . $vt[1];
		$str.= '&key6sk2=' . str_replace('.', '', getBrowser());
		$str.= '&key6sk3=' . get_os();
		$str.= '&key6sk4=' . get_language();
		$str.= '&key6sk5=' . ip2geo();
		$str.= '&key6sk6=' . $vt[0];
		$_SESSION['n_timeout'] = time();
		$_SESSION['n_qry'] = $str;  //store the user info in a session in order to speed up the retrieval process on next pages
		echo $str;  //return the info to the caller
	}
}

//--------------------------------------------------------------------------------------------------------------
// retrieve the SHA for a specific user
//--------------------------------------------------------------------------------------------------------------
function getSHA() {
	echo sha1(str_replace('.', '', getBrowser()) . $_SERVER['HTTP_HOST'] . $_SERVER['REMOTE_ADDR'] . microtime());
}

//--------------------------------------------------------------------------------------------------------------
// retrieve URL ID from DB
//--------------------------------------------------------------------------------------------------------------
function getUrlId() {
	$whiteList = array(
		'securebox.comodo.com', 'mdm.comodo.com', 'dm.comodo.com', 'blogs.comodo.com', 'enterprise.comodo.com', 'help.comodo.com', 'm.comodo.com',
		'personalfirewall.comodo.com', 'programs-manager.comodo.com', 'secure.comodo.net', 'secure.comodo.com',
		'backup.comodo.com', 'system-cleaner.comodo.com', 'www.ccssforum.org', 'www.comodo.com', 'www.comodo.tv',
		'www.comodoantispam.com', 'www.contentverification.com', 'www.enterprisessl.com', 'www.evsslcertificate.com',
		'www.geekbuddy.com', 'www.hackerguardian.com', 'www.instantssl.com', 'www.livepcsupport.com', 'www.positivessl.com',
		'www.whichssl.com', 'valkyrie.comodo.com', 'ru.instantssl.com'
	);
	$_POST['url'] = preg_replace('/(\.php).*/', '.php', $_POST['url']);
	$domainInList = preg_grep('/(' . preg_quote(parse_url($_POST['url'], PHP_URL_HOST)) . ')/', $whiteList);
	try {
		if (isset($_POST['url']) && ! empty($domainInList)) {
			$tmpUrl = urldecode($_POST['url']);
			$db = new DBUrl();
			$id = $db->getId($tmpUrl);
			echo ($id);
		} else {
			echo 0; //xvar _dump( preg_grep('/('. preg_quote(parse_url($_POST['url'], PHP_URL_HOST)) . ')/', $whiteList));
		}
	} catch (PDOException $e) {
		return '00';
	}
}

//--------------------------------------------------------------------------------------------------------------
// GET BROWSER
//--------------------------------------------------------------------------------------------------------------
function getBrowser() {
	$browser = new Browser();
	$brw = $browser->getBrowser() . $browser->getVersion();
	unset($browser);
	return $brw;
}

//--------------------------------------------------------------------------------------------------------------
// GET OS
//--------------------------------------------------------------------------------------------------------------
function get_os() {
	$OSList = array(
		'311' => 'Win16',
		'1' => '(Windows 95)|(Win95)|(Windows_95)',
		'2' => '(Windows 98)|(Win98)',
		'4' => '(Windows NT 5.0)|(Windows 2000)',
		'5' => '(Windows NT 5.1)|(Windows XP)',
		'52' => '(Windows NT 5.2)',
		'6' => '(Windows NT 6.0)',
		'7' => '(Windows NT 6.1)',
		'40' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
		'3' => 'Windows ME',
		'10' => 'OpenBSD',
		'11' => 'SunOS',
		'8' => '(Linux)|(X11)',
		'9' => '(Mac_PowerPC)|(Macintosh)',
		'12' => 'QNX',
		'13' => 'BeOS',
		'14' => 'OS\/2',
		'15' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp)|(MSNBot)|(Ask Jeeves\/Teoma)|(ia_archiver)'
	);
	foreach ($OSList as $CurrOS => $Match) {
		if (preg_match('/' . $Match . '/', $_SERVER['HTTP_USER_AGENT'])) {
			return $CurrOS;
		}
	}
}

//--------------------------------------------------------------------------------------------------------------
// GET LANGUAGE
//--------------------------------------------------------------------------------------------------------------
function get_language() {
	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		$languages = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$languages = str_replace(' ', '', $languages);
		$languages = explode(',', $languages);
	}
	return $languages[0];
}

//--------------------------------------------------------------------------------------------------------------
// GET IP2GEOLOCATION
//--------------------------------------------------------------------------------------------------------------
function ip2geo() {
	$ip = (isset($_POST['prm'])) ? $_POST['prm'] : $_SERVER['REMOTE_ADDR'];
	$db = new DBUrl();
	$ret = $db->ip2geo($ip);
	unset($stmt, $db);
	return $ret;
}

//--------------------------------------------------------------------------------------------------------------
// GET REFERER INFORMATION
//--------------------------------------------------------------------------------------------------------------
function getReferer() {
	global $referrer;
	if (isset($referrer) && $referrer != '') {
		$parts_url = parse_url($referrer);
		$referer = preg_match('/google/', $parts_url['host']) ? 'Google' : urlencode($_SERVER['REQUEST_URI']);
		return $referer;
	} else {
		return 'none';
	}
}

//--------------------------------------------------------------------------------------------------------------
// GET TYPE OF VISITOR (NEW=0 OR RETURNING=1)
//--------------------------------------------------------------------------------------------------------------
function getVisitorType() {
	$n_sha = sha1(str_replace('.', '', getBrowser()) . $_SERVER['HTTP_HOST'] . $_SERVER['REMOTE_ADDR']);
	$cookieDomain = getDomainForCookie($_SERVER['HTTP_HOST']);
	if (isset($_COOKIE['n_sha']) && ($n_sha == $_COOKIE['n_sha'])) {
		setcookie("n_sha", $n_sha, (time() + 60 * 60 * 24 * 30 * 6), "/", $cookieDomain);
		return array('1', $n_sha);
	} else {
		setcookie("n_sha", $n_sha, (time() + 60 * 60 * 24 * 30 * 6), "/", $cookieDomain);
		return array('0', $n_sha);
	}
}

function getDomainForCookie($str) {
	$m = substr_count($str, '.');
	if ($m > 0) {
		switch ($m) {
			case 1:
				return '.' . $str;
			case 2:
				$p = strpos($str, '.');
				return substr($str, $p);
			default:
				$L1 = strpos($str, '.');
				$L2 = strpos($str, '.', $L1 - 1);
				return substr($str, $L2);
		}
	}
	return '';
}
