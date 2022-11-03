<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php 
$registration_id=	intval($_REQUEST['registration_id']);
$chln_status	=	$conn ->query("select status from challan_master where registration_id='$registration_id' and status=1");
$chln_num		=	$chln_status->num_rows;
if($chln_num==0)
{
	$_SESSION['form_chk_msg']="Please first fill Challan form";
	header('location:challan_form.php?registration_id='.$registration_id);exit;
}
?>
<?php
$action=$_REQUEST['action'];
if($action=="update")
{ 
	//print_r($_POST); exit;
$registration_id = intval($_REQUEST['registration_id']);
if($_REQUEST['information_approve']==""){$information_approve="P";}else{$information_approve=$_REQUEST['information_approve'];}
if($_REQUEST['document_approve']==""){$document_approve="P";}else{$document_approve=$_REQUEST['document_approve'];}
if($_REQUEST['payment_approve']==""){$payment_approve="P";}else{$payment_approve=$_REQUEST['payment_approve'];}
if($_REQUEST['signing_authority']==""){$signing_authority="NA";}else{$signing_authority=$_REQUEST['signing_authority'];}

$dt = date('Y/m/d'); 
$date = str_replace('/', '-', $dt);
$mailerDate = date('d-m-Y', strtotime($date));

$cname	=	getCompanyName($registration_id,$conn); 
$email_id = getUserEmail($registration_id,$conn); 
$number	=	getUserMobile($registration_id,$conn); 
$ho_bp_number = getBPNO($registration_id,$conn);  
$eligible_for_renewal	= eligible_for_renewal($registration_id,$conn); 

if($information_approve=="N" || $document_approve=="N" || $payment_approve=="N"){
$disapprove_reason=addslashes($_REQUEST['disapprove_reason']);	}
else {
	$disapprove_reason="";
}

$rcmc_certificate_approve=$_REQUEST['rcmc_certificate_approve'];

if($rcmc_certificate_approve=="N"){$rcmc_certificate_disapprove_reason=addslashes($_REQUEST['rcmc_certificate_disapprove_reason']);}
else{$rcmc_certificate_disapprove_reason="";}

if($rcmc_certificate_approve=="Y")
{
	$message="Dear Sir, Your application for RCMC with GJEPC has been approved pls. check your mail for more information";
//	get_data($message,$number);
	$rcmc_certificate_issue_date=date("Y-m-d");
	$rcmc_certificate_expire_date=date('Y-m-d', strtotime('+5 years'));
		
		$region = getRegion($registration_id,$conn);
		if($region=='HO-MUM (M)'){$to_admin='mithun@gjepcindia.com,archana@gjepcindia.com,membership@gjepcindia.com';$address=mumAdd();}
		if($region=='RO-CHE'){$to_admin='bhanu.prasad@gjepcindia.com';$address=cheAdd();}
		if($region=='RO-DEL'){$to_admin='madaan@gjepcindia.com';$address=delhiAdd();}
		if($region=='RO-JAI'){$to_admin='slmeena@gjepcindia.com';$address=jaiAdd();}
		if($region=='RO-KOL'){$to_admin='salim@gjepcindia.com';$address=kolAdd();}
		if($region=='RO-SRT'){$to_admin='Rachna.Shah@gjepcindia.com';$address=suratAdd();}
	
$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left"><img src="https://www.gjepc.org/assets/images/logo.png" width="238" height="78" /></td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear '.$cname.',</td>
  </tr>
    <tr>
    <td><br/></td>
    </tr>
  <tr>
    <td align="left" style="text-align:justify;"> Your application for Registration Cum Membership Certificate dated has been approved by the GJEPC admin.</td>
  </tr>
   <tr>
    <td>&nbsp; </td>
    </tr>
   <tr>
  <td>&nbsp; </td>
  </tr>'.$address.'
  </table>';	
  
	//  $to  = $email_id.",".$to_admin;
 $subject  = "Your application : Registration Cum Membership Certificate has been approved by GJEPC admin"; 
 $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';				
 mail($to, $subject, $message, $headers);

} else {
	$rcmc_certificate_issue_date="";
	$rcmc_certificate_expire_date="";
}

$rcmc_amendment_modification=$_REQUEST['rcmc_amendment_modification'];
if($rcmc_amendment_modification=="Y"){$rcmc_amendment_modification_reason=addslashes($_REQUEST['rcmc_amendment_modification_reason']);}
else{$rcmc_amendment_modification_reason=""; }
if($rcmc_amendment_modification==""){ $rcmc_amendment_modification="N";}

if(($information_approve=="N" || $document_approve=="N" || $payment_approve=="N") && $disapprove_reason=="")
{
	$_SESSION['error_msg1']="Please enter dispproval reason."; }
/*else if($rcmc_certificate_approve==""){$_SESSION['error_msg1']="Please enter RCMC Application approval checkbox.";}*/
else if($rcmc_certificate_approve=="N" && $rcmc_certificate_disapprove_reason==""){
$_SESSION['error_msg2']="Please enter dispproval reason.";
}else if($rcmc_amendment_modification=="Y" && $rcmc_amendment_modification_reason==""){
$_SESSION['error_msg3']="Please enter dispproval reason.";
}
else
{
$queryB = $conn ->query("select * from approval_master where registration_id='$registration_id'");
$num   = $queryB->num_rows;
	if($num<=0)
	{ 
	$queryA = $conn ->query("insert into approval_master set registration_id='$registration_id',information_approve='$information_approve',document_approve='$document_approve',payment_approve='$payment_approve',signing_authority='$signing_authority',disapprove_reason='$disapprove_reason',rcmc_certificate_approve='$rcmc_certificate_approve',rcmc_certificate_disapprove_reason='$rcmc_certificate_disapprove_reason',rcmc_amendment_modification='$rcmc_amendment_modification',rcmc_amendment_modification_reason='$rcmc_amendment_modification_reason',rcmc_certificate_issue_date='$rcmc_certificate_issue_date',rcmc_certificate_expire_date='$rcmc_certificate_expire_date',post_date='$dt'");
	if(!$queryA) die ($conn->error);
	}
	else
	{
	$queryA = $conn ->query("update approval_master set information_approve='$information_approve',document_approve='$document_approve',payment_approve='$payment_approve',signing_authority='$signing_authority',disapprove_reason='$disapprove_reason',rcmc_certificate_approve='$rcmc_certificate_approve',rcmc_certificate_disapprove_reason='$rcmc_certificate_disapprove_reason',rcmc_amendment_modification='$rcmc_amendment_modification',rcmc_amendment_modification_reason='$rcmc_amendment_modification_reason',rcmc_certificate_issue_date='$rcmc_certificate_issue_date',rcmc_certificate_expire_date='$rcmc_certificate_expire_date' where registration_id='$registration_id'");
	if(!$queryA) die ($conn->error);
	}
	
    $_SESSION['succ_msg']="Approval has been saved successfully";
	
	/*.............................Approval or disapproval email.........................................*/

if($eligible_for_renewal=='N'){	// For 'NEW' Member's
	
if($information_approve=='Y' || $document_approve=='Y' || $payment_approve=='Y')
{
	$message="Dear Sir, Your Membership application With GJEPC has been approved. Pls Check your mail for more information.";
	//get_data($message,$number);
$region = getRegion($registration_id,$conn);
if($region=='HO-MUM (M)'){	$to_admin='mithun@gjepcindia.com,archana@gjepcindia.com,membership@gjepcindia.com';	$regionMail = 'membership@gjepcindia.com';	$address=mumAdd();}
if($region=='RO-CHE'){		$to_admin='bhanu.prasad@gjepcindia.com';					$regionMail = 'bhanu.prasad@gjepcindia.com';	$address=cheAdd();}
if($region=='RO-DEL'){		$to_admin='madaan@gjepcindia.com';							$regionMail = 'madaan@gjepcindia.com';		$address=delhiAdd();}
if($region=='RO-JAI'){		$to_admin='slmeena@gjepcindia.com';							$regionMail = 'slmeena@gjepcindia.com';			$address=jaiAdd();}
if($region=='RO-KOL'){		$to_admin='salim@gjepcindia.com';							$regionMail = 'salim@gjepcindia.com';			$address=kolAdd();}
if($region=='RO-SRT'){		$to_admin='Rachna.Shah@gjepcindia.com'; 					$regionMail = 'Rachna.Shah@gjepcindia.com';	$address=suratAdd();}
	
$message ='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr><td align="left"><img src="https://www.gjepc.org/assets/images/logo.png"/></td></tr>
    <tr><td  height="30"><hr></td>
    </tr>
	<tr><td align="right"><strong>Date: </strong><span>'.$mailerDate.'</span></td></tr>
	<tr>
    <td>
    <p>To,</p>
    </td>   
    </tr>
    <tr>
    <td><p>'.$cname.'</p> </td>   
    </tr>
	<tr>
        <td><br></td>
    </tr>
    <tr><td><p>Dear Sir/Madam,</p></td></tr>    
    <tr>
    <td><p>Your application for Membership of GJEPC for financial year 2022-23 has been received and is under process.</p>
    <p>Registration under My-KYC Bank for GJEPC Members is mandatory. You are requested to start the registration process through your membership dashboard. Use BP number '.$ho_bp_number.' in place of membership number while proceeding for MYKYC registration. (click here- <a href="https://www.mykycbank.com/registerpage.aspx">Link of MYKYC temp registration</a>) </p>
    </td>
    </tr>   
    <tr>
        <td>
            <p>Once your membership is issued, you will receive confirmation of Membership by e-mail.  </p>
            <p>For query if any related to membership please contact '.$regionMail.'</p>
            <p>With warm regards,</p>
            <p><strong>GJEPC Membership Team,</strong></p>
        </td>
    </tr>
		
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>'.$address.'      
</tbody>
</table>';
 		
 $to =$email_id.",".$to_admin;
 $subject = "Your application : GJEPC Membership has been approved by GJEPC admin"; 
 $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';			
 mail($to, $subject, $message, $headers);
}

if($information_approve=='N' || $document_approve=='N' || $payment_approve=='N')
{
		$message="Dear Sir, Your Membership application With GJEPC has been disapproved. Pls Check your mail for more information.";
	//	get_data($message,$number);
	    $region = getRegion($registration_id,$conn);
		if($region=='HO-MUM (M)'){$to_admin='mithun@gjepcindia.com,archana@gjepcindia.com,membership@gjepcindia.com';$address=mumAdd();}
		if($region=='RO-CHE'){$to_admin='bhanu.prasad@gjepcindia.com';$address=cheAdd();}
		if($region=='RO-DEL'){$to_admin='madaan@gjepcindia.com';$address=delhiAdd();}
		if($region=='RO-JAI'){$to_admin='slmeena@gjepcindia.com';$address=jaiAdd();}
		if($region=='RO-KOL'){$to_admin='salim@gjepcindia.com';$address=kolAdd();}
		if($region=='RO-SRT'){$to_admin='Rachna.Shah@gjepcindia.com';$address=suratAdd();}
	
$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left"><img src="https://www.gjepc.org/assets/images/logo.png" /></td>
        </tr>
      </table></td>
  </tr>
  <br />
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear '.$cname.'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;">Your application for GJEPC Membership  has been disapproved by the GJEPC admin. </td>
  </tr>
   <tr>
    <td><br /> </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;">Reason (GJEPC admin comments) :'.$disapprove_reason.'</td>
  </tr>
   <tr>
  <td><br /> </td>
    </tr>
  <tr>
    <td align="left">If your RCMC certificate is getting expired then the same can be renewed through My GJEPC dashboard</td>
</tr>'.$address.'
</table>
</body>';
		
	  $to  =	$email_id.",".$to_admin;
 $subject  = "Your application : GJEPC Membership has been disapproved by GJEPC Admin"; 
 $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';			
 mail($to, $subject, $message, $headers);
}

} else if($eligible_for_renewal=='Y') { // For 'RENEW' Member's

if(($information_approve=='Y' || $document_approve=='Y' || $payment_approve=='Y') && $rcmc_certificate_approve=="" )
{
	$region = getRegion($registration_id,$conn);
if($region=='HO-MUM (M)'){	$to_admin='mithun@gjepcindia.com,archana@gjepcindia.com,membership@gjepcindia.com';	$regionMail = 'membership@gjepcindia.com';	$address=mumAdd();}
if($region=='RO-CHE'){		$to_admin='bhanu.prasad@gjepcindia.com';					$regionMail = 'bhanu.prasad@gjepcindia.com';	$address=cheAdd();}
if($region=='RO-DEL'){		$to_admin='madaan@gjepcindia.com';							$regionMail = 'madaan@gjepcindia.com';		$address=delhiAdd();}
if($region=='RO-JAI'){		$to_admin='slmeena@gjepcindia.com';							$regionMail = 'slmeena@gjepcindia.com';			$address=jaiAdd();}
if($region=='RO-KOL'){		$to_admin='salim@gjepcindia.com';							$regionMail = 'salim@gjepcindia.com';			$address=kolAdd();}
if($region=='RO-SRT'){		$to_admin='Rachna.Shah@gjepcindia.com'; 					$regionMail = 'Rachna.Shah@gjepcindia.com';	$address=suratAdd();}
	
$message ='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr><td align="left"><img src="https://www.gjepc.org/assets/images/logo.png"/></td></tr>
    <tr><td  height="30"><hr></td>
    </tr>
	<tr><td align="right"><strong>Date: </strong><span>'.$mailerDate.'</span></td></tr>
	<tr>
    <td>
    <p>To,</p>
    </td>   
    </tr>
    <tr>
    <td><p>'.$cname.'</p> </td>   
    </tr>
	<tr><td><br></td></tr>
    <tr><td><p>Dear Sir/Madam,</p></td></tr>    
    <tr>
    <td><p>Your application for Membership renewal for financial year 2022-23 has been received by GJEPC and is under process. </p>
    <p>If you have not completed My-KYC registration, you are requested to complete the same as soon as possible. For query if any with regard to My-KYC you may contact MY KYC team at below details- </p>
    </td>
    </tr>
    <tr>
        <td>
            <p>Email - info@mykycbank.com / support@mykycbank.com </p>
        </td>
    </tr>
    <tr>
        <td>
            <table border="1px" width="100%" color="#000" cellpadding="5px" cellspacing="0px">
                <tbody>
                    <tr>
                        <!--<td>Rahul</td>
                        <td>9082342792</td>-->
						<td>Sheetal / Archana</td>
                        <td>022-42263667/8</td>
                    </tr>
                    <!--<tr>
                        <td>Rakesh</td>
                        <td>9653466426</td>
						<td>Ruchita</td>
                        <td>9870084266</td>
                    </tr>-->
                </tbody>
            </table>
        </td>
    </tr> 
	<tr>
        <td>
            <p>With regard to your membership renewal application you will receive confirmation shortly.  </p>
            <p>For query related to membership please contact '.$regionMail.'</p>
            <p>With regards,</p>
            <p><strong>GJEPC Membership Team,</strong></p>
        </td>
    </tr>
		
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>'.$address.'      
</tbody>
</table>';
 		
 $to =$email_id.",".$to_admin;
 $subject = "Your application : GJEPC Membership has been Approved by GJEPC Admin"; 
 $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';				
 mail($to, $subject, $message, $headers);
}

if($information_approve=='N' || $document_approve=='N' || $payment_approve=='N')
{
		$message="Dear Sir, Your Membership application With GJEPC has been disapproved. Pls Check your mail for more information.";
	//	get_data($message,$number);
	    $region = getRegion($registration_id,$conn);
		if($region=='HO-MUM (M)'){$to_admin='mithun@gjepcindia.com,archana@gjepcindia.com,membership@gjepcindia.com';$address=mumAdd();}
		if($region=='RO-CHE'){$to_admin='bhanu.prasad@gjepcindia.com';$address=cheAdd();}
		if($region=='RO-DEL'){$to_admin='madaan@gjepcindia.com';$address=delhiAdd();}
		if($region=='RO-JAI'){$to_admin='slmeena@gjepcindia.com';$address=jaiAdd();}
		if($region=='RO-KOL'){$to_admin='salim@gjepcindia.com';$address=kolAdd();}
		if($region=='RO-SRT'){$to_admin='Rachna.Shah@gjepcindia.com';$address=suratAdd();}
	
$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left"><img src="https://www.gjepc.org/assets/images/logo.png" width="238" height="78" /></td>
        </tr>
      </table></td>
  </tr>
  <br />
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear '.$cname.'</td>
  </tr>
  <tr>
    <td align="left" style="text-align:justify;">Your application for GJEPC Membership  has been disapproved by the GJEPC admin. </td>
  </tr>
   <tr>
    <td><br /> </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;">Reason (GJEPC admin comments) :'.$disapprove_reason.'</td>
  </tr>
   <tr>
  <td><br /> </td>
    </tr>
  <tr>
    <td align="left">If your RCMC certificate is getting expired then the same can be renewed through My GJEPC dashboard</td>
</tr>'.$address.'
</table>
</body>';	
		
	  $to  =	$email_id.",".$to_admin;
 $subject  = "Your application : GJEPC Membership has been disapproved by GJEPC admin"; 
 $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';				
 mail($to, $subject, $message, $headers);
}

}

if($rcmc_certificate_disapprove_reason!="")
{
		$region = getRegion($registration_id,$conn);
		if($region=='HO-MUM (M)'){$to_admin='mithun@gjepcindia.com,archana@gjepcindia.com,membership@gjepcindia.com';$address=mumAdd();}
		if($region=='RO-CHE'){$to_admin='bhanu.prasad@gjepcindia.com';$address=cheAdd();}
		if($region=='RO-DEL'){$to_admin='madaan@gjepcindia.com';$address=delhiAdd();}
		if($region=='RO-JAI'){$to_admin='slmeena@gjepcindia.com';$address=jaiAdd();}
		if($region=='RO-KOL'){$to_admin='salim@gjepcindia.com';$address=kolAdd();}
		if($region=='RO-SRT'){$to_admin='Rachna.Shah@gjepcindia.com';$address=suratAdd();}
	
$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left"><img src="https://www.gjepc.org/assets/images/logo.png" width="238" height="78" /></td>
        </tr>
      </table>    </td>
  </tr>
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear '.$cname.',</td>
  </tr>
    <tr>
    <td><br/></td>
    </tr>
  <tr>
    <td align="left" style="text-align:justify;"> Your application for Registration Cum Membership Certificate dated has been disapproved by the GJEPC admin.</td>
  </tr>
   <tr>
    <td>&nbsp; </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;"> <b>Reason (GJEPC admin comments) :</b> '.$rcmc_certificate_disapprove_reason.' </td>
  </tr>
   <tr>
  <td>&nbsp; </td>
  </tr>'.$address.'
  </table>';	
  
	  $to  = $email_id.",".$to_admin;
 $subject  = "Your application : Registration Cum Membership Certificate has been disapproved by GJEPC admin"; 
 $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';				
 mail($to, $subject, $message, $headers);
}

header('location:dgft_form.php?registration_id='.$registration_id);	
  
}
}

$registration_id = intval($_REQUEST['registration_id']);
$sqlv = $conn ->query("SELECT * FROM `approval_master` WHERE 1 and registration_id=$registration_id");
$rows =  $sqlv->fetch_assoc();

$registration_id=$rows['registration_id'];
$information_approve=$rows['information_approve'];
$document_approve=$rows['document_approve'];
$payment_approve=$rows['payment_approve'];
$disapprove_reason=stripslashes($rows['disapprove_reason']);
$rcmc_certificate_approve=$rows['rcmc_certificate_approve'];
$rcmc_amendment_modification=$rows['rcmc_amendment_modification'];
$rcmc_certificate_disapprove_reason=stripslashes($rows['rcmc_certificate_disapprove_reason']);
$rcmc_amendment_modification_reason=stripslashes($rows['rcmc_amendment_modification_reason']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Approval Form ||GJEPC||</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!--navigation end-->

<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>
<script> 
 function check_disable(){
	// Membership
    if ($('input[name=\'payment_approve\']:checked').val() == "N"  ||
     $('input[name=\'document_approve\']:checked').val() == "N"  ||
     $('input[name=\'information_approve\']:checked').val() == "N"){
        $("#disapprove_reason_text").show();
    }
    else{
        $("#disapprove_reason_text").hide();
    }	
}

function check_rcmcdisable(){
// RCMC certificate
    if ($('input[name=\'rcmc_certificate_approve\']:checked').val() == "N"){
       $("#rcmc_certificate_disapprove_reason_text").show();
    }
    else
	{
        $("#rcmc_certificate_disapprove_reason_text").hide();
    }
}
function check_amendment(){
// RCMC certificate
    if ($('input[name=\'rcmc_amendment_modification\']:checked').val() == "Y"){
       $("#rcmc_amendment_modification_reason_text").show();
    }
    else
	{
        $("#rcmc_amendment_modification_reason_text").hide();
    }
}
var approv = '<?php echo $rcmc_amendment_modification; ?>';
$(document).ready(function(){
 if(approv == 'Y')
 {
 $('#rcmc_amendment_modification_reason_text').show();
 }
});
</script>

</head>

<body>

<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>
<div class="clear">
<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Membership > Approval Form</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Approval Form
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="membership.php">Back to Search Membership</a></div>
    	</div>	
<form action="" method="post">  
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
if($_SESSION['error_msg1']!=""){
echo "<span class='notification n-attention'>".$_SESSION['error_msg1']."</span>";
}
if($_SESSION['error_msg2']!=""){
echo "<span class='notification n-attention'>".$_SESSION['error_msg2']."</span>";
}
if($_SESSION['error_msg3']!=""){
echo "<span class='notification n-attention'>".$_SESSION['error_msg3']."</span>";
}
?>        
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td colspan="12" >Approval</td>
    </tr>
    <tr>
	<td colspan="3"><strong>Information Approval: </strong></td>
	</tr>
      
    <tr>
	<td width="47%"><input type="radio" name="information_approve" id="information_approve" value="Y" onchange="check_disable()" <?php if($information_approve=="Y"){?> checked="checked" <?php }?> /><span class="text6">Approve</span></td>
	  <td width="47%"><input type="radio" name="information_approve" id="information_approve" value="N" onchange="check_disable()"  <?php if($information_approve=="N"){?> checked="checked" <?php }?> /><span class="text6">Disapprove</span></td>	  
    </tr>      
    <tr>
	<td colspan="3"><strong>Document Approval: </strong></td>
	</tr>      
    <tr>
	<td width="47%"><input type="radio" name="document_approve" id="document_approve" value="Y" onchange="check_disable()" <?php if($document_approve=="Y"){?> checked="checked" <?php }?>  /><span class="text6">Approve</span></td>
	<td width="47%"><input type="radio" name="document_approve" id="document_approve" value="N" onchange="check_disable()" <?php if($document_approve=="N"){?> checked="checked" <?php }?>/><span class="text6">Disapprove</span></td>	  
    </tr>
     
    <tr><td colspan="3"><strong>Payment Approval: </strong></td></tr>
    <tr>
	  <td width="47%"><input type="radio" name="payment_approve" id="payment_approve" value="Y" onchange="check_disable()" <?php if($payment_approve=="Y"){?> checked="checked" <?php }?>/><span class="text6">Approve</span></td>
	  <td width="47%"><input type="radio" name="payment_approve" id="payment_approve" value="N" onchange="check_disable()"<?php if($payment_approve=="N"){?> checked="checked" <?php }?>/><span class="text6">Disapprove</span></td>	  
    </tr>

<tr id="disapprove_reason_text" <?php if($_SESSION['error_msg1']==""){?> style="display:none;" <?php } $_SESSION['error_msg1']="";?>>
        <td bgcolor="#FFFFFF" colspan="4" ><textarea name="disapprove_reason" id="disapprove_reason" ><?php echo $disapprove_reason;?></textarea>
        <script type="text/javascript">
			CKEDITOR.replace( 'disapprove_reason',
                {
                    filebrowserBrowseUrl :'js/ckeditor/filemanager/browser/default/browser.html?Connector=/adminmode/js/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserImageBrowseUrl : 'js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=/adminmode/js/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserFlashBrowseUrl :'js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=/adminmode/js/ckeditor/filemanager/connectors/php/connector.php',
					filebrowserUploadUrl  :'/adminmode/js/ckeditor/filemanager/connectors/php/upload.php?Type=File',
					filebrowserImageUploadUrl : '/adminmode/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
					filebrowserFlashUploadUrl : '/adminmode/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash',
					height: 200,
        			width: 800
				});
		</script>    
		</td>
</tr>
     
    <?php
    $rcmc_certificate_apply = $conn ->query("select rcmc_certificate_apply from approval_master where registration_id='$registration_id'");
	$rcmc_certificate_apply_result =  $rcmc_certificate_apply->fetch_assoc();
	if($rcmc_certificate_apply_result['rcmc_certificate_apply']=='Y'){
    ?> 
    <tr><td colspan="3"><strong>RCMC Application Approval: </strong></td></tr>   
    <tr>
	<td width="47%"><input type="radio" name="rcmc_certificate_approve" id="rcmc_certificate_approve" value="Y" onchange="check_rcmcdisable()" <?php if($rcmc_certificate_approve=="Y"){?> checked="checked" <?php }?>/>
	    <span class="text6">Approve</span>
    </td>
	<td width="47%"><input type="radio" name="rcmc_certificate_approve" id="rcmc_certificate_approve" value="N" onchange="check_rcmcdisable()"<?php if($rcmc_certificate_approve=="N"){?> checked="checked" <?php }?>/><span class="text6">Disapprove</span></td>	  
    </tr>
     
    <tr id="rcmc_certificate_disapprove_reason_text" <?php if($_SESSION['error_msg3']==""){?>style="display:none;" <?php }$_SESSION['error_msg3']="";?>>
        <td bgcolor="#FFFFFF" colspan="3" ><textarea name="rcmc_certificate_disapprove_reason" id="rcmc_certificate_disapprove_reason" ><?php echo $rcmc_certificate_disapprove_reason;?></textarea>
        <script type="text/javascript">
			CKEDITOR.replace( 'rcmc_certificate_disapprove_reason',
                {
                    filebrowserBrowseUrl :'js/ckeditor/filemanager/browser/default/browser.html?Connector=/adminmode/js/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserImageBrowseUrl : 'js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=/adminmode/js/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserFlashBrowseUrl :'js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=/adminmode/js/ckeditor/filemanager/connectors/php/connector.php',
					filebrowserUploadUrl  :'/adminmode/js/ckeditor/filemanager/connectors/php/upload.php?Type=File',
					filebrowserImageUploadUrl : '/adminmode/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
					filebrowserFlashUploadUrl : '/adminmode/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash',
					height: 200,
        			width: 800
				});
		</script>          
		</td>
        </tr>
     <?php } ?>
     
    <tr>
    	<td colspan="3"><strong>Amendment and modificaiton : </strong></td>
    </tr>

	<tr>
	<td width="47%"><input type="radio" name="rcmc_amendment_modification" id="rcmc_amendment_modification" value="N" onchange="check_amendment()" <?php if($rcmc_amendment_modification=="N"){?> checked="checked" <?php }?>/>
	<span class="text6">No</span>
    </td>
	<td width="47%"><input type="radio" name="rcmc_amendment_modification" id="rcmc_amendment_modification" value="Y" onchange="check_amendment()"<?php if($rcmc_amendment_modification=="Y"){?> checked="checked" <?php }?>/><span class="text6">Yes</span></td>	  
    </tr>
    <tr id="rcmc_amendment_modification_reason_text" <?php if($_SESSION['error_msg3']==""){?>style="display:none;" <?php }$_SESSION['error_msg3']="";?>>
    <td bgcolor="#FFFFFF" colspan="3" >
    <textarea name="rcmc_amendment_modification_reason" id="rcmc_amendment_modification_reason" rows="5" cols="75"><?php echo $rcmc_amendment_modification_reason;?></textarea>
    </td>
    </tr>
	
      <!--<tr>
	  	<td colspan="3"><strong>Applied for RCMC on . </strong><br />
      		<a href="#"><div class="text6">Switch to rich text editor</div></a>      	</td>
	  </tr>-->
      <?php if($_SESSION['curruser_region_id']=="RO-DEL"){?>
      <tr>
    	<td colspan="1"><strong>Signing Authority : </strong></td>
        <td colspan="2"> 
        <select name="signing_authority" id="signing_authority">
        <option value="">--Select Signing Authority--</option>
        <!--<option value="PS" selected>PREETI SHARMA</option>-->
        <option value="SK" selected>SURUCHI KHINDRIA</option>
        </select></td>
     </tr>
     <?php }?>
	  </table>
      </div>
	<div style="padding-left:10px; margin-top:5px;">
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="registration_id" id="registration_id" value="<?php echo $_REQUEST['registration_id'];?>" />
        <input type="submit" value="Submit" class="input_submit" />
        <a href="challan_form.php?registration_id=<?php echo $_REQUEST['registration_id'];?>">
        <div class="button">Previous</div></a>
        <a href="dgft_form.php?registration_id=<?php echo $_REQUEST['registration_id'];?>"><div class="button">Next</div></a>
        
    </div>
   </form>
  </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>