<?php
session_start();
include('../db.inc.php');
include('../functions.php');

if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['category_type']="";
  $_SESSION['keyword']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  $_SESSION['firm_type']="";
  $_SESSION['member_type']="";
  $_SESSION['status']="";
  
  header("Location: membership.php");
}else
{ 
    $search_type=$_REQUEST['search_type'];
    if($search_type=="SEARCH")
    { 
      $_SESSION['category_type']=$_REQUEST['category_type'];
      $_SESSION['keyword']= trim($_REQUEST['keyword']);
      $_SESSION['from_date']=$_REQUEST['from_date'];
      $_SESSION['to_date']=$_REQUEST['to_date'];
      $_SESSION['firm_type']=$_REQUEST['firm_type'];
      $_SESSION['member_type']=$_REQUEST['member_type'];
      $_SESSION['status']=$_REQUEST['status'];
}
if($search_type=='SEARCH')
{
if($_SESSION['category_type']=="" && $_SESSION['keyword']=="" && $_SESSION['from_date']=="Form" && $_SESSION['to_date']=="To" && $_SESSION['firm_type']=="" && $_SESSION['member_type']=="" && $_SESSION['status']=="")
{
$_SESSION['error_msg']="Please select atleast one field to search";
}else if($_SESSION['category_type']=="" && $_SESSION['keyword']!="")
{
$_SESSION['error_msg']="Please select category for the keyword entered below";
}else if($_SESSION['category_type']!="" && $_SESSION['keyword']=="")
{
$_SESSION['error_msg']="Please enter keyword for above category";
}else if($_SESSION['from_date']=="Form" && $_SESSION['to_date'] !="To")
{
$_SESSION['error_msg']="Please enter form date";
}else if($_SESSION['from_date']!="Form" && $_SESSION['to_date']=="To")
{
$_SESSION['error_msg']="Please enter to date";
}
}
}
?>
<?php /*
if(($_REQUEST['id']!='') || ($_REQUEST['action']=='bpcreation'))
{
        $id = $_REQUEST['id'];
        $sql="update approval_master SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`sap_status`='1' where registration_id='$id'";
        $resultx = mysql_query($sql);
        echo"<meta http-equiv=refresh content=\"0;url=membership.php?action=view\">";   
} */
?>  
<?php 
if(($_REQUEST['action']=='allow') && ($_REQUEST['id']!=''))
{   
    $id = intval(filter($_REQUEST['id']));
    $year=date("Y");
    $result2= $conn ->query("update challan_master set Response_Code='' where registration_id='$id' and challan_financial_year='$year'");
    $result3 = $conn ->query("update approval_master set apply_membership_renewal='N' where registration_id='$id'");    
    echo "<meta http-equiv=refresh content=\"0;url=membership.php?action=view\">";
}
?>
<?php
$action_update=$_REQUEST['action_update'];
if($action_update=="UPDATE_STATUS")
{
$issue_mem_cer=$_REQUEST['issue_mem_cer'];
foreach($issue_mem_cer as $val)
{
//$rcmc_certificate_issue_date=date('Y-m-d');
//$rcmc_certificate_expire_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($rcmc_certificate_issue_date)) . " +5 year"));
$number = getUserMobile($val,$conn);
//echo $eligible_for_renewal    = eligible_for_renewal($val,$conn); exit;

/* $message="Dear Sir, Your membership application with GJEPC has been approved pls. check your mail for more information.";
get_data($message,$number); */
$admin_issue_date = date('Y-m-d'); 
$update_membership = "update approval_master set issue_membership_certificate_expire_status='Y',adminId='$adminID' where registration_id='$val'";
$update_result_membership = $conn ->query($update_membership);

$update_membership1 = "update approval_master set admin_issue_membership_certificate='Y',admin_issue_certificate='$adminID',admin_issue_date='$admin_issue_date' where registration_id='$val'";
$update_result_membership1 = $conn ->query($update_membership1);


/*....................................Certificate History maintain for 5 year..............................................*/
$select_member_detail="select registration_id,rcmc_certificate_issue_date,rcmc_certificate_expire_date,merchant_certificate_no,manufacturer_certificate_no,membership_type,membership_id,membership_issued_dt,membership_issued_certificate_dt,membership_renewal_dt,membership_expiry_dt,membership_certificate_type,invoice_no,invoice_date,receipt_no,receipt_date from gjepclivedatabase.approval_master where registration_id='$val'";
$query_member_detail=$conn ->query($select_member_detail);
$result_member_detail=$query_member_detail->fetch_assoc();

 
 //current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
     $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
     $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    else {
     $cur_fin_yr = $cur_year;
     $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
     $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }

$next_fin_year = $cur_year+1;    
$membership_expiry_dt = "$next_fin_year-03-31";
$update_renew = "update approval_master set membership_expiry_dt='$membership_expiry_dt',membership_expiry_status='N',apply_membership_renewal='N' where registration_id='$val'";
$update_result_renew = $conn ->query($update_renew);
    
/*.......................................Check if already exist in history table....................................................*/
$q_member_history_avail=$conn->query("select * from membership_certificate_history where registration_id='$val' and financial_year='$cur_finyr'");  
$n_member_avail=$q_member_history_avail->num_rows;
$post_date=Date('Y-m-d');
if($n_member_avail>0){
    $conn ->query("update membership_certificate_history set
                    rcmc_certificate_issue_date='".$result_member_detail['rcmc_certificate_issue_date']."',
                    rcmc_certificate_expire_date='".$result_member_detail['rcmc_certificate_expire_date']."',
                    merchant_certificate_no='".$result_member_detail['merchant_certificate_no']."',
                    manufacturer_certificate_no='".$result_member_detail['manufacturer_certificate_no']."',
                    membership_type='".$result_member_detail['membership_type']."',
                    membership_id='".$result_member_detail['membership_id']."',
                    membership_issued_dt='".$result_member_detail['membership_issued_dt']."',
                    membership_issued_certificate_dt='".$result_member_detail['membership_issued_certificate_dt']."',
                    membership_renewal_dt='".$result_member_detail['membership_renewal_dt']."',
                    membership_expiry_dt='".$result_member_detail['membership_expiry_dt']."',
                    membership_certificate_type='".$result_member_detail['membership_certificate_type']."',
                    invoice_no='".$result_member_detail['invoice_no']."',
                    invoice_date='".$result_member_detail['invoice_date']."',
                    receipt_no='".$result_member_detail['receipt_no']."',
                    receipt_date='".$result_member_detail['receipt_date']."',modified_date='$post_date' where registration_id='$val' and financial_year='$cur_finyr'");
    
}else{
$conn ->query("insert into membership_certificate_history set registration_id='$val',financial_year='$cur_finyr',
                    rcmc_certificate_issue_date='".$result_member_detail['rcmc_certificate_issue_date']."',
                    rcmc_certificate_expire_date='".$result_member_detail['rcmc_certificate_expire_date']."',
                    merchant_certificate_no='".$result_member_detail['merchant_certificate_no']."',
                    manufacturer_certificate_no='".$result_member_detail['manufacturer_certificate_no']."',
                    membership_type='".$result_member_detail['membership_type']."',
                    membership_id='".$result_member_detail['membership_id']."',
                    membership_issued_dt='".$result_member_detail['membership_issued_dt']."',
                    membership_issued_certificate_dt='".$result_member_detail['membership_issued_certificate_dt']."',
                    membership_renewal_dt='".$result_member_detail['membership_renewal_dt']."',
                    membership_expiry_dt='".$result_member_detail['membership_expiry_dt']."',
                    membership_certificate_type='".$result_member_detail['membership_certificate_type']."',
                    invoice_no='".$result_member_detail['invoice_no']."',
                    invoice_date='".$result_member_detail['invoice_date']."',
                    receipt_no='".$result_member_detail['receipt_no']."',
                    receipt_date='".$result_member_detail['receipt_date']."',post_date='$post_date'");
    }
    
$region = getRegion($val,$conn);
$cname  = getCompanyName($val,$conn);
$email_id  = getUserEmail($val,$conn);
$bp_number = getBPNO($val,$conn);
$eligible_for_renewal   = eligible_for_renewal($val,$conn);

$dt = date('Y/m/d'); 
$date = str_replace('/', '-', $dt);
$mailerDate = date('d-m-Y', strtotime($date));

if($region=='HO-MUM (M)'){$to_admin='membership@gjepcindia.com,archana@gjepcindia.com,mithun@gjepcindia.com,sheetal.kesarkar@gjepcindia.com';$address=mumAdd();}
if($region=='RO-CHE'){$to_admin='bhanu.prasad@gjepcindia.com';$address=cheAdd();}
if($region=='RO-DEL'){$to_admin='madaan@gjepcindia.com';$address=delhiAdd();}
if($region=='RO-JAI'){$to_admin='slmeena@gjepcindia.com';$address=jaiAdd();}
if($region=='RO-KOL'){$to_admin='salim@gjepcindia.com';$address=kolAdd();}
if($region=='RO-SRT'){$to_admin='rachna.shah@gjepcindia.com';$address=suratAdd();}

/*.............................Approval or disapproval email.........................................*/

if($eligible_for_renewal=='N'){ // For 'NEW' Member's

$message ='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
    <tr><td align="left"><img src="https://gjepc.org/assets/images/logo.png"/></td></tr>
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
        <td><p>The Gem & Jewellery Export Promotion Council is glad to inform you that your membership has been enrolled as an Associate Member of the Council for the year 2022-23.</p>
        <p>You may take printout of your Membership Certificate / RCMC from your membership dashboard by using your login details (MY GJEPC Dashboard - Print Acknowledgment - Print Membership Certificate / Print Registration cum Membership Certificate (RCMC)</p>
        </td>
    </tr>
    <tr>
        <td><p>Registration under My-KYC Bank for GJEPC Members is mandatory. You are requested to complete My-KYC registration process as early as possible. </p></td>
    </tr>
    <tr>
        <td><p>For query if any with regard to My-KYC you may contact MY KYC team by e-mail at info@mykycbank.com / support@mykycbank.com or by phone at below numbers-</p></td>
    </tr>
    <tr>
        <td>
            <table border="1px" width="100%" color="#000" cellpadding="5px" cellspacing="0px">
                <tbody>
                    <tr>
                        <td>Sheetal / Archana</td>
                        <td>022-42263667/8</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr> 
    <tr>
        <td>
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
 $subject = "Issuance of New Membership"; 
/* $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';         
 mail($to, $subject, $message, $headers); */
 
 $cc = "";
 $email_array = explode(",",$to);
 send_mailArray($email_array,$subject,$message,$cc);
 
    /* First optin API After that Msg API */    
    //$mobile = $number.',9619662253';
    $mobile = $number;
    $apiurl = sendOPTIN($mobile);
    //print_r($apiurl);
    $getResult = json_decode($apiurl,true);
    if($getResult['response']['status']=="success")
    {
        foreach($getResult['data'] as $value)
        {
            $code = $value[0]['id'];
            $msg  = $value[0]['details'];
            $phone = $value[0]['phone'];
            
            $msgurl = sendNewMembership($mobile);
            $getResults = json_decode($msgurl,true);
            if($getResults['response']['status']=="success")
            {
                //echo $getResults['response']['status'];
            } else { 
                //echo $getResults['response']['details'];
            }       
        }
    } else { 
        echo "Failed ! Message Not Sent";
    }
 
}  else if($eligible_for_renewal=='Y') { // For 'RENEW' Member's

    if(!empty($bp_number)) {
$apiurl="http://api.mykycbank.com/service.svc/44402aeb2e5c4eef8a7100f048b97d84/BPID/".$bp_number;
$getResponse = file_get_contents($apiurl);
$getResult = json_decode($getResponse,true);
$apiResponse = json_decode($getResult,true);
$KycProfileId = $apiResponse['KycProfileId'];
$kycStatus = $apiResponse['status'];
$kycMessage = $apiResponse['Message'];

if($kycStatus ==3) // Permanent
{
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
        <td><p>This is to confirm that your membership for the financial year 2022-23 has been renewed.</p>
        <p>You may take printout of your membership certificate from your membership dashboard by using your login details (MY GJEPC Dashboard - Print Acknowledgment - Print Membership Certificate)</p>
        </td>
    </tr>
    <tr>
        <td>
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
 $subject = "Confirmation of renewal process completion for Permanent KYC ID"; 
/* $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';         
 mail($to, $subject, $message, $headers); */
 $cc = "";
 $email_array = explode(",",$to);
 send_mailArray($email_array,$subject,$message,$cc);
 
} else if($kycStatus ==1) // Temp
{

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
        <td><p>This is to confirm that your membership for the financial year 2022-23 has been renewed provisionally.</p>
        <p>You may take printout of your membership certificate from your membership dashboard by using your login details (MY GJEPC Dashboard - Print Acknowledgment - Print Membership Certificate)</p>
        </td>
    </tr>
    <tr>
        <td><p>Further, you are requested to complete My-KYC registration as soon as possible. For query if any with regard to My-KYC you may contact MY KYC team by e-mail at info@mykycbank.com / support@mykycbank.com or by phone at below numbers- </p></td>
    </tr>
    <tr>
        <td>
            <table border="1px" width="100%" color="#000" cellpadding="5px" cellspacing="0px">
                <tbody>
                    <tr>
                        <td>Sheetal / Archana </td>
                        <td>022-42263667/8</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr> 
    <tr>
        <td>
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
 $subject = "Confirmation of renewal process completion for Permanent KYC ID"; 
/* $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';         
 mail($to, $subject, $message, $headers); */
 $cc = "";
 $email_array = explode(",",$to);
 send_mailArray($email_array,$subject,$message,$cc);

    /* First optin API After that Msg API */
    $mobile = $number;
    $apiurl = sendOPTIN($mobile);
    //print_r($apiurl);
    $getResult = json_decode($apiurl,true);
    if($getResult['response']['status']=="success")
    {
        foreach($getResult['data'] as $value)
        {
            $code = $value[0]['id'];
            $msg  = $value[0]['details'];
            $phone = $value[0]['phone'];
            
            $msgurl = sendRenewalMembership($mobile);
            $getResults = json_decode($msgurl,true);
            if($getResults['response']['status']=="success")
            {
                echo $getResults['response']['status'];
            } else { 
                echo $getResults['response']['details'];
            }       
        }
    } else { 
        echo $getResult['response']['details'];
    }
}

}
}
}
/* End New & renew Application Mail End */

$issue_rcmc_cer=$_REQUEST['issue_rcmc_cer'];
foreach($issue_rcmc_cer as $val)
{
    $adminName = getAdminName($adminID,$conn);
    $cname     = getCompanyName($val,$conn);
    $region = getRegion($val,$conn);
if($region=='HO-MUM (M)'){ $to_admin='mithlesh@gjepcindia.com'; }
if($region=='RO-CHE'){ $to_admin='bhanu.prasad@gjepcindia.com'; }
if($region=='RO-DEL'){ $to_admin='madaan@gjepcindia.com'; }
if($region=='RO-JAI'){ $to_admin='slmeena@gjepcindia.com';}
if($region=='RO-KOL'){ $to_admin='salim@gjepcindia.com';}
if($region=='RO-SRT'){ $to_admin='rachna.shah@gjepcindia.com';}

//$rcmc_certificate_issue_date=date('Y-m-d');
//$rcmc_certificate_expire_date=date('Y-m-d',strtotime(date("Y-m-d", strtotime($rcmc_certificate_issue_date)) . " +5 year"));
$number = getUserMobile($val,$conn);
$message="Dear Sir, Your application for RCMC with GJEPC has been approved & the RCMC will be couriered to you.";

$update_rcmc="update approval_master set rcmc_certificate_approve='Y',rcmc_certificate_issue_status='Y',rcmc_certificate_apply='N',admin_issue_rcmc_certificate='$adminID' where registration_id='$val'";
$update_result_rcmc = $conn ->query($update_rcmc);
if($update_result_rcmc){
$messages ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse; ">
<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://gjepc.org/assets/images/logo.png"> </td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td><h4 style="margin:0;">Application for RCMC has been issued</h4></td></tr>
  <tr style="background-color:#eeee;padding:30px; padding-bottom:0; padding-top:0;"><td style="padding-bottom:0; padding-top:0;"><strong>Company Name :</strong>'.$cname.'</td></tr>
  <tr style="background-color:#eeee;padding:30px; padding-bottom:0; padding-top:0;"><td style="padding-bottom:0; padding-top:0;"><strong>Issue By :</strong>'. $adminName.'</td></tr>
   <tr><td>       
      <p>Kind Regards,<br>
      <b>GJEPC Team,</b>
      </p>
    </td>
  </tr>
</table>';
 $to = $to_admin;
 $cc ="";
 $subject = "Application for GJEPC RCMC has been issue by GJEPC Admin"; 
/* $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From: GJEPC INDIA <admin@gjepc.org>';             
 mail($to, $subject, $message, $headers); */
 send_mail($to,$subject,$messages,$cc);
}
}


$renew_application=$_REQUEST['renew_application'];
foreach($renew_application as $val1)
{
$membership_renewal_dt=date('Y-m-d');

    // current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
     $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
     $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    else {
     $cur_fin_yr = $cur_year;
     $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
     $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
$next_fin_year=$cur_year+1;    
$membership_expiry_dt="$next_fin_year-03-31";

$number = getUserMobile($val1,$conn);
$message="Dear Sir, Your membership application with GJEPC has been approved pls. check your mail for more information.";

$update_renew="update approval_master set membership_renewal_dt='$membership_renewal_dt',membership_expiry_dt='$membership_expiry_dt',membership_expiry_status='N',apply_membership_renewal='N',information_approve='Y',document_approve='Y',payment_approve='Y'  where registration_id='$val1'";
$update_result_renew = $conn ->query($update_renew);

$region = getRegion($val1,$conn);
$cname  = getCompanyName($val1,$conn);
$email_id = getUserEmail($val1,$conn);

if($region=='HO-MUM (M)'){$to_admin='membership@gjepcindia.com,archana@gjepcindia.com,mithun@gjepcindia.com,sheetal.kesarkar@gjepcindia.com';$address=mumAdd();}
if($region=='RO-CHE'){$to_admin='bhanu.prasad@gjepcindia.com';$address=cheAdd();}
if($region=='RO-DEL'){$to_admin='madaan@gjepcindia.com';$address=delhiAdd();}
if($region=='RO-JAI'){$to_admin='slmeena@gjepcindia.com';$address=jaiAdd();}
if($region=='RO-KOL'){$to_admin='salim@gjepcindia.com';$address=kolAdd();}
if($region=='RO-SRT'){$to_admin='rachna.shah@gjepcindia.com';$address=suratAdd();}

$message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left"><img src="https://gjepc.org/assets/images/logo.png" width="238" height="78"/></td>
        </tr>
      </table></td>
  </tr>
  <br />
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">To,<br/>'.$cname.'</td>
  </tr>
  <tr>
    <td><br /> </td>
    </tr>
  <tr>
    <td align="left" style="text-align:justify;">
    Your application for renewal of membership with GJEPC has been received by the GJEPC Membership Dept.</td>
  </tr>
   <tr>
    <td><br /> </td>
    </tr>
  <tr>
    <td align="left" style="text-align:justify;"><p><a href="https://www.gjepc.org/user/login">Click here</a> to login and check your application status.</p>
      <p>If your RCMC certificate is getting expired on 31-03-2020 then the same can be renewed through My GJEPC dashboard</p></td>
  </tr>
   <tr>
        <td><br/> </td>
   </tr>
   <tr>
    <td>With warm regards,</td>
   </tr>'.$address.'
</table>';  
        
 //$to =$email_id.",".$to_admin;
 $subject = "Your application for renewal of Membership with GJEPC has been received by the GJEPC Membership Dept"; 
 $headers  = 'MIME-Version: 1.0' . "\n"; 
 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
 $headers .= 'From:admin@gjepc.org';            
 mail($to, $subject, $message, $headers);
 
 
}

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Membership Form ||GJEPC||</title>
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

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">

    $('#popupDatepicker').datepick();
    $('#inlineDatepicker').datepick({onSelect: showDate});
    $('#popupDatepicker1').datepick();
    $('#inlineDatepicker1').datepick({onSelect: showDate});

function showDate(date) {
    alert('The date chosen is ' + date);
}
</script>
<!--navigation end-->
<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
<!-- <script type="text/javascript" src="js/jquery.easing.1.3.js"></script> -->
<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
<script type="text/javascript">
    $("div.fancyDemo a").fancybox();
</script>
<!-- lightbox Thum -->

</head>
<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
    <div class="nav"><?php include("include/menu.php");?></div>
</div>
<div class="clear"></div>
<div class="breadcome_wrap">
    <div class="breadcome"><a href="admin.php">Home</a> > Membership</div>
</div>

<div id="main">
    <div class="content">
    
        <!--<div class="content_head"><a href="webtoerp_export.php" target="_blank"><div class="content_head_button">Export New Member Web To ERP</div></a> <a href="renewalwebtoerp_export.php" target="_blank"><div class="content_head_button">Export Renewal Web To ERP</div></a> <a href="import_export.php" target="_blank"><div class="content_head_button">Import Export Membership data</div></a><a href="erptoweb_import.php" target="_blank"><div class="content_head_button">Import ERP To Web</div></a><a href="download_status.php" target="_blank"><div class="content_head_button">Activate Download Status</div></a>
        </div>-->
        
<div class="clear"></div>
<div class="content_details1">
<div class="content_head">
 <div style="float:right; padding-right:10px; font-size:12px;"><a href="member_esanchit_registration.php">E-Sanchit Registered List</a>&nbsp; &nbsp; &nbsp; | 
 <a href="member_payment_export_data.php">&nbsp; &nbsp;Export Payment List</a>
 &nbsp; &nbsp; &nbsp; | 
 <a href="get_membership_log.php">&nbsp; &nbsp;Approval log</a>
 </div>
</div>

<form name="search" action="" method="post"/> 

<input type="hidden" name="search_type" id="search_type" value="SEARCH" />          
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
      
<tr>
    <td width="19%"><strong>Select Category</strong></td>
    <td width="81%">
        <select name="category_type" id="category_type" class="input_txt">
        <option value="">Please Select Category</option>    
        <option value="company_name" <?php if($_SESSION['category_type']=="company_name"){echo "selected='selected'";}?>>Company Name</option>
        <option value="iec_no" <?php if($_SESSION['category_type']=="iec_no"){echo "selected='selected'";}?>>IEC Number</option>
        <option value="membership_id" <?php if($_SESSION['category_type']=="membership_id"){echo "selected='selected'";}?>>Membership ID</option>   
        </select>  
    </td>
</tr>

<tr>
    <td><strong>Enter Keywords</strong></td>
    <td><input type="text" name="keyword" id="keyword" class="input_txt" value="<?php echo $_SESSION['keyword'];?>" /></td>
</tr>   
     
<tr>
    <td><strong>Date</strong></td>
    <td><input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "Form";}else{echo $_SESSION['from_date'];}?>" class="input_date"/>
     <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date"/></td>
</tr>

<tr>
    <td><strong>Firm Type</strong></td>
    <td>
    <select name="firm_type" id="firm_type" class="input_txt">
    <option value="">Please Select Firm Type</option>   
    <?php 
    $sql="select * from type_of_firm_master where status='1'";
    $result = $conn ->query($sql);
    while($rows = $result->fetch_assoc())
    {
    if($_SESSION['sap_value']==$rows['type_of_firm_name'])
    {
    echo "<option value='$rows[sap_value]' selected='selected'>$rows[type_of_firm_name]</option>";
    }else
    {
    echo "<option value='$rows[sap_value]'>$rows[type_of_firm_name]</option>";
    }
    }
    ?>    
    </select>
    </td>
</tr>

<tr>
  <td><strong>Member Type</strong></td>
  <td>
    <select name="member_type" class="input_txt">
    <option value="">Please Select Member Type</option> 
    <?php 
    $sql="select * from member_type_master where status=1";
    $result =  $conn ->query($sql);
    while($rows = $result->fetch_assoc())
    {
    if($_SESSION['sap_value']==$rows['member_type_name'])
    {
    echo "<option value='$rows[sap_value]' selected='selected'>$rows[member_type_name]</option>";
    }else
    {
    echo "<option value='$rows[sap_value]'>$rows[member_type_name]</option>";
    }
    }
    ?>
</select>
  </td>
 </tr>

<tr >
  <td><strong>Status</strong></td>
  <td>
  <select name="status" class="input_txt-select" >
  <option value="">Select Status</option>
  <option value="N" <?php if($_SESSION['status']=='N'){echo "selected='selected'";}?>>New application for membership</option>
  <option value="Y" <?php if($_SESSION['status']=='Y'){echo "selected='selected'";}?>>Application for renewal of membership</option>
  <option value="Information_Approved" <?php if($_SESSION['status']=='Information_Approved'){echo "selected='selected'";}?>>Information Approved</option>
  <option value="Information_Disapproved" <?php if($_SESSION['status']=='Information_Disapproved'){echo "selected='selected'";}?>>Information Disapproved</option>
  <option value="Information_Pending" <?php if($_SESSION['status']=='Information_Pending'){echo "selected='selected'";}?>>Information Pending</option>
  <option value="Document_Approved" <?php if($_SESSION['status']=='Document_Approved'){echo "selected='selected'";}?>>Document Approved</option>
  <option value="Document_Disapproved" <?php if($_SESSION['status']=='Document_Disapproved'){echo "selected='selected'";}?>>Document Disapproved</option>
  <option value="Document_Pending" <?php if($_SESSION['status']=='Document_Pending'){echo "selected='selected'";}?>>Document Pending</option>
  <option value="Payment_Approved" <?php if($_SESSION['status']=='Payment_Approved'){echo "selected='selected'";}?>>Payment Approved</option>
  <option value="Payment_Disapproved" <?php if($_SESSION['status']=='Payment_Disapproved'){echo "selected='selected'";}?>>Payment Disapproved</option>
  <option value="Payment_Pending" <?php if($_SESSION['status']=='Payment_Pending'){echo "selected='selected'";}?>>Payment Pending</option>
  <option value="Application_for_rcmc_certificate" <?php if($_SESSION['status']=='Application_for_rcmc_certificate'){echo "selected='selected'";}?>>Application for rcmc certificate</option>
   <option value="Issue_membership_certificate" <?php if($_SESSION['status']=='Issue_membership_certificate'){echo "selected='selected'";}?>> Issue membership certificate</option>
  <option value="Issue_rcmc_certificate" <?php if($_SESSION['status']=='Issue_rcmc_certificate'){echo "selected='selected'";}?>>Issue rcmc certificate</option>
  <option value="GJEPC_Membership_Expired" <?php if($_SESSION['status']=='GJEPC_Membership_Expired'){echo "selected='selected'";}?>>GJEPC Membership Expired</option>
  <option value="RCMC_certificate_expired" <?php if($_SESSION['status']=='RCMC_certificate_expired'){echo "selected='selected'";}?>>RCMC certificate expired</option>
  <option value="Response_Code" <?php if($_SESSION['status']=='Response_Code'){echo "selected='selected'";}?>>Successfull Payments</option>
  <!--<option value="pending" <?php if($_SESSION['status']=='pending'){echo "selected='selected'";}?>>Pending</option>-->
  </select>
  
  </td>
</tr>    
    
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>   

</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="POST">
  <input type="hidden" name="action_update" value="UPDATE_STATUS" />
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="15%" height="30">Name</td>
    <td width="11%">Payment Detail</td>
    <td width="11%">BP No.</td>
    <td width="11%">SO No.</td>
    <td width="18%">Member Type / Certificate No.</td>
    <td width="15%">Membership No.</td>
    <td width="13%">Region</td>
    <td width="8%">Declaration Status</td>
    <td width="8%">Action</td>
    <td width="12%">&nbsp;</td>
    <td width="12%">Create BP</td>
    <td width="12%">Create Sales Order</td>
    <td width="12%">Delta</td>
    <td width="12%">Member</td>
    <?php
    if($_SESSION['status']=='R')
    {
    echo "<td width='15%'>Renewal Applications</td>";
    }
    ?>
    
    <?php
    if($_SESSION['status']=='Issue_rcmc_certificate')
    {
    echo "<td width='15%'>Issue RCMC Certificate</td>";
    }
    ?>

    <?php
    if($_SESSION['status']=='Issue_membership_certificate')
    {
    echo "<td width='15%'>Issue Membership Certificate</td>";
    }
    ?>
    <?php 
    /*if($_SESSION['status']=='pending')
    {
        $financialYear = 2019;
    } else {
        $financialYear = 2020;
    } */
    ?>
  </tr>
    <?php  
    $page=1;//Default page
    $limit=10;//Records per page
    $start=0;//starts displaying records from 0
    if(isset($_GET['page']) && $_GET['page']!=''){
    $page=$_GET['page'];    
    }
    $start=($page-1)*$limit;
    
  $sql="select a.id,b.company_name,b.iec_no,b.region_id,b.member_type_id,c.challan_scanned_copy,c.signature_slip_copy,c.sales_order_no,c.Response_Code,c.Unique_Ref_Number,c.ReferenceNo,c.Transaction_Date,c.total_payable,d.gcode,d.merchant_certificate_no,d.manufacturer_certificate_no,d.membership_id,d.eligible_for_renewal,d.information_approve,d.document_approve,d.payment_approve,d.sap_sale_order_create_status,d.sap_bp_create_status,d.final_submission,d.issue_membership_certificate_expire_status from registration_master a,information_master b,challan_master c,approval_master d where a.id=b.registration_id and a.id=c.registration_id and a.id=d.registration_id and c.challan_financial_year='2022' ";
  
  if($_SESSION['curruser_role']=="Admin")
  {
  $sql.=" and b.region_id='".$_SESSION['curruser_region_id']."' ";
  }
  
  if($_SESSION['category_type']!="" && $_SESSION['keyword']!="")
  {
    if($_SESSION['category_type']=="membership_id")
    {
        $sql.=" and d.".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
    }
    else
    {
        $sql.=" and b.".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
    }
  }
  
  if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
  {
    $sql.=" and a.post_date between '".$_SESSION['from_date']."' and '".$_REQUEST['to_date']."'";
  }
  
  if($_SESSION['firm_type']!="")
  {
  $sql.=" and b.type_of_firm='".$_REQUEST['firm_type']."'";
  }
  
  if($_SESSION['member_type']!="")
  {
  $sql.=" and b.member_type_id='".$_SESSION['member_type']."' ";
  }

  if($_SESSION['status']!="")
  { 
    if($_SESSION['status']=='N')
    {
    $sql.=" and d.eligible_for_renewal='N'";
    }else if($_SESSION['status']=='Y')
    {
    $sql.=" and d.eligible_for_renewal='Y' ";
    }else if($_SESSION['status']=='Information_Approved')
    {
    $sql.=" and d.information_approve='Y' ";
    }else if($_SESSION['status']=='Information_Disapproved')
    {
    $sql.=" and d.information_approve='N' ";
    }else if($_SESSION['status']=='Information_Pending')
    {
    $sql.=" and d.information_approve='P' ";
    }else if($_SESSION['status']=='Document_Approved')
    {
    $sql.=" and d.document_approve='Y' ";
    }else if($_SESSION['status']=='Document_Disapproved')
    {
    $sql.=" and d.document_approve='N' ";
    }else if($_SESSION['status']=='Document_Pending')
    {
    $sql.=" and d.document_approve='P' ";
    }else if($_SESSION['status']=='Payment_Approved')
    {
    $sql.=" and d.payment_approve='Y' ";
    }else if($_SESSION['status']=='Payment_Disapproved')
    {
    $sql.=" and d.payment_approve='N' ";
    }else if($_SESSION['status']=='Payment_Pending')
    {
    $sql.=" and d.payment_approve='P' ";
    }else if($_SESSION['status']=='Application_for_rcmc_certificate')
    {
    $sql.=" and d.rcmc_certificate_apply='Y' ";
    }else if($_SESSION['status']=='Issue_membership_certificate')
    {
    $sql.=" and (d.issue_membership_certificate_expire_status='N' || d.issue_membership_certificate_expire_status='Y')";
    }else if($_SESSION['status']=='Issue_rcmc_certificate')
    {
    $sql.=" and (d.rcmc_certificate_issue_status='N' || d.rcmc_certificate_issue_status='Y') ";
    }else if($_SESSION['status']=='GJEPC_Membership_Expired')
    {
    $sql.=" and d.membership_expiry_status='Y' ";
    }else if($_SESSION['status']=='RCMC_certificate_expired')
    {
    $sql.=" and d.rcmc_certificate_expire_status='Y' ";
    }else if($_SESSION['status']=='Response_Code'){
        $sql.=" and c.Response_Code='E000' ";
    } 
  } 
  
    $sql.=" group by a.id  order by a.id desc limit $start, $limit"; 
    $result = $conn ->query($sql);
    //echo $sql;
    if(!$result) die ($conn->error);
    
    //total no of record 
    $sql1="SELECT COUNT( * ) as count FROM ( select a.id from registration_master a,information_master b,challan_master c,approval_master d where a.id=b.registration_id and a.id=c.registration_id and a.id=d.registration_id and c.challan_financial_year='2022'";
  
    if($_SESSION['curruser_role']=="Admin")
    {
    $sql1.=" and b.region_id='".$_SESSION['curruser_region_id']."' ";
    }
    if($_SESSION['category_type']!="" && $_SESSION['keyword']!="")
    {
        if($_SESSION['category_type']=="membership_id")
        {
            $sql1.=" and d.".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
        }
        else
        {
            $sql1.=" and b.".$_SESSION['category_type']." like '%".$_SESSION['keyword']."%' ";
        }
    }
    
    if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
    {
    $sql1.=" and a.post_date between '".$_SESSION['from_date']."' and '".$_REQUEST['to_date']."'";
    }
    
    if($_SESSION['firm_type']!="")
    {
    $sql1.=" and b.type_of_firm='".$_REQUEST['firm_type']."'";
    }
    
    if($_SESSION['member_type']!="")
    {
    $sql1.=" and b.member_type_id='".$_SESSION['member_type']."' ";
    }
    
    if($_SESSION['status']!="")
    {
        if($_SESSION['status']=='N')
        {
        $sql1.=" and d.eligible_for_renewal='N' ";
        }else if($_SESSION['status']=='Y')
        {
        $sql1.=" and d.eligible_for_renewal='Y' ";
        }else if($_SESSION['status']=='Information_Approved')
        {
        $sql1.=" and d.information_approve='Y' ";
        }else if($_SESSION['status']=='Information_Disapproved')
        {
        $sql1.=" and d.information_approve='N' ";
        }else if($_SESSION['status']=='Information_Pending')
        {
        $sql1.=" and d.information_approve='P' ";
        }else if($_SESSION['status']=='Document_Approved')
        {
        $sql1.=" and d.document_approve='Y' ";
        }else if($_SESSION['status']=='Document_Disapproved')
        {
        $sql1.=" and d.document_approve='N' ";
        }else if($_SESSION['status']=='Document_Pending')
        {
        $sql1.=" and d.document_approve='P' ";
        }else if($_SESSION['status']=='Payment_Approved')
        {
        $sql1.=" and d.payment_approve='Y' ";
        }else if($_SESSION['status']=='Payment_Disapproved')
        {
        $sql1.=" and d.payment_approve='N' ";
        }else if($_SESSION['status']=='Payment_Pending')
        {
        $sql1.=" and d.payment_approve='P' ";
        }else if($_SESSION['status']=='Application_for_rcmc_certificate')
        {
        $sql1.=" and d.rcmc_certificate_apply='Y' ";
        }
        else if($_SESSION['status']=='Issue_rcmc_certificate')
        {
        $sql1.=" and (d.rcmc_certificate_issue_status='N' || d.rcmc_certificate_issue_status='Y') ";
        }else if($_SESSION['status']=='Issue_membership_certificate')
        {
        $sql1.=" and (d.issue_membership_certificate_expire_status='N' || d.issue_membership_certificate_expire_status='Y') ";
        }
        else if($_SESSION['status']=='GJEPC_Membership_Expired')
        {
        $sql1.=" and d.membership_expiry_status='Y' ";
        }else if($_SESSION['status']=='RCMC_certificate_expired')
        {
        $sql1.=" and d.rcmc_certificate_expire_status='Y' ";
        }else if($_SESSION['status']=='Response_Code'){
        $sql1.=" and c.Response_Code='E000' ";
        }
    }   
    
    $sql1.=") as temp"; 
    //echo "<br>".$sql1;
    $result1 = $conn ->query($sql1);
     if(!$result1) die ($conn->error);
    $rows1   = $result1->fetch_assoc();
    $rCount  = $rows1['count'];
    
  if($rCount>0)
  { 
  while($rows = $result->fetch_assoc())
  {// print_r($rows);
    if($rows['total_payable']==1180){ $gmember = "MICRO"; } else { $gmember = "NORMAL"; }
  ?>
  <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
    <td><?php echo strtoupper($rows['company_name']);?></td>
    <td><?php echo $rows['Response_Code']."<br/>".$rows['Unique_Ref_Number']."<br/>".$rows['ReferenceNo'];
    if($rows['Response_Code']=="E000"){ echo "<br/><span style='color:green'>Payment Success</span>"; }?></td>
    <td><?php echo getBPNO($rows['id'],$conn);?></td>
    <td><?php echo $rows['sales_order_no'];?></td>
    <td><?php if($rows['member_type_id']==5){ echo "Merchant"; } else { echo "Manufacturer"; } echo "<br/>";
    if($rows['member_type_id']==5){echo $rows['merchant_certificate_no'];}else{echo $rows['manufacturer_certificate_no'];}?>    </td>
    <td><?php echo $rows['membership_id'];?></td>
    <td><?php echo $rows['region_id']?></td>
    <td><?php echo $rows['final_submission']?></td>
    <td valign="middle">
    <a href="information_form.php?registration_id=<?php echo $rows['id'];?>"><img src="images/edit1.png" border="0" /></a> 
    <hr/> <a href="membership.php?action=allow&id=<?php echo $rows['id']?>" onClick="return(window.confirm('Are you sure you want to allow the party for Repayment?'));">Allow Repayment</a>
    </td>
    <td align="center" valign="bottom" class="linktext">
    <?php if($rows['challan_scanned_copy']!=""){?><div class="fancyDemo">   
    <a rel="group" href="../scan_copy/<?php echo $rows['challan_scanned_copy'];?>">Challan Copy</a></div><?php } ?>
    <?php if($rows['signature_slip_copy']!=""){?><div class="fancyDemo">    
    <a rel="group" href="../signature_slip/<?php echo $rows['signature_slip_copy'];?>">Signature Slip</a></div><?php } ?></td>
    
    <!--.....................BP Create API------------>
    <?php 
    $bpno = getBPNO($rows['id'],$conn);
    if($rows['information_approve']=="Y" && $rows['document_approve']=="Y" && $rows['payment_approve']=="Y"){
    //if($rows['information_approve']=="Y" && $rows['document_approve']=="Y" && $rows['payment_approve']=="Y"){
    if(getBPNO($rows['id'],$conn)=="") { ?>
    <td class="sap" data-url="<?php echo $rows['id'];?> <?php echo $gmember;?>"><img src="images/reply.png" title="Create BP" border="0" style=""/></td>
    <?php } else { ?>
    <td><a onclick="return(window.confirm('BP Already Created'));"><img src="images/active.png"/></a></td>
    <?php } ?>
    <!--.....................Sales Order Creat API------------>
    <?php if($rows['sap_sale_order_create_status'] == 0) { ?>
    <!--<td class="so" data-url="<?php echo $bpno;?> <?php echo $rows['id'];?> <?php if($_SESSION['status']=='Application_for_renewal_of_membership'){ echo "R"; } else { echo "N"; }?>">CREATE SO</td>-->
    <?php 
        $registration_id = $rows['id'];
        $sql_outstanding = "SELECT id FROM registration_master WHERE id='$registration_id' AND payment_defaulter='Y' AND payment_defaulter_reason='outstanding'";
        $result_outstanding  = $conn->query($sql_outstanding);
        $count_outstanding = $result_outstanding->num_rows;        
    ?>


    <?php if(trim($rows['Response_Code'])=='E000' && $rows['Transaction_Date']!="" ) { ?>
    <?php 
      if($count_outstanding > 0){ ?>
           <td> Outstanding is Pending</td>
    <?php } else { ?>
    <td class="so" data-url="<?php echo $bpno;?> <?php echo $rows['id'];?> <?php echo $rows['eligible_for_renewal'];?> <?php echo $gmember;?>">CREATE SO</td>
    <?php  }
    ?>
    
    
    <?php } else { ?>
    <td> Payment Issue</td>
    <?php } ?>
    
    <?php } else { ?>
    <td><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
    <?php }?>
    <?php } else { ?>
    <td>Pending</td>
    <td>Pending</td>
    <?php }?>
    <!-------------------- Delta Start Here ------------------------------------>
    <?php if(getBPNO($rows['id'],$conn)!="") { ?>
    <td class="delta" data-url="<?php echo $rows['id'];?>"><img src="images/reply.png" title="PUSH" border="0" style=""/></td>
    <?php } else { ?><td></td><?php } ?>
    <!-------------------- Delta End Here ------------------------------------>
    <?php
    if($_SESSION['status']=='Y')
    {
    echo "<td align='left'><input name='renew_application[]' type='checkbox' value='$rows[id]' /></td>";
    }
    ?>
    
    <?php
    if($_SESSION['status']=='Issue_rcmc_certificate')
    {
    echo "<td align='left'><input name='issue_rcmc_cer[]' type='checkbox' value='$rows[id]' /> /<a href='../rcmc/print_certificate.php?registration_id=$rows[id]' target='_blank'> View Certificate</a><a target='_blank' href='rcmc-update.php?registration_id=$rows[id]'> <b>Update RCMC</b></a></td>";
    }
    ?>
    
    <?php
    if($_SESSION['status']=='Issue_membership_certificate')
    {
    echo "<td align='left'><input name='issue_mem_cer[]' type='checkbox' value='$rows[id]'  /> /<a href='../rcmc/membership.php?registration_id=$rows[id]' target='_blank'> View Certificate<checked /a></td>";
    }
    ?>  
    <td><?php echo $gmember; ?></td>
    <?php /*
    if($_SESSION['status']=='pending'){ ?>
    <td class="delta" data-url="<?php echo $rows['id'];?>">De-Register<img src="images/reply.png" title="PUSH" border="0" style=""/></td>
    <?php } */?>
    </tr>
  
  <?php
   $i++;
   }
   ?>
   
        <?php
        if($_SESSION['status']=='Application_for_renewal_of_membership')
        {
        ?>
        <tr>
        <td colspan="6">&nbsp;</td>
        <td colspan="2"><input type="submit" name="Renew Application" value="Renew Application"  class="input_submit" /></td>
        </tr>
        <?php
        }
        ?>
        
        <?php
        if($_SESSION['status']=='Issue_rcmc_certificate')
        {
        ?>
        <tr>
        <td colspan="6">&nbsp;</td>
        <td colspan="2"><input type="submit" name="Issue RCMC Certificate" value="Issue RCMC Certificate"  class="input_submit" /></td>
        </tr>
        <?php
        }
        ?>
    
        <?php
        if($_SESSION['status']=='Issue_membership_certificate')
        {
        ?>
        <tr>
        <td colspan="6">&nbsp;</td>
        <td colspan="2"><input type="submit" name="Issue membership Certificate" value="Issue membership Certificate"  class="input_submit" /></td>
        </tr>
        <?php
        }
        ?>
   
   <?php 
    }
   else
   {
   ?>
   <tr>
     <td colspan="8">Records Not Found</td>
   </tr>
   <tr>
     <td colspan="5">&nbsp;</td>
     <td colspan="3"></td>
   </tr>
   <?php  }  ?>  
</table>

</form>
</div>  
<?php
function pagination($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
}
?>

<div class="pages_1">Total number of Memberships: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'membership.php?action=view&page=',$rCount); //call function to show pagination?>
</div>        
      
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(".sap").click(function() {
    var values = $(this).data('url').split(" ");
    var registration_id=values[0];
    var member=values[1];
    //alert(member); exit;
    
    if (confirm("Are you sure you want to PUSH this record")) {
        $.ajax({
        url: "create_bp_api.php",
        method:"POST",
        data:{registration_id:registration_id,member:member},
        type: "POST",
        beforeSend: function() {
            $("#overlay").show();
        },
        success:function(data)
        {
            //console.log(data); exit;
            if($.trim(data)==1){
                alert("BP successfully Created..");; 
                window.location.href = "membership.php?action=view";
            }else{
                alert("Sorry There is some problem with SAP response");; 
                window.location.href = "membership.php?action=view";
            
            }
            console.log(data);
        },
        });
    }     
});

$(".so").click(function() {
    var values = $(this).data('url').split(" ");
    var bpno=values[0];
    var registration_id=values[1];
    var renew_check=values[2];
    var member=values[3];
    //alert(registration_id);
    
    if (confirm("Are you sure you want to create sales order")) {
        $.ajax({
        url: "create_mem_so_api.php",
        method:"POST",
        data:{bpno:bpno,registration_id:registration_id,renew_check:renew_check,member:member},
        type: "POST",
        beforeSend: function() {
            $("#overlay").show();
        },
        success:function(data)
        {
            //console.log(data); exit;
            if($.trim(data)==1){
                alert("Sales Order successfully Created..");; 
                window.location.href = "membership.php?action=view";
            }else{
                alert("Sorry There is some problem with SAP response");; 
                window.location.href = "membership.php?action=view";
            
            }
            console.log(data);
        },
        });
    }     
});

$(".delta").click(function() {
    var values = $(this).data('url');
    var registration_id=values;
    //alert(registration_id);
    
    if (confirm("Are you sure you want to update Delta")) {
        $.ajax({
        url: "create_delta_api.php",
        method:"POST",
        data:{registration_id:registration_id},
        type: "POST",
        beforeSend: function() {
            $("#overlay").show();
        },
        success:function(data)
        {
            console.log(data);
            if($.trim(data)==1){
                alert("Delta Updated successfully Created..");; 
                window.location.href = "membership.php?action=view";
            }else{
                alert("Sorry There is some problem with SAP response");; 
                window.location.href = "membership.php?action=view";
            }
        },
        });
    }     
});
</script>
<div id="overlay"></div>
<style>
#overlay {
    position: fixed;
    display: none; 
    width: 100%; 
    height: 100%; 
    top: 0; 
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.8);
z-index:999;}   
</style>
</body>
</html>`