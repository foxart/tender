<?php
function clean($string, $allow_tags = FALSE) {
    if ($allow_tags)
        return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
    else
        return htmlspecialchars(strip_tags(trim($string)), ENT_QUOTES, 'UTF-8');
}
function contact_message($mail) {
    $htmlMsg = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style> td { font: normal 12px Arial, sans serif;}</style>
    </head>
    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="3"><b>Contact Form - mdm.comodo.com</b></td>
            </tr>
            <tr>
                <td align="left" width="150">First Name</td>
                <td>:</td>
                <td>'.$mail['first_name'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Last Name</td>
                <td>:</td>
                <td>'.$mail['last_name'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Country</td>
                <td>:</td>
                <td>'.$mail['country'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Company Name</td>
                <td>:</td>
                <td>'.$mail['company_name'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Company Email</td>
                <td>:</td>
                <td>'.$mail['company_email'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Company Website</td>
                <td>:</td>
                <td>'.$mail['company_web'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Message</td>
                <td>:</td>
                <td>'.$mail['message'].'</td>
            </tr>
        </table>
    </body>
    </html>	
    ';
    return $htmlMsg;
}
function sales_message($mail) {
    $html = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style> td { font: normal 12px Arial, sans serif;}</style>
    </head>
    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="3"><b>Sales Form - mdm.comodo.com</b></td>
            </tr>
            <tr>
                <td align="left" width="150">Contact me for:</td>
                <td>:</td>
                <td>'.$mail['goal'].'</td>
            </tr>
            <tr>
                <td colspan="3"><font style="font-size: 12px; font-weight: bold; padding: 5px 0; display: block;">Contact Information</font></td>
            </tr>
            <tr>
                <td align="left" width="150">First Name</td>
                <td>:</td>
                <td>'.$mail['first_name'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Last Name</td>
                <td>:</td>
                <td>'.$mail['last_name'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Job Title Department</td>
                <td>:</td>
                <td>'.$mail['job_department'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Company Email</td>
                <td>:</td>
                <td>'.$mail['company_email'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Phone</td>
                <td>:</td>
                <td>'.$mail['phone'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Country</td>
                <td>:</td>
                <td>'.$mail['country'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">City</td>
                <td>:</td>
                <td>'.$mail['city'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Zip or Postal Code Department</td>
                <td>:</td>
                <td>'.$mail['zip_code'].'</td>
            </tr>
            <tr>
                <td colspan="3"><font style="font-size: 12px; font-weight: bold; padding: 5px 0; display: block;">Company Information</font></td>
            </tr>
            <tr>
                <td align="left" width="150">Company Name</td>
                <td>:</td>
                <td>'.$mail['company_name'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Company Website</td>
                <td>:</td>
                <td>'.$mail['company_web'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Industry</td>
                <td>:</td>
                <td>'.$mail['industry'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Number of Employees</td>
                <td>:</td>
                <td>'.$mail['employees'].'</td>
            </tr>
            <tr>
                <td colspan="3"><font style="font-size: 12px; font-weight: bold; padding: 5px 0; display: block;">Solution Information</font></td>
            </tr>
            <tr>
                <td align="left" width="150">Deployment timeframe </td>
                <td>:</td>
                <td>'.$mail['deployment_timeframe'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">How did you heard about us?</td>
                <td>:</td>
                <td>'.$mail['info_source'].'</td>
            </tr> 
            <tr>
                <td align="left" width="150">I agree with terms of agreement</td>
                <td>:</td>
                <td>'.$mail['confirm'].'</td>
            </tr>
        </table>
    </body>
    </html>	
    ';
    return $html;
}
function resource_message($mail) {
    $docTitle = "FAQs";
    if( $mail['doc'] == "whitepaper") {
        $docTitle = "CMDM Data Sheet";
    }
    $msg = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style> td { font: normal 12px Arial, sans serif;}</style>
    </head>
    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="3"><b>Resource Form - mdm.comodo.com</b></td>
            </tr>
            <tr>
                <td align="left" width="150">Name</td>
                <td>:</td>
                <td>'.$mail['resource_name'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">E-mail</td>
                <td>:</td>
                <td>'.$mail['resource_email'].'</td>
            </tr>
            <tr>
                <td align="left" width="150">Document</td>
                <td>:</td>
                <td>'.$docTitle.'</td>
            </tr>
        </table>
    </body>
    </html>	
    ';
    return $msg;
}
function resourcepdf_message($mail) {
    $doc = "mdm-faq.pdf";
    $docTitle = "FAQs";
    if( $mail['doc'] == "whitepaper") {
        $doc = "CMDM-Data-Sheet.pdf";
        $docTitle = "CMDM Data Sheet";
    }
    $ms = '
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <style> td { font: normal 12px Arial, sans serif;}</style>
    </head>
    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="3"><b>Resource '. $docTitle .' - mdm.comodo.com</b></td>
            </tr>
            <tr>
                <td colspan="3" align="left">
                    Hi '.$mail['resource_name'].', <br />
                        Please check our MDM '. $docTitle .' Document <a href="https://mdm.comodo.com/pdf/'. $doc .'">here</a>
                </td>
            </tr>
            <tr>
                <td align="left" width="150">Document</td>
                <td>:</td>
                <td>'. $docTitle .'</td>
            </tr>
            <tr>
                <td colspan="3">
                    <table width="800" border="0">
                            <tr>
                                <td width="35">
                                </td>
                                <td width="130">
                                    <a href="https://www.comodo.com" title="Comodo" style="text-decoration: none;
                                        color: #fff; font: 14px Arial;">www.comodo.com</a>
                                </td>
                                <td width="600">
                                </td>
                                <td>
                                    <a href="mailto:mdmsupport@comodo.com" title="mdmsupport@comodo.com" target="_blank" style="text-decoration: none;
                                        color: #fff; font: 14px Arial;">mdmsupport@comodo.com</a>
                                </td>
                                <td width="35">
                                </td>
                            </tr>
                        </table>
                </td>
            </tr>
        </table>
    </body>
    </html>	
    ';
    return $ms;
}
function sendEmail($type, $toEmail, $emailSubject, $mailContent, $from = 'MDM <do-not-reply@comodo.com>') {
    $headers = "MIME-Version: 1.0" . "\n";
    $headers .= "Content-type:text/html;charset=utf-8" . "\n";
    $headers .= 'From: ' . $from . "\n";
    $headers .= 'Return-Path: ' . 'do-not-reply@comodo.com' . "\n";
    switch ($type) {
        case 'contact':
            $HTMLmail = contact_message($mailContent);
            break;
        case 'sales':
            $HTMLmail = sales_message($mailContent);
            break;
        case 'resource':
            $HTMLmail = resource_message($mailContent);
            break;
        case 'resourcepdf':
            $HTMLmail = resourcepdf_message($mailContent);
            break;
    }
    $mailResult = mail($toEmail, $emailSubject, $HTMLmail, $headers);
    if ($mailResult) {
        return true;
    } else {
        return false;
    }
}
function str_lreplace($search, $replace, $subject)
{
    $pos = strrpos($subject, $search);
    if($pos !== false)
    {
        $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
}
?>
