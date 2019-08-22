<?php
// ini_set('display_errors',1);
require_once ('class_db.php');
require_once ('class_sql.php');
require_once ('class_mdm.php');
$no_records = '';
$mdmObj = new MDM();
if ($_POST) {
	$filter_by = $mdmObj->cleanQuery(trim($_POST['filter_by'])); // free_trial
	                                                             // resource
	                                                             // sales_request
	$css_value_arr = array(
					'resource' => '"Name","Email","Phone","MDM Resource","Timestamp","IP address","Affiliate Id","Webform Name","Webform Id"',
					'sales_request' => '"Full Name","Job Title Department","Email Address","Phone Number","Country","City","Company Name","Primary Use","Timestamp","IP address","Affiliate Id","Webform Name","Webform Id"',
					'demo_request' => '"Full Name","Job Title Department","Email Address","Phone Number","Country","City","Company Name","Primary Use","Timestamp","IP address","Affiliate Id","Webform Name","Webform Id"',
					'free_trial' => '"Full Name","Job Title Department","Email Address","Phone Number","Country","City","Company Name","Primary Use","Timestamp","IP address","Affiliate Id","Webform Name","Webform Id"',
					'mdm-contact-form' => '"First Name","Last Name","Country","Company Name","Company Email","Company Website","Message","Timestamp","IP address","Affiliate Id","Webform Name","Webform Id"'
	);
	$sqlObj = SQL::getInstance();
	$mdmObj->connectSQL($sqlObj);
	$res = $mdmObj->getReportsVTiger($filter_by);
	if (is_array($res) && count($res) > 0) { // echo '<pre>';print_r($res);echo
	                                       // '</pre>';exit;
		$csv_value = '';
		$csv_value = $css_value_arr[$filter_by] . "\n\n";
		$csv_value .= $mdmObj->getCsvRows($res, $filter_by);
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=" . $filter_by . "-MDM.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $csv_value;
		exit();
	} else {
		$no_records = 'The selected date contains no record';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="//cdn.optimizely.com/js/8018129.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Comodo Endpoint Security | MDM Report</title>
<meta name="description" content=" Enterprise Comodo Report" />
<meta name="keywords" content=" Enterprise Comodo Report" />
<link href="dbresult_includes/css/reset.css" rel="stylesheet"
	type="text/css" />
<link href="dbresult_includes/css/styles.css" rel="stylesheet"
	type="text/css" />
<link href="dbresult_includes/css/blitzer/blitzer.css" rel="stylesheet"
	type="text/css" />
<script src="dbresult_includes/js/jquery.js" type="text/javascript"></script>
<script src="dbresult_includes/js/jquery-ui.js" type="text/javascript"></script>
<link type="text/css"
	href="dbresult_includes/css/ui-lightness/jquery-ui-1.8.11.custom.css"
	rel="stylesheet" />
<script type="text/javascript"
	src="dbresult_includes/js/jquery-1.5.1.min.js"></script>
<script type="text/javascript"
	src="dbresult_includes/js/jquery-ui-1.8.11.custom.min.js"></script>
<script>
	$(function() {
		$( "#startdate").datepicker({showOn: 'button', buttonImage: 'dbresult_includes/images/caleder_icon2.jpg', buttonImageOnly: true, dateFormat: 'yy-mm-dd'});
		$( "#enddate").datepicker({showOn: 'button', buttonImage: 'dbresult_includes/images/caleder_icon2.jpg', buttonImageOnly: true, dateFormat: 'yy-mm-dd'});
	});
	$(document).ready(function(){ 
	$('#get_report').click(function(){
	if (document.survey_result.startdate.value=="")
					{
						alert("Please select Start Date");
						document.survey_result.startdate.focus();
						return false;
					}
					if  (document.survey_result.enddate.value=="")
					{
						alert("Please select End Date");
						document.survey_result.enddate.focus();
						return false;
					}
	});
	});
	</script>
<style type="text/css">
.style1 {
	font-weight: bold;
}
</style>
</head>
<body>
	<!-- ClickTale Top part -->
	<script type="text/javascript"> 
var WRInitTime=(new Date()).getTime(); 
</script>
	<!-- ClickTale end of Top part -->
	<div class="container">
		<div id="header">
			<a href="" title="Comodo Internet Security">Comodo - Creating Trust
				Online</a>
		</div>
		<!-- end header -->
		<div id="content-top"></div>
		<div id="content">
			<div class="dark_stripe">
				<div class="top"></div>
				<h1>MDM Report</h1>
				<div class="bottom"></div>
			</div>
			<div class="content-title"></div>
			<div class="survey_result">
				<form name="survey_result" id="survey_result"
					action="mdm-db-records.php" method="post"
					onsubmit="return validate();">
					<table width="800" border="0">
						<tr valign="top" align="left" height="30">
							<td width="200">Start Date</td>
							<td width="200">End Date</td>
							<td width="200">Report For</td>
							<td width="200">&nbsp;</td>
						</tr>
						<tr>
							<td><input type="text" name="startdate" id="startdate"
								width="100" class="text_box" style="vertical-align: top;"
								value="<?php if(isset($_REQUEST['startdate'])){ echo $_REQUEST['startdate'];}?>"
								readonly /></td>
							<td><input type="text" name="enddate" id="enddate" width="100"
								class="text_box" style="vertical-align: top;"
								value="<?php if(isset($_REQUEST['enddate'])){ echo $_REQUEST['enddate'];}?>"
								readonly /></td>
							<td><select name="filter_by">
									<option value="resource"
										<?php if($mdmObj->isSelected('resource')){?>
										selected="selected" <?php }?>>Resources Download</option>
									<option value="sales_request"
										<?php if($mdmObj->isSelected('sales_request')){?>
										selected="selected" <?php }?>>Sales Request</option>
									<option value="demo_request"
										<?php if($mdmObj->isSelected('demo_request')){?>
										selected="selected" <?php }?>>Demo Request</option>
									<option value="free_trial"
										<?php if($mdmObj->isSelected('free_trial')){?>
										selected="selected" <?php }?>>Free Trial Request</option>
									<option value="mdm-contact-form"
										<?php if($mdmObj->isSelected('mdm-contact-form')){?>
										selected="selected" <?php }?>>Contact Form</option>
							</select></td>
							<td valign="top"><input name="submit" type="submit"
								value="Get Report" id="get_report" style="padding: 3px;" /></td>
						</tr>
					</table>
				</form>
				<div
					style="font-size: 12px; font-weight: bold; color: #FF0000; padding-left: 50px;"><?php if($no_records!='')  {echo $no_records;}?></div>
			</div>
			<div class="clear"></div>
		</div>
		<div id="content-bottom"></div>
	</div>
	<!-- end container -->
	<!-- ClickTale Bottom part -->
	<div id="ClickTaleDiv" style="display: none;"></div><?php /*?> 
<script type="text/javascript"> 
if(document.location.protocol!='https:') 
  document.write(unescape("%3Cscript%20src='http://s.clicktale.net/WRd.js&#39;%20type=&#39;text/javascript&#39;%3E%3C/script%3E"));
</script> 
<script type="text/javascript"> 
if(typeof ClickTale=='function') ClickTale(6350,0.0352,"www08"); 
</script> <?php */?>
<!-- ClickTale end of Bottom part -->
</body>
</html>