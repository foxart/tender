<?php
session_start();
require_once('class_db.php');
require_once('class_sql.php');
require_once('class_mdm.php');
include('functions.php');
$mdmObj = new MDM();
$mdmObj->setFormFieldsArr(
	array(
		'goal',
		'first_name',
		//'last_name',
		'job_department',
		'company_email',
		'phone',
		'country',
		'city',
		//'zip_code',
		'company_name',
		//'company_web',
		'primary_use'
		//'industry',
		//'employees',
		//'deployment_timeframe',
		//'info_source',
		//'confirm'
	)
);
// get affiliate id
$affiliate_id = isset($_REQUEST['afid']) ? intval($_REQUEST['afid']) : (isset($_SESSION['affiliate_id']) ? $_SESSION['affiliate_id'] : 0);
$_SESSION['affiliate_id'] = $affiliate_id;
$mdmObj->allFieldsArr['affiliate_id']['value'] = $affiliate_id;
if ($_POST) {	
	$mdmObj->checkEmpty('goal', 'Type of request is required') and
		$mdmObj->checkXSS('goal', 'Invalid (Eg: tags are not allowed for type of request)');
	$mdmObj->checkEmpty('first_name', 'Full name is required') and
		$mdmObj->checkXSS('first_name', 'Invalid (Eg: tags are not allowed in full name)');
	//$mdmObj->checkEmpty('last_name', 'Last name is required') and
		//$mdmObj->checkXSS('last_name', 'Invalid (Eg: tags are not allowed in last name)');
	if( !empty($_REQUEST['job_department']))
		$mdmObj->checkXSS('job_department', 'Invalid (Eg: tags are not allowed in job department)');
	$mdmObj->checkEmpty('company_email', 'Company email is required') and
		$mdmObj->checkValidEmail('company_email', 'Invalid Company email') and
		$mdmObj->checkAgainstFreeEmail('company_email', 'Please provide your company email id for company email');
	$mdmObj->checkEmpty('phone', 'Phone is required') and
		$mdmObj->ckeckPhone('phone', 'Invalid phone number');
	$mdmObj->checkEmpty('country', 'Country is required') and
		$mdmObj->checkXSS('country', 'Invalid (Eg: tags are not allowed in country)');
	$mdmObj->checkEmpty('city', 'City is required') and
		$mdmObj->checkXSS('city', 'Invalid (Eg: tags are not allowed in city)');
	//$mdmObj->checkEmpty('zip_code', 'Zip code is required') and
		//$mdmObj->checkXSS('zip_code', 'Invalid (Eg: tags are not allowed in zip code)');
	$mdmObj->checkEmpty('company_name', 'Company name is required') and
		$mdmObj->checkXSS('company_name', 'Invalid (Eg: tags are not allowed in company name)');
	//$mdmObj->checkEmpty('company_web', 'Company web is required') and
		//$mdmObj->checkUrl('company_web', 'Invalid website URL');
	$mdmObj->checkEmpty('primary_use', 'Primary use is required') and
		$mdmObj->checkXSS('primary_use', 'Invalid (Eg: tags are not allowed in primary use)');
	//$mdmObj->checkEmpty('industry', 'Industry is required') and
		//$mdmObj->checkXSS('industry', 'Invalid (Eg: tags are not allowed in industry)');
	//$mdmObj->checkEmpty('employees', 'Employees is required') and
		//$mdmObj->checkXSS('employees', 'Invalid (Eg: tags are not allowed in employees)');
	//$mdmObj->checkEmpty('confirm', 'You should accept our terms of agreement') and
		//$mdmObj->checkXSS('confirm', 'Invalid (Eg: tags are not allowed for terms of agreement)');
	// no error
	if( empty($mdmObj->commonErrMsgArr)) {
		$sqlObj = SQL::getInstance();
		$mdmObj->connectSQL($sqlObj);
		// add data to db
		$isAdded = $mdmObj->addSalesData();
		if( $isAdded) {
			$mdmObj->sendMailForSales();
			echo '<div class="success">Thank you. A Comodo representative will contact you shortly.</div>';
		} else {
			echo '<font style="color: #FF0000; font-size: 12px;">Something wrong while processing data, please try again later!</font>';
		}
	} else { // error
		$err_string = implode(' , ', $mdmObj->commonErrMsgArr);
		$err_string = str_lreplace(' , ', ' and ', $err_string);
		echo '<font style="color: #FF0000; font-size: 12px;">'.'Errors Found: ' . $err_string .'</font>';
	}
}
exit;
?>