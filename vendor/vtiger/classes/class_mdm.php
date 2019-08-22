<?php
class MDM extends SQL {
	var $sqlObj = NULL;
	var $allFieldsArr = array();
	var $commonErrMsgArr = array();
	// vtiger table fields limitation
	var $vtiger_table_fields_limitation_arr = array(
		array( 'field_name' => 'first_name', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'last_name', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'company', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'title', 'data_type' => 'character', 'limit' => 50),
		array( 'field_name' => 'phone', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'email', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'country', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'state', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'no_of_emp', 'data_type' => 'integer', 'limit' => 0),
		array( 'field_name' => 'no_of_clients', 'data_type' => 'integer', 'limit' => 0),
		array( 'field_name' => 'customer_website', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'industry', 'data_type' => 'character', 'limit' => 200),
		array( 'field_name' => 'source', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'record_status', 'data_type' => 'character', 'limit' => 50),
		array( 'field_name' => 'pg_create_date', 'data_type' => 'timestamp', 'limit' => 0),
		array( 'field_name' => 'pg_update_date', 'data_type' => 'timestamp', 'limit' => 0),		
		array( 'field_name' => 'comodo_webform_id', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'id', 'data_type' => 'serial', 'limit' => 0),
		array( 'field_name' => 'comodo_website', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'comodo_webform_name', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'priority', 'data_type' => 'integer', 'limit' => 0),
		array( 'field_name' => 'description', 'data_type' => 'character', 'limit' => 255),
		array( 'field_name' => 'vtiger_potential_id', 'data_type' => 'bigint', 'limit' => 0),
		array( 'field_name' => 'vtiger_load_date', 'data_type' => 'date', 'limit' => 0),
		array( 'field_name' => 'local_ip_address', 'data_type' => 'character', 'limit' => 20),		
		array( 'field_name' => 'primary_use', 'data_type' => 'character', 'limit' => 25),
		array( 'field_name' => 'affiliate_id', 'data_type' => 'bigint', 'limit' => 0),
		array( 'field_name' => 'destination', 'data_type' => 'character', 'limit' => 30),
		array( 'field_name' => 'module_name', 'data_type' => 'character', 'limit' => 30),
		array( 'field_name' => 'handling_group', 'data_type' => 'character', 'limit' => 30)
	);
	function __construct() {
	}
	function connectSQL($sqlObj) {
		$this->sqlObj = $sqlObj;
	}
	function setFormFieldsArr($allFieldsArr) {//echo '<pre>';print_r($allFieldsArr);echo '</pre>';exit;
		if( !empty($allFieldsArr)) {
			foreach( $allFieldsArr as $fldname) {
				$fldvalue = !empty($_REQUEST[$fldname]) ? $_REQUEST[$fldname] : '';
				$this->allFieldsArr[$fldname]['value'] = trim($fldvalue);
				$this->allFieldsArr[$fldname]['css_class'] = '';
			}
		}
	}
	function getFormFieldValue($fldname) {
		return $this->allFieldsArr[$fldname]['value'];
	}
	function getFormFieldCSS_Class($fldname) {
		return $this->allFieldsArr[$fldname]['css_class'];
	}
	function checkEmpty($fldname, $errmsg) {
		if( empty($this->allFieldsArr[$fldname]['value'])) {
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
	function checkXSS($fldname, $errmsg) {
		$original_value = $this->allFieldsArr[$fldname]['value'];
		$xss_evaluated_value = $this->xss_validate($original_value);
		if ( $original_value != $xss_evaluated_value) {
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
	function checkAgainstFreeEmail($fldname, $errmsg) {
		$free_email_lists = array('aol', 'gmail', 'laposte', 'opolis', 'ovi', 'rediff', 'sify', 'yahoo', 'hotmail', 'yandex');
		$email = $this->allFieldsArr[$fldname]['value'];
		$explode = explode('@', $email);
		$end = end($explode);
		$email_part = strtolower($end);
		// $email_part = strtolower(end(explode('@', $email)));
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
		$this->allFieldsArr[$fldname]['css_class'] = 'error';
	}
	function truncate_table_column($db_fld, $value) {
		$vtiger_table_fields_limitation_arr = $this->vtiger_table_fields_limitation_arr;
		foreach($vtiger_table_fields_limitation_arr as $fields) {
			if( $fields['field_name'] == $db_fld) {
				if( $fields['data_type'] == 'integer' || $fields['data_type'] == 'bigint')
					return intval($value);
				if (strlen($value) >= $fields['limit'])
					return substr($value, 0, ($fields['limit']-1));
			}
		}
		return $value;
	}
	function addResourceData() {
		$all_fields_arr = array('first_name' => 'resource_name', 'email' => 'resource_email', 'phone' => 'resource_phone', 'title' => 'doc');
		foreach($all_fields_arr as $db_fld => $field_name) {
			$$field_name = $this->sqlObj->clean($this->allFieldsArr[$field_name]['value']);
			$$field_name = $this->truncate_table_column($db_fld, $$field_name);
		}
        if($doc == "datasheet")
            $doc = "CMDM Data Sheet";
        else  if($doc == "download")
            $doc = "CMDM FAQs";
		else  if($doc == "brochure")
            $doc = "CMDM Brochure";
		else 
			$doc = "CMDM Whitepaper";
		$source = 'Mobileform';
		$comodo_webform_id = '{9C2D2F54-5E0A-4E3B-B35B-376C73533E8E}';
		$comodo_webform_name = 'MDM Resource';
		$comodo_website = 'mdm.comodo.com';
		$local_ip_address = $_SERVER['REMOTE_ADDR'];
		$local_ip_address = $this->truncate_table_column('local_ip_address', $local_ip_address);
		$affiliate_id = $this->allFieldsArr['affiliate_id']['value'];
		$sql = 'INSERT INTO ext_data.web_lead '.
				'('.
				' first_name,'.
				' last_name,'.
				' company,'.
				' title,'.
				' phone,'.
				' email,'.
				' customer_website,'.
				' local_ip_address,'.
				' affiliate_id,'.
				' source,'.
				' comodo_webform_id,'.
				' comodo_website,'.
				' comodo_webform_name'.
				') VALUES ('.
				'\'' . $resource_name . '\','.
				'\'\','.
				'\'\','.
				'\'' . $doc . '\','.
				'\'' . $resource_phone . '\','.
				'\'' . $resource_email . '\','.
				'\'\','.
				'\'' . $local_ip_address . '\','.
				'\'' . $affiliate_id . '\','.
				'\'' . $source . '\','.
				'\'' . $comodo_webform_id . '\','.
				'\'' . $comodo_website . '\','.
				'\'' . $comodo_webform_name . '\''.
				')';
		$result = $this->sqlObj->query($sql);
		return $result;
	}
	function addContactData() {
		$all_fields_arr = array('first_name' => 'first_name', 'last_name' => 'last_name', 'country' => 'country',
								'company' => 'company_name', 'email' => 'company_email', 'customer_website' => 'company_web', 'description' => 'message');
		foreach($all_fields_arr as $db_fld => $field_name) {
			$$field_name = $this->sqlObj->clean($this->allFieldsArr[$field_name]['value']);
			$$field_name = $this->truncate_table_column($db_fld, $$field_name);
		}
		$local_ip_address = $_SERVER['REMOTE_ADDR'];
		$local_ip_address = $this->truncate_table_column('local_ip_address', $local_ip_address);
		$affiliate_id = $this->allFieldsArr['affiliate_id']['value'];
		$comodo_website = 'mdm.comodo.com';
		$source = 'Mobileform';
		$comodo_webform_id = '{B2C1964F-59EE-4061-AD1D-58D3162441B2}';
		$comodo_webform_name = 'MDM Contact Form';
		$sql = 'INSERT INTO ext_data.web_lead '.
				'('.
				' first_name,'.
				' last_name,'.
				' company,'.
				' title,'.
				' email,'.
				' country,'.
				' customer_website,'.
				' local_ip_address,'.
				' description,'.
				' affiliate_id,'.
				' source,'.
				' comodo_webform_id,'.
				' comodo_website,'.
				' comodo_webform_name'.
				') VALUES ('.
				'\'' . $first_name . '\','.
				'\'' . $last_name . '\','.
				'\'' . $company_name . '\','.
				'\'\','.
				'\'' . $company_email . '\','.
				'\'' . $country . '\','.
				'\'' . $company_web . '\','.
				'\'' . $local_ip_address . '\','.
				'\'' . $message . '\','.
				'\'' . $affiliate_id . '\','.
				'\'' . $source . '\','.
				'\'' . $comodo_webform_id . '\','.
				'\'' . $comodo_website . '\','.
				'\'' . $comodo_webform_name . '\''.
				')';
		$result = $this->sqlObj->query($sql);
		return $result;
	}
	function addSalesData() {
		$all_fields_arr = array('goal' => 'goal', 'first_name' => 'first_name', 'company' => 'company_name', 'title' => 'job_department',
								'phone' => 'phone', 'email' => 'company_email', 'country' => 'country', 'city' => 'city', 'primary_use' => 'primary_use');
		foreach($all_fields_arr as $db_fld => $field_name) {
			$$field_name = $this->sqlObj->clean($this->allFieldsArr[$field_name]['value']);
			if($db_fld != 'goal' && $db_fld != 'city')
				$$field_name = $this->truncate_table_column($db_fld, $$field_name);
		}
		$goal = $this->allFieldsArr['goal']['value'];
		$source = 'Mobileform';
		if( $goal == 'sale') {
			$comodo_webform_id = '{35C96E64-B4CB-4203-A8EC-6D2A5085BF27}';
			$comodo_webform_name = 'MDM Sales Request';
		} else if( $goal == 'demo') {
			$comodo_webform_id = '{A18C01B3-464F-444C-B853-FA67D0DB97B5}';
			$comodo_webform_name = 'MDM Demo request';
		} else {
			$comodo_webform_id = '{90179FBC-3C9C-47B0-853A-EF5254818DD9}';
			$comodo_webform_name = 'MDM Free Trial Request';
		}
		// caz, no_of_emp field in table is set as integer
		$employees = 0;//intval($employees);
		$affiliate_id = $this->allFieldsArr['affiliate_id']['value'];
		$comodo_website = 'mdm.comodo.com';
		$local_ip_address = $_SERVER['REMOTE_ADDR'];
		$local_ip_address = $this->truncate_table_column('local_ip_address', $local_ip_address);
		$description = 'City: '.$city;
		$description = $this->truncate_table_column('description', $description);
		$sql = 'INSERT INTO ext_data.web_lead '.
				'('.
				' first_name,'.
				' last_name,'.
				' company,'.
				' title,'.
				' phone,'.
				' email,'.
				' country,'.
				' no_of_emp,'.
				' customer_website,'.
				' industry,'.
				' local_ip_address,'.
				' primary_use,'.
				' description,'.
				' affiliate_id,'.
				' source,'.
				' comodo_webform_id,'.
				' comodo_website,'.
				' comodo_webform_name'.
				') VALUES ('.
				'\'' . $first_name . '\','.
				'\'\','.
				'\'' . $company_name . '\','.
				'\'' . $job_department . '\','.
				'\'' . $phone . '\','.
				'\'' . $company_email . '\','.
				'\'' . $country . '\','.
				'\'' . $employees . '\','.
				'\'\','.
				'\'\','.
				'\'' . $local_ip_address . '\','.
				'\'' . $primary_use . '\','.
				'\'' . $description . '\','.
				'\'' . $affiliate_id . '\','.
				'\'' . $source . '\','.
				'\'' . $comodo_webform_id . '\','.
				'\'' . $comodo_website . '\','.
				'\'' . $comodo_webform_name . '\''.
				')';
		$result = $this->sqlObj->query($sql);
		return $result;
	}
	function sendMailForResource() {
        if($this->allFieldsArr['doc']['value'] == "datasheet"){
            $doc = "CMDM-Data-Sheet.pdf";
            $docTitle = "CMDM Data Sheet";
        } else if($this->allFieldsArr['doc']['value'] == "download") {
            $doc = "mdm-faq.pdf";
			$docTitle = "CMDM FAQs";
        } else  if($this->allFieldsArr['doc']['value'] == "brochure") {
            $doc = "CMDM-Brochure.pdf";
			$docTitle = "CMDM Brochure";
		} else {
			$doc = "MDM-WhitePaper.pdf";
			$docTitle = "CMDM Whitepaper";
		}
		$resource_phone = !empty($this->allFieldsArr['resource_phone']['value']) ? $this->allFieldsArr['resource_phone']['value'] : '--';
		//$to = 'david.colon@comodo.com,jacqueline.rivera@comodo.com,joseph.raftery@comodo.com';//'jerosilinvinoth.jeyaraj@comodo.com';//
        $to = 'mdmsales@comodo.com,ilker.simsir@comodo.com';//'jerosilinvinoth.jeyaraj@comodo.com';// RF-4624
		$subject = 'A New Lead for MDM Resources Download '. $docTitle .' from mdm.comodo.com';
		$cur_date = date('Y-m-d G:i:s');
		$message = "Lead Detail:\n\n User Name: ".$this->allFieldsArr['resource_name']['value'];
		$message .= "\n Email: ".$this->allFieldsArr['resource_email']['value'];
		$message .= "\n Phone: ". $resource_phone;
        $message .= "\n Document: " . $docTitle;
		$message .= "\n Timestamp: ".$cur_date;
		$message .= "\n IP Address: ".$_SERVER['REMOTE_ADDR'];
		$message .= "\n\n";
		$headers = 'From: mdm.comodo.com <mdmsales@comodo.com>' . "\r\n" .
				   //'Reply-To: in.careers@comodo.com' . "\r\n" .
				   //'Cc: patrick.troy@comodo.com' . "\r\n" .
				   'X-Mailer: PHP/' . phpversion();
		@mail($to, $subject, $message, $headers);
        //send email for PDF to customer
        $toCustomer = $this->allFieldsArr['resource_email']['value'];
        $subjectCustomer = 'Download MDM Resources '. $docTitle .' - mdm.comodo.com';
        $messageC = "Hi ".$this->allFieldsArr['resource_name']['value'];
		$messageC .= "\n<br /> Please check our <b>". $docTitle ."</b> <a href=\"https://mdm.comodo.com/pdf/". $doc ."\">here</a>";
		$messageC .= "\n<br /> <b>Timestamp:</b> ".$cur_date;
		$messageC .= "\n\n";
        $headersC = "MIME-Version: 1.0" . "\n";
        $headersC .= "Content-type:text/html;charset=utf-8" . "\n";
        $headersC .= "From: MDM <do-not-reply@comodo.com>\n";
        $headersC .= 'Return-Path: ' . 'do-not-reply@comodo.com' . "\n";
        @mail($toCustomer, $subjectCustomer, $messageC, $headersC);
	}
	function sendMailForSales() {
		//$to = 'david.colon@comodo.com,jacqueline.rivera@comodo.com';//'jerosilinvinoth.jeyaraj@comodo.com';//
		//$to = 'ilker.simsir@comodo.com,mdm@comodo.com,david.colon@comodo.com,jacqueline.rivera@comodo.com';//'jerosilinvinoth.jeyaraj@comodo.com';//
		$to = 'mdm@comodo.com'; //RF-4624
		$goal = $this->allFieldsArr['goal']['value'];
		if( $goal == 'sale') {			
			$subject = 'A New Lead for MDM Sales Request from mdm.comodo.com';
		} else if( $goal == 'demo') {
			$subject = 'A New Lead for MDM Demo request from mdm.comodo.com';
		} else {
			$subject = 'A New Lead for MDM Free Trial Request from mdm.comodo.com';
		}
		$cur_date = date('Y-m-d G:i:s');		
		$noofemp = array (
			100 => '0-99',
			500 => '100-499',
			1000 => '500-999',
			5000 => '1,000-4,999',
			5001 => '5,000+'
		);
		$message = "Lead Detail, <br>";
		$message .= "<br> Full Name: ".$this->allFieldsArr['first_name']['value'];
		//$message .= "<br> Last Name: ".$this->allFieldsArr['last_name']['value'];
		$message .= "<br> Job Title Department: ".$this->allFieldsArr['job_department']['value'];
		$message .= "<br> Email Address: ".$this->allFieldsArr['company_email']['value'];
		$message .= "<br> Phone Number: ".$this->allFieldsArr['phone']['value'];
		$message .= "<br> Country: ".$this->allFieldsArr['country']['value'];		
		$message .= "<br> City: ".$this->allFieldsArr['city']['value'];
		//$message .= "<br> Zip / Postal Code: ".$this->allFieldsArr['zip_code']['value'];
		$message .= "<br> Company Name: ".$this->allFieldsArr['company_name']['value'];
		//$message .= "<br> Website: ".$this->allFieldsArr['company_web']['value'];
		$message .= "<br> Primary Use: ".$this->allFieldsArr['primary_use']['value'];
		//$message .= "<br> Industry: ".$this->allFieldsArr['industry']['value'];
		//$message .= "<br> Number of Employees: ".$noofemp[$this->allFieldsArr['employees']['value']];
		//$message .= "<br> Deployment timeframe: ".$this->allFieldsArr['deployment_timeframe']['value'];
		//$message .= "<br> How did you hear about us?: ".(empty($this->allFieldsArr['info_source']['value']) ? '--' : $this->allFieldsArr['info_source']['value']);
		//$message .= "<br> Agree to terms of agreement: ".(empty($this->allFieldsArr['confirm']['value']) ? 'No' : 'Yes');
		$message .= "<br><br>";
		if( $goal == 'sale') {
			$message .= "<br> Sales Request: Yes";
		}  else if( $goal == 'demo') {
			$message .= "<br> Demo request: Yes";
		} else {
			$message .= "<br> Free Trial Request: Yes";
		}
		$message .= "<br> Timestamp of when lead was received: ".$cur_date;		
		$message .= "<br> IP Address: ".$_SERVER['REMOTE_ADDR'];
		$headers = 'From: comodogroup.com <admin@localhost.com>' . "\n".
					'Content-Type: text/html' . "\r\n" .
				   //'Reply-To: in.careers@comodo.com' . "\r\n" .
				   //'Cc: patrick.troy@comodo.com' . "\r\n" .
				   'X-Mailer: PHP/' . phpversion();
		@mail($to, $subject, $message, $headers);
	}
	function xss_validate($data)
	{
		// Fix &entity\n;
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		//make sure _all_ html entities are converted to the plain ascii equivalents - it appears 
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
		//decode url
		//$data = urldecode($data);
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
	function getReportsVTiger($filter_by, $st = "", $rec = "") {
		 $sd = $this->sqlObj->clean(trim($_POST['startdate']));
		 $ed = $this->sqlObj->clean(trim($_POST['enddate']));
		 $sql_filter_by_arr = array(
			'resource'			=> 'comodo_webform_id = \'{9C2D2F54-5E0A-4E3B-B35B-376C73533E8E}\'',
			'sales_request'		=> 'comodo_webform_id = \'{35C96E64-B4CB-4203-A8EC-6D2A5085BF27}\'',
			'demo_request'		=> 'comodo_webform_id = \'{A18C01B3-464F-444C-B853-FA67D0DB97B5}\'',
			'free_trial'		=> 'comodo_webform_id = \'{90179FBC-3C9C-47B0-853A-EF5254818DD9}\'',
			'mdm-contact-form'	=> 'comodo_webform_id = \'{B2C1964F-59EE-4061-AD1D-58D3162441B2}\'',
		);
		 if( !array_key_exists($filter_by, $sql_filter_by_arr))
			$filter_by = 'resource';
		 $query	= "SELECT * FROM ext_data.web_lead ".
						" WHERE date(pg_create_date) BETWEEN '".$sd."' AND '".$ed."'".
						" AND " . $sql_filter_by_arr[$filter_by].
						" ORDER BY pg_create_date DESC";
		//$query = 'delete from ext_data.web_lead where comodo_webform_id = \'{A18C01B3-464F-444C-B853-FA67D0DB97B5}\'';
		$result	= $this->sqlObj->query($query);//echo 'deleted';exit;
		$return = array();
		while( $row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
			$return[] = $row;
		}
		return $return;
	}
	function getCsvRows($res, $filter_by) {//free_trial resource sales_request
		// Convert all HTML entities to their applicable characters and Make it CSV formatted
		$result = array();
		foreach($res as $key => $value_arr)
			foreach($value_arr as $colmn => $value)
				$result[$key][$colmn] = $this->CSVFormatedText($value);
		$res = $result;
		$csv_value = '';
		if($filter_by == 'resource') {
			for($i=0;$i<count($res);$i++) {
				if( strpos($res[$i]['email'], 'IP Address:') !== false) {
					$ip_address = trim(end(explode('IP Address:', $res[$i]['email'])));
					$email = $res[$i]['description'];
				} else {
					$ip_address = !empty($res[$i]['local_ip_address']) ? $res[$i]['local_ip_address'] : trim(end(explode('IP Address:', $res[$i]['description'])));
					$email = $res[$i]['email'];
				}
				$affiliate_id = empty($res[$i]['affiliate_id']) ? '--' : $res[$i]['affiliate_id'];
				$csv_value .= '"'. $res[$i]['first_name'] . '","' . $email . '","' . $res[$i]['phone'] . '","' . $res[$i]['title']  . '","' . date('d M, Y G:i', strtotime($res[$i]['pg_create_date'])) . '","' . $ip_address . '","' . $affiliate_id  .  '","' . $res[$i]['comodo_webform_name']  . '","' . $res[$i]['comodo_webform_id']  . '"' . "\n";
			}
		} else if($filter_by == 'mdm-contact-form') {
			for($i=0;$i<count($res);$i++) {
				$affiliate_id = empty($res[$i]['affiliate_id']) ? '--' : $res[$i]['affiliate_id'];
				$csv_value .= '"'. $res[$i]['first_name'] . '","' . $res[$i]['last_name']  . '","' . $res[$i]['country']  . '","' . $res[$i]['company']  . '","' . $res[$i]['email']  . '","' . $res[$i]['customer_website'] . '","' . $res[$i]['description'] . '","' . date('d M, Y G:i', strtotime($res[$i]['pg_create_date'])) . '","' . $res[$i]['local_ip_address'] . '","' . $affiliate_id  . '","' . $res[$i]['comodo_webform_name']  . '","' . $res[$i]['comodo_webform_id'] . '"'. "\n";
			}
		} else {
			for($i=0;$i<count($res);$i++) {
				if( !empty($res[$i]['local_ip_address'])) {
					$ip_address = $res[$i]['local_ip_address'];
					$primary_use = $res[$i]['primary_use'];
					$description_arr = explode("\n", $res[$i]['description']);
					$city = isset($description_arr[0]) ? trim(end(explode('City:', $description_arr[0]))) : '--';
					/*$zip = isset($description_arr[1]) ? trim(end(explode('Zip Code:', $description_arr[1]))) : '';
					$deployment = isset($description_arr[2]) ? trim(end(explode('Deployment Timeframe:', $description_arr[2]))) : '--';
					$deployment = empty($deployment) ? '--' : $deployment;
					$info = isset($description_arr[3]) ? trim(end(explode('Info Source:', $description_arr[3]))) : '--';
					$info = empty($info) ? '--' : $info;
					$agree = isset($description_arr[4]) ? trim(end(explode('Agree:', $description_arr[4]))) : '--';
					$noofemp = array (
						100 => '0-99',
						500 => '100-499',
						1000 => '500-999',
						5000 => '1,000-4,999',
						5001 => '5,000+'
					);
					$noofemp = isset($noofemp[$res[$i]['no_of_emp']]) ? $noofemp[$res[$i]['no_of_emp']] : '--';*/
				} else {
					$description_arr = explode("\n", $res[$i]['description']);
					$ip_address = trim(end(explode('IP Address:', $description_arr[0])));
					$city = trim(end(explode('City:', $description_arr[1])));
					/*$zip = trim(end(explode('Zip Code:', $description_arr[2])));
					$deployment = trim(end(explode('Deployment Timeframe:', $description_arr[3])));
					$deployment = empty($deployment) ? '--' : $deployment;
					$info = trim(end(explode('Info Source:', $description_arr[4])));
					$info = empty($info) ? '--' : $info;
					$agree = trim(end(explode('Agree:', $description_arr[5])));
					$noofemp = array (
						100 => '0-99',
						500 => '100-499',
						1000 => '500-999',
						5000 => '1,000-4,999',
						5001 => '5,000+'
					);
					$noofemp = isset($noofemp[$res[$i]['no_of_emp']]) ? $noofemp[$res[$i]['no_of_emp']] : '--';*/
					$primary_use = isset($description_arr[6]) ? trim(end(explode('Primary Use:', $description_arr[6]))) : '--';
				}
				$affiliate_id = empty($res[$i]['affiliate_id']) ? '--' : $res[$i]['affiliate_id'];
				$csv_value .= '"'. $res[$i]['first_name']  . '","' . $res[$i]['title'] . '","' . $res[$i]['email']  . '","' . $res[$i]['phone']  .  '","' . $res[$i]['country']  . '","' . $city  . '","' . $res[$i]['company'] . '","' . $primary_use  . '","' . date('d M, Y G:i', strtotime($res[$i]['pg_create_date'])) . '","' . $ip_address . '","' . $affiliate_id  . '","' . $res[$i]['comodo_webform_name']  . '","' . $res[$i]['comodo_webform_id']  . '"'. "\n";
			}
		}
		return $csv_value;
	}
	function isSelected($fld_value) {
		if( isset($_REQUEST['filter_by']) and $_REQUEST['filter_by'] == $fld_value)
			return true;
		return false;
	}
	function CSVFormatedText($string) {
		$dataElement = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		// Replaces a double quote with two double quotes
    	$dataElement=str_replace("\"", "\"\"", $dataElement);
		return $dataElement;
	}
}
?>