<?php
class Common extends SQL {
	var $allFieldsArr = array();
	var $commonErrMsgArr = array();
	var $sqlObj = NULL;
	var $error_css_class = 'error';
	function __construct() {
	}
	function connectSQL($sqlObj) {
		$this->sqlObj = $sqlObj;
	}
	function setFormFieldsArr($allFieldsArr) {
		if( !empty($allFieldsArr)) {//print_r($allFieldsArr);exit;
			foreach( $allFieldsArr as $fldname) {
				$fldvalue = !empty($_REQUEST[$fldname]) ? $_REQUEST[$fldname] : '';
				if(!is_array($fldvalue)) {
					$this->allFieldsArr[$fldname]['value'] = trim($fldvalue);
					$this->allFieldsArr[$fldname]['css_class'] = '';
				}
			}
		}
	}
	function getFormFieldValue($fldname, $arrValue = '') {
		if($arrValue === '') {
			return $this->allFieldsArr[$fldname]['value'];
		} else {
			if(isset($_REQUEST[$fldname]) and in_array($arrValue, $_REQUEST[$fldname]))
				return true;
			return false;
		}
	}
	function getFormFieldCSS_Class($fldname) {
		return $this->allFieldsArr[$fldname]['css_class'];
	}
	function checkEmpty($fldname, $errmsg, $chkMin = 0, $chkMax = 0) {
		$value = $this->allFieldsArr[$fldname]['value'];
		$length = strlen((string)$value);
		if( empty($value)) {
			$this->setCommonErrMsg($fldname, $errmsg);
			return false;
		}
		// Minimum length check
		if($chkMin and $length < $chkMin) {
			$this->setCommonErrMsg($fldname, 'Minimum length should be '.$chkMin);
			return false;
		}
		// Maximum length check
		if($chkMax and $length > $chkMax) {
			$this->setCommonErrMsg($fldname, 'Maximum length should be '.$chkMax);
			return false;
		}
		return true;	
	}
	function checkEmptyArr($fldname, $errmsg) {
		if(empty($_REQUEST[$fldname])) {
			$this->setCommonErrMsg($fldname, $errmsg);
			return false;
		}
		return true;
	}
	function checkValidEmail($fldname, $errmsg) {
		$regex = '/^[_A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,3})$/';
		if ( !preg_match($regex, $this->allFieldsArr[$fldname]['value'])) {
			$this->setCommonErrMsg($fldname, $errmsg);
			return false;
		}
		return true;
	}
	function validateAlphanumeric($fldname, $errmsg) {
		$regex = '/^[A-Za-z0-9_]+$/';
		if ( !preg_match($regex, $this->allFieldsArr[$fldname]['value'])) {
			$this->setCommonErrMsg($fldname, $errmsg);
			return false;
		}
		return true;
	}
	function validateString($fldname, $errmsg) {
		$flag = false;
		$badchar = '';
		$string = $this->allFieldsArr[$fldname]['value'];
		$length = strlen($string);
		for ($i=0; $i<$length;$i++){
			$c = strtolower(substr($string, $i, 1));
			if (strpos("abcdefghijklmnopqrstuvwxyz ", $c) === false){
				$badchar .=$c;
				$flag = true;
			}
		}
		if ( $flag) {
			$this->setCommonErrMsg($fldname, $errmsg);
			return false;
		}
		return true;
	}
	function checkXSS($fldname, $errmsg, $urlDecodeData = false) {
		$original_value = $this->allFieldsArr[$fldname]['value'];
		$xss_evaluated_value = $this->xss_validate($original_value, $urlDecodeData);
		if ( $original_value != $xss_evaluated_value) {
			$this->setCommonErrMsg($fldname, $errmsg);
			return false;
		}
		return true;
	}
	function checkUrl($fldname, $errmsg) {
		$isok = true;
		$domain = $this->allFieldsArr[$fldname]['value'];
		if(stripos($domain, 'http://') === 0)
			$domain = substr($domain, 7); 
		///Not even a single . this will eliminate things like abcd, since http://abcd is reported valid
		if(!substr_count($domain, '.'))
			$isok = false;
		if(stripos($domain, 'www.') === 0)
			$domain = substr($domain, 4); 
		$again = 'http://' . $domain;
		if (filter_var($again, FILTER_VALIDATE_URL) === FALSE)
			$isok = false;
		if ( !$isok) {
			$this->setCommonErrMsg($fldname, $errmsg);
			return false;
		}
		return true;
	}
	function ckeckPhone($fldname, $errmsg) {
		$regex = '/^\+?([0-9]{1,3})\)?[-. ]?([0-9]{1,4})[-. ]?([0-9]{2,8})[-. ]?([0-9]{2,8})?$/i';
		$number_filter = array('+', '-');
		$number = str_replace($number_filter, '', filter_var($this->allFieldsArr[$fldname]['value'], FILTER_SANITIZE_NUMBER_INT));
		$number_string = (string)$number;
		$phone_length = strlen($number_string);
		//$regex = "/^\+?(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";
		if(preg_match($regex, $this->allFieldsArr[$fldname]['value']) and ($phone_length >= 7 && $phone_length <= 15)) {
			return true;
		} else {
			$this->setCommonErrMsg($fldname, $errmsg);
			return false;
		}		
	}
	function ckeckNumber($fldname, $errmsg) {
		if( !empty($this->allFieldsArr[$fldname]['value'])) {
			$regex = "/^[1-9][0-9]*$/";
			if(!preg_match($regex, $this->allFieldsArr[$fldname]['value'])) {
				$this->setCommonErrMsg($fldname, $errmsg);
				return false;
			}
		}
		return true;
	}
	function checkEmptyOfRadio($fldname, $errmsg) {
		if( !isset($_REQUEST[$fldname])) {
			$this->setCommonErrMsg($fldname, $errmsg);
			return false;
		}
		return true;	
	}
	function checkAgainstFreeEmail($fldname, $errmsg) {
		$free_email_lists = array('aol', 'gmail', 'laposte', 'opolis', 'ovi', 'rediff', 'sify', 'yahoo', 'hotmail', 'yandex');
		$email = $this->allFieldsArr[$fldname]['value'];
		$email_part = strtolower(end(explode('@', $email)));
		$found = false;
		foreach($free_email_lists as $email_provider) {
			if(strpos($email_part, $email_provider) !== FALSE) {
				$found = true;
				break;
			}
		}
		if($found) {
			$this->setCommonErrMsg($fldname, $errmsg);
			return false;
		}
		return true;
	}
	function setCommonErrMsg($fldname, $errmsg) {
		$this->commonErrMsgArr[$fldname] = $errmsg;
		$this->allFieldsArr[$fldname]['css_class'] = $this->error_css_class;
	}
	function setErrMsg($fld_name, $msg) {
		$this->errMsg[$fld_name] = $msg;
		if( !$this->isError) {
			$this->isError = true;
			$this->setErrMsg('common', 'Oops! Error found.');
		}
	}
	function getTotalPendingReview() {
		$sql = 'SELECT COUNT(*) AS cnt FROM reviews '.
				' WHERE status = \'Pending\'';
		$result = $this->sqlObj->query($sql);
		if ( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
			return $row['cnt'];
		}
		return 0;
	}
	function xss_validate($data, $urlDecodeData = false)
	{
		// Fix &entity\n;
		//make sure _all_ html entities are converted to the plain ascii equivalents - it appears 
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
		//decode url
		if($urlDecodeData)
			$data = urldecode($data);
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		// Remove any attribute starting with "on" or xmlns
		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
		// Remove javascript: and vbscript: protocols
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
		// Remove namespaced elements (we do not need them)
		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
		// Some additional checks
		$search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript 
				   /*'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags */
				   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly 
				   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA 
		); 
		$data = preg_replace($search, '', $data);
		//$data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		do
		{
			// Remove really unwanted tags
			$old_data = $data;
			$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		}
		while ($old_data !== $data);
		$data = strip_tags($data);
		// we are done...
		return $data;
	}
	function generateRandomString($length = 15) {
		$characters = 'abcdefghijklmnopqrstuvwxyz';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	function truncate($string, $your_desired_width = 50, $link = 'no', $tail_string = '...') {
		$parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
		$parts_count = count($parts);
		$length = 0;
		$last_part = 0;
		$tail = '';
		for (; $last_part < $parts_count; ++$last_part) {
			$length += strlen($parts[$last_part]);
			if ($length > $your_desired_width) {
				$tail = $tail_string;
				if($link == 'yes')
					$tail .= '<a href="javascript:void(0);" class="clsReadMore grn">Read more</a>';
				break;
			}
		}
		return implode(array_slice($parts, 0, $last_part)).$tail;
	}
	function trimSite($url) {
		if(strpos($url, 'http://') !== false)
			$url = end(explode('http://', $url));
		else if(strpos($url, 'https://') !== false)
			$url = end(explode('https://', $url));
		if(strpos($url, 'www.') !== false)
			$url = end(explode('www.', $url));
		return $url;
	}
	function wrapString($string, $length = 30, $break = "\n", $cut = true) {
		$mytext = explode(" ",trim($string)); 
		$newtext = array(); 
		foreach($mytext as $k => $txt)
		{ 
			if (strlen($txt) > $length) 
			{ 
				$txt = wordwrap($txt, $length, $break, $cut); 
			} 
			$newtext[] = $txt; 
		} 
		return implode(" ",$newtext);
	}
}
?>