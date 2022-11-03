<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Registration ||GJEPC||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
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
<script language="javascript">
function checkdata()
{
  remarks=document.getElementById('remarks').value;
  if( remarks=="")
  {
    alert("Please Leave A short Remark about Application");
    document.getElementById('remarks').focus();
    return false;
  }
}
</script>
<!--navigation end-->

<style type="text/css">
.style1 {color: #FF0000}
.style2 {
  font-size: 16px;
  font-weight: bold;
}
.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #333;
    margin-bottom: 17px;
    margin-top: 13px;
}
.status_a{background: #05a505;padding: 5px 5px;color: #fff}
.status_p{background: #ff9b00;padding: 5px 5px;color: #fff}
.status_r{background: #ff7575;padding: 5px 5px;color: #fff}
.view_details{background: #fff;color:#000;}
.btn_export{
  display:inline-block;
  background: #f67d5c;
  color: #fff;

  padding: 5px 10px;
  text-decoration: none;
}
</style>

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
  <div class="nav"><?php include("include/menu.php");?></div>
</div>
<style>
  .exp_imp tr th{
    border:1px solid #999999;
  }
</style>
<div class="clear"></div>

<div class="breadcome_wrap">
  <div class="breadcome"><a href="admin.php">Home</a> > Manage Vendor Uploaded Common Documents </div>
</div>
<?php
$userName =  $_SESSION['curruser_contact_name'];
if(($_REQUEST['action']=='approved') && ($_REQUEST['id']!=''))
{
    $status = $_REQUEST['status'];  
    $id	=	$_REQUEST['id'];
    $vendor_id	= $_REQUEST['vendor_id'];
    $remarks = ""; 
    $area_id = $_REQUEST['area_id'];
	
    $sql="update vendor_area_registration set status='$status',remarks='$remarks',action_by='$userName' where vendor_id='$vendor_id' and area_id='$area_id'"; 
    $stmt = $conn -> prepare($sql);
	$stmt->execute();
	
    $getVendorData  = "SELECT * FROM vendor_registration WHERE id=?";
	$query = $conn -> prepare($getVendorData);
	$query -> bind_param("i", $vendor_id);
	$query->execute();			
	$result2 = $query->get_result();
	$VendorDataResult = $result2->fetch_assoc();
	$contact_name = $VendorDataResult['contact_name'];
	$company_name = $VendorDataResult['company_name'];   
	$to = $VendorDataResult['contact_email'];

$message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Approval of EOI Application</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style="">Dear Sir / Madam,<strong style="text-transform:uppercase;">'.$contact_name.'</strong></p>
        <p style="">Company Name, <strong style="text-transform:uppercase;">'.$company_name.'</strong></p>

        <p style=""><strong>Congratulations!</strong> Your application for Expression of Interest for Vendor Empanelment for Financial Year 2019-2021 : <strong style="text-transform:uppercase;">'.getVendorAreaName($area_id).'</strong> has been approved. </p>
       
        <div style="border-top:1px solid #ccc;">
        <p>Kind regards,<br>
        <strong>GJEPC Web Team</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "GJEPC INDIA Vendor Area Registration."; 
   $headers  = 'MIME-Version: 1.0'."\n"; 
   $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
   $headers .= 'From:GJEPC INDIA <do-not-reply@gjepc.org>'."\n";
   $headers .= 'Cc: iijsteam@gjepcindia.com' . "\n";
  
  $mail_result = mail($to, $subject, $message, $headers);
    echo"<meta http-equiv=refresh content=\"0;url=vendor_registration_list.php?action=view\">";
}

if(($_REQUEST['action']=='reject') && ($_REQUEST['vendor_id']!=''))
{
    $status="rejected"; 
    $area_id=$_REQUEST['area_id'];
    $vendor_id=$_REQUEST['vendor_id'];
    $remarks = $_REQUEST['remarks'];   
       
    $sql="update vendor_area_registration set status='$status',remarks='$remarks' where vendor_id='$vendor_id' and area_id='$area_id'";
    $stmt = $conn -> prepare($sql);
	$stmt->execute();	
	
	$getVendorData  = "SELECT * FROM vendor_registration WHERE id=?";
	$query = $conn -> prepare($getVendorData);
	$query -> bind_param("i", $vendor_id);
	$query->execute();			
	$result2 = $query->get_result();
	$VendorDataResult = $result2->fetch_assoc();
	$contact_name = $VendorDataResult['contact_name'];
	$company_name = $VendorDataResult['company_name'];     
    $to = $VendorDataResult['contact_email'];

$message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Dissaproval of EOI Application</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style="">Dear Sir / Madam,<strong style="text-transform:uppercase;">'.$contact_name.'</strong></p>
        <p style="">Company Name, <strong style="text-transform:uppercase;">'.$company_name.'</strong></p>
        <p style="">We regret to inform you that Your application for Expression of Interest for Vendor Empanelment for Financial Year 2019-2021 : <strong style="text-transform:uppercase;">'.getVendorAreaName($area_id).'</strong> has been disapproved due to <span style="color:red"> document submitted are not matching minimum required criteria<span></p>
        <p style=""><strong>Remarks :</strong> '.$remarks.'</p>
        <div style="border-top:1px solid #ccc;">
        <p>Kind regards,<br>
        <strong>GJEPC Web Team</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "GJEPC INDIA Vendor Area Registration."; 
   $headers  = 'MIME-Version: 1.0'."\n"; 
   $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
   $headers .= 'From:GJEPC INDIA <do-not-reply@gjepc.org>'."\n";
   $headers .= 'Cc: iijsteam@gjepcindia.com' . "\n";
  $mail_result = mail($to, $subject, $message, $headers);

    echo"<meta http-equiv=refresh content=\"0;url=vendor_registration_list.php?action=view\">";
}
?>

<?php
if (($_REQUEST['action']=='approveCommonDoc') && ($_REQUEST['id']!=''))
{

    $status=$_REQUEST['status'];
    $remarks = " ";         
    $vendor_id=$_REQUEST['vendor_id'];
    $doc_name=$_REQUEST['doc_name'];
    $id=$_REQUEST['id'];
    
	$sql="update vendor_document_uploads set status='$status',remarks='$remarks',action_by='$userName' where id='$id'";
    $stmt = $conn -> prepare($sql);
	$stmt->execute();	
	
	$getVendorData  = "SELECT * FROM vendor_registration WHERE id=?";
	$query = $conn -> prepare($getVendorData);
	$query -> bind_param("i", $vendor_id);
	$query->execute();			
	$result2 = $query->get_result();
	$VendorDataResult = $result2->fetch_assoc();
	$contact_name = $VendorDataResult['contact_name'];
	$company_name = $VendorDataResult['company_name'];   
	$to = $VendorDataResult['contact_email'];
$message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Approval of Document</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style="">Dear Sir / Madam,<strong style="text-transform:uppercase;">'.$contact_name.'</strong></p>
        <p style="">Company Name, <strong style="text-transform:uppercase;">'.$company_name.'</strong></p>
         <p style=""> Your Document for Vendor Empanelment for Financial Year 2019-2021 : <strong style="text-transform:uppercase;">'.$doc_name.'</strong> has been approved. </p>
        
        <div style="border-top:1px solid #ccc;">
        <p>Kind regards,<br>
        <strong>GJEPC Web Team</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "GJEPC INDIA Vendor Area Registration."; 
   $headers  = 'MIME-Version: 1.0'."\n"; 
   $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
   $headers .= 'From:GJEPC INDIA <do-not-reply@gjepc.org>'."\n";
   $headers .= 'Cc: iijsteam@gjepcindia.com' . "\n";
  $mail_result = mail($to, $subject, $message, $headers);
    echo"<meta http-equiv=refresh content=\"0;url=vendor_registration_list.php?id=$vendor_id&action=viewDocs\">";
}

if(($_REQUEST['action']=='approveVariableDoc') && ($_REQUEST['id']!=''))
{
    $status=$_REQUEST['status'];
    $area_id=$_REQUEST['area_id'];
    $remarks = " "; 
    $doc_name=$_REQUEST['doc_name'];
    $key = $_REQUEST['document_key'];  
    $vendor_id=$_REQUEST['vendor_id'];
    $id=$_REQUEST['id'];
	
    $sql="update area_spec_doc_upload set status='$status',remarks='$remarks',action_by='$userName' where document_key='$key'and id='$id' and area_id ='$area_id'";
    $stmt = $conn -> prepare($sql);
	$stmt->execute();	
	
	$getVendorData  = "SELECT * FROM vendor_registration WHERE id=?";
	$query = $conn -> prepare($getVendorData);
	$query -> bind_param("i", $vendor_id);
	$query->execute();			
	$result2 = $query->get_result();
	$VendorDataResult = $result2->fetch_assoc();
   $contact_name = $VendorDataResult['contact_name'];
   $company_name = $VendorDataResult['company_name'];
   
   $to = $VendorDataResult['contact_email'];
   $message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Approval of Document</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style="">Dear Sir / Madam,<strong style="text-transform:uppercase;">'.$contact_name.'</strong></p>
        <p style="">Company Name, <strong style="text-transform:uppercase;">'.$company_name.'</strong></p>
         <p style=""> Your Document for Vendor Empanelment for Financial Year 2019-2021 : <strong style="text-transform:uppercase;">'.$doc_name.'</strong> has been approved. </p>
        
        <div style="border-top:1px solid #ccc;">
        <p>Kind regards,<br>
        <strong>GJEPC Web Team</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "GJEPC INDIA Vendor Area Registration."; 
   $headers  = 'MIME-Version: 1.0'."\n"; 
   $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
   $headers .= 'From:GJEPC INDIA <do-not-reply@gjepc.org>'."\n";
   $headers .= 'Cc: iijsteam@gjepcindia.com' . "\n";
  $mail_result = mail($to, $subject, $message, $headers);
    echo"<meta http-equiv=refresh content=\"0;url=vendor_registration_list.php?id=$vendor_id&action=viewVariableDocs&area_id=$area_id\">";
}

if (($_REQUEST['action']=='rejectCommon') && ($_REQUEST['id']!=''))
{
    $status="rejected"; 
    $id=$_REQUEST['id'];
    $doc_name=$_REQUEST['doc_name'];
    $vendor_id =$_REQUEST['vendor_id'];
    $remarks = $_REQUEST['remarks'];   
       
    $sql="update vendor_document_uploads set status='$status',remarks='$remarks',action_by='$userName' where id='$id' ";
    $stmt = $conn -> prepare($sql);
	$stmt->execute();	
	
	$getVendorData  = "SELECT * FROM vendor_registration WHERE id=?";
	$query = $conn -> prepare($getVendorData);
	$query -> bind_param("i", $vendor_id);
	$query->execute();			
	$result2 = $query->get_result();
	$VendorDataResult = $result2->fetch_assoc();

   $contact_name = $VendorDataResult['contact_name'];
   $company_name = $VendorDataResult['company_name'];
   
   $to = $VendorDataResult['contact_email'];
   $message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Disapproval of Document</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style="">Dear Sir / Madam,<strong style="text-transform:uppercase;">'.$contact_name.'</strong></p>
        <p style="">Company Name, <strong style="text-transform:uppercase;">'.$company_name.'</strong></p>
         <p style=""> Your Document for Vendor Empanelment for Financial Year 2019-2021 : <strong style="text-transform:uppercase;">'.$doc_name.'</strong> has been disapproved. </p>
                  <p style=""> <strong>Remarks</strong>  '.$remarks.' </p>
                  <p style="color:red">KINDLY RE-UPLOAD THE REQUIRED DOCUMENTS WITHIN TWO WORKING DAYS. INCASE YOU FAIL TO RE-UPLOAD THE REQUIRED DOCUMENTS YOUR APPLICATION WILL BE CONSIDERED AS REJECTED</p>

        
        <div style="border-top:1px solid #ccc;">
        <p>Kind regards,<br>
        <strong>GJEPC Web Team</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "GJEPC INDIA Vendor Area Registration."; 
   $headers  = 'MIME-Version: 1.0'."\n"; 
   $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
   $headers .= 'From:GJEPC INDIA <do-not-reply@gjepc.org>'."\n";
   $headers .= 'Cc: iijsteam@gjepcindia.com' . "\n";
  $mail_result = mail($to, $subject, $message, $headers);
    echo"<meta http-equiv=refresh content=\"0;url=vendor_registration_list.php?action=viewDocs&id=$vendor_id\">";
}

if (($_REQUEST['action']=='rejectVariable') && ($_REQUEST['id']!=''))
{
    $status="rejected"; 
    $id=$_REQUEST['id'];
    $doc_name=$_REQUEST['doc_name'];
    $vendor_id =$_REQUEST['vendor_id'];
    $remarks = $_REQUEST['remarks'];   
    $area_id = $_REQUEST['area_id']; 
    
	$sql="update area_spec_doc_upload set status='$status',remarks='$remarks',action_by='$userName' where id='$id' ";
    $stmt = $conn -> prepare($sql);
	$stmt->execute();	
	
	$getVendorData  = "SELECT * FROM vendor_registration WHERE id=?";
	$query = $conn -> prepare($getVendorData);
	$query -> bind_param("i", $vendor_id);
	$query->execute();			
	$result2 = $query->get_result();
	$VendorDataResult = $result2->fetch_assoc();
   $contact_name = $VendorDataResult['contact_name'];
   $company_name = $VendorDataResult['company_name'];
   
   $to = $VendorDataResult['contact_email'];
   $message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Disapproval of Document</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style="">Dear Sir / Madam,<strong style="text-transform:uppercase;">'.$contact_name.'</strong></p>
        <p style="">Company Name, <strong style="text-transform:uppercase;">'.$company_name.'</strong></p>
         <p style=""> Your Document for Vendor Empanelment for Financial Year 2019-2021 : <strong style="text-transform:uppercase;">'.$doc_name.'</strong> has been disapproved. </p>
         <p style=""> <strong>Remarks</strong>:  '.$remarks.' </p>
         <p style="color:red">KINDLY RE-UPLOAD THE REQUIRED DOCUMENTS WITHIN TWO WORKING DAYS. INCASE YOU FAIL TO RE-UPLOAD THE REQUIRED DOCUMENTS YOUR APPLICATION WILL BE CONSIDERED AS REJECTED</p>
        
        <div style="border-top:1px solid #ccc;">
        <p>Kind regards,<br>
        <strong>GJEPC Web Team</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "GJEPC INDIA Vendor Area Registration."; 
   $headers  = 'MIME-Version: 1.0'."\n"; 
   $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
   $headers .= 'From:GJEPC INDIA <do-not-reply@gjepc.org>'."\n";
   $headers .= 'Cc: iijsteam@gjepcindia.com' . "\n";
  $mail_result = mail($to, $subject, $message, $headers);
    echo"<meta http-equiv=refresh content=\"0;url=vendor_registration_list.php?action=viewVariableDocs&id=$vendor_id&area_id=$area_id\">";
}
?>

 <?php if($_REQUEST['action']=='rejectVariableDoc') { 
  $action= "rejectVariable";
  $appId= $_REQUEST['id'];
  $vendor_id= $_REQUEST['vendor_id'];
  echo $area_id=$_REQUEST['area_id'];
 ?>  
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
    <tr class="orange1">
    <td colspan="2"> &nbsp;Reject Vendors Uploaded Variable Document </td>
    </tr>

     <tr>
      <td valign="middle" class="content_txt">Remarks<span class="star">*</span></td>
      <td>
          
          <textarea  name="remarks" id="remarks" class="show-tooltip input_txt" title="Please Enter Remarks" rows="10" ></textarea>
      </td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />
    <input type="hidden" name="vendor_id" id="vendor_id"  value="<?php echo $vendor_id;?>" />
    <input type="hidden" name="area_id" id="area_id"  value="<?php echo $area_id;?>" />
  
    </td>
    </tr>
</table>
</form>
</div>    
<?php } ?>   

<?php if($_REQUEST['action']=='rejectCommonDoc') { 
  $action= "rejectCommon";
  $appId= $_REQUEST['id'];
  $vendor_id= $_REQUEST['vendor_id'];
 ?>  
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
    <tr class="orange1">
    <td colspan="2"> &nbsp;Reject Vendors Uploaded Common Document </td>
    </tr>

     <tr>
      <td valign="middle" class="content_txt">Remarks<span class="star">*</span></td>
      <td>
          
          <textarea  name="remarks" id="remarks" class="show-tooltip input_txt" title="Please Enter Remarks" rows="10" ></textarea>
      </td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />
    <input type="hidden" name="vendor_id" id="id"  value="<?php echo $vendor_id;?>" />
  
    </td>
    </tr>
</table>
</form>
        </div>    
 <?php } ?>   
<div id="main">
  <div class="content">
     

<?php if($_REQUEST['action']=='view') {?>     
<div class="content_details1">
 <a href="vendor_report.php" title="" class="btn btn_export">Report variable docs</a>   <a href="report_common_docs.php" title="" class="btn btn_export">Report common docs</a> 
  <a href="export_vendor_empanelment.php" title="" class="btn btn_export">Report Application</a> 
<table id="example" class="" style="width:100%">
        <thead>
            <tr class="orange1">
                <th>Sr. No.</th>
                <th>Company Name</th>
                <th>Area</th>
                <th>Date</th>
                <th>Company Details</th>
                <th>Common Documents</th>
                <th>Variable Docs</th>
                <th>Remarks</th>
                <th>Status</th>
                <th>Action</th>
                <th>Action By</th>             
            </tr>
        </thead>
        <tbody>
    <?php    
    $i=1;
    $sqlx1 = "SELECT * FROM vendor_area_registration";
    $query = $conn -> prepare($sqlx1);
	$query->execute();			
	$result = $query->get_result();
    $rCount=0;
    $rCount=$result->num_rows;		
    if($rCount>0)
    {
	while($row = $result->fetch_assoc())
	{ 
    ?>
            <tr>
                <td><?php echo $i;?></td>
                <td><?php echo getVendorCompanyName($row['vendor_id'],$conn);?></td>
                <td><?php echo getVendorAreaName($row['area_id'],$conn);?></td>
            
                <td><?php echo $row['created_at'];?></td>
                <td><a href="vendor_registration_list.php?id=<?php echo $row['vendor_id']; ?>&action=viewDetails" class="view_details" > View Details</a></td>
                <td><a href="vendor_registration_list.php?id=<?php echo $row['vendor_id']; ?>&action=viewDocs" class="view_details" > View Common Docs</a></td>
                <td><a href="vendor_registration_list.php?id=<?php echo $row['vendor_id']; ?>&action=viewVariableDocs&area_id=<?php echo $row['area_id'];?>" class="view_details"> View Variable Docs</a></td>
                <td><?php echo $row['remarks'];?></td>

               <td><?php if($row['status']=="approved"){
                echo'<span class="status_a">Approved</span>';
                }else if($row['status']=="rejected"){
                   echo'<span class="status_r">Rejected</span>'; 
               }else if($row['status']=="pending"){
                   echo'<span class="status_p">Pending</span>'; 
               } ?></td>
          
                <td><a href="vendor_registration_list.php?id=<?php echo $row['id']; ?>&status=approved&action=approved&area_id=<?php echo $row['area_id'];?>&vendor_id=<?php echo $row['vendor_id'];?>" class="approve" data-name="approve"  id="<?php echo $row['id'];?>" data-id="<?php echo $row['id'];?>" onClick="return(window.confirm('Are you sure you want to Approve.'));">Approve</a>
                  &nbsp;&nbsp;&nbsp;
                  <a  href="vendor_registration_list.php?id=<?php echo $row['id']; ?>&action=rejectForm" class="reject"  data-name="reject"  id="<?php echo $row['id'];?>" data-id="<?php echo $row['id'];?>" >Reject</a></td>
                  <td><?php echo $row['action_by']; ?></td>
         
            </tr>
            <?php
			$i++;
			}
			}
			?>
          </tbody>
        </table>        
</div>        

<?php } ?>        
<?php if($_REQUEST['action']=='rejectForm') {
  $action= "reject";
  $appId= $_REQUEST['id'];

  $getApplicationInfo = "SELECT * FROM vendor_area_registration WHERE id=?";
  $stmt = $conn -> prepare($getApplicationInfo);
  $stmt->bind_param("i", $appId);
  $stmt->execute();			
  $result = $stmt->get_result();
  $resultApplication = $result->fetch_assoc();
  $area = $resultApplication['area_id'];
  $vendor_id = $resultApplication['vendor_id'];
 ?>  
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
    <tr class="orange1">
    <td colspan="2"> &nbsp;Reject Vendor Application </td>
    </tr>

     <tr>
      <td valign="middle" class="content_txt">Remarks<span class="star">*</span></td>
      <td>
          
          <textarea  name="remarks" id="remarks" class="show-tooltip input_txt" title="Please enter Area" rows="10" ></textarea>
      </td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />
    <input type="hidden" name="area_id" id="area_id"  value="<?php echo $area ;?>" />
    <input type="hidden" name="vendor_id" id="vendor_id"  value="<?php echo $vendor_id ;?>" />
    </td>
    </tr>
</table>
</form>
</div>    
 <?php } ?>   
 
<?php if($_REQUEST['action']=='viewDetails') {
	$sql3 = "SELECT * FROM vendor_registration where id=?";
  $query = $conn -> prepare($sql3);
  $id = intval($_REQUEST['id']);
	$query -> bind_param("i", $id);
	$query->execute();			
	$result2 = $query->get_result();
	if($row2 = $result2->fetch_assoc())
    {
      $company=stripslashes($row2['company_name']);
      $email=stripslashes($row2['contact_email']);
      $name=stripslashes($row2['contact_name']);
      $number=stripslashes($row2['contact_number']);
      $gst=stripslashes($row2['gst']);     
    }
?>
 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details</td>
     </tr>        
     <tr>
       <td class="content_txt">Company Name</td>
       <td class="text6"><?php echo $company; ?></td>
     </tr>
      <tr>
       <td class="content_txt">Contact Name</td>
       <td class="text6"><?php echo $name; ?></td>
     </tr>
      <tr>
       <td class="content_txt">Contact Number</td>
       <td class="text6"><?php echo $number; ?></td>
     </tr>       
     <tr>
       <td class="content_txt">Contact Email </td>
       <td class="text6"><?php echo $email; ?></td>
     </tr>    
     <tr>
       <td class="content_txt">GST Number </td>
       <td class="text6"><?php echo $gst; ?></td>
     </tr>
   </table>
 </div>

<?php } ?> 
<?php if($_REQUEST['action']=='viewDocs') { ?>
<div class="content_details1">
    <h3>Uploaded Common Documents</h3>
<table id="example" class="" style="width:100%">
        <thead>
            <tr class="orange1">
                <th>Sr. No.</th>                
				<th>Document Name</th>
                <th>Uploaded At</th>
                <th>View</th>
                <th>Remarks</th>
                <th>Document Type</th>
                <th>Action by</th>
				<th>Document Status</th>
				<th>Action</th>
			</tr>
        </thead>
        <tbody>
    <?php    
    $i=1;
	//$commonSql = "SELECT * FROM vendor_document_uploads where vendor_id=?";
    $commonSql = "SELECT vdu.id AS id, vdu.vendor_id AS vendor_id, 
                  vdu.document_name AS document_name, vdu.document_key AS document_key,
                  vdu.document AS document,vdu.`status` AS status,vdu.remarks AS remarks, vdu.created_at AS created_at,
                  vdu.action_by AS action_by, vd.`type` AS type, vd.access AS document_type
                  FROM vendor_document_uploads AS vdu
                  LEFT JOIN vendor_documents AS vd on vdu.document_key = vd.document_key
                  where vendor_id=?";
   // echo $commonSql;die();              
	$vendor_id = $_REQUEST['id'];
  $query = $conn -> prepare($commonSql);
  $id = intval($_REQUEST['id']);
	$query -> bind_param("i", $id);
	$query->execute();			
	$result = $query->get_result();
    $rCount=0;
    $rCount=$result->num_rows;		
    if($rCount>0)
    {
	while($common_row = $result->fetch_assoc())
	  { 
    ?>
            <tr>
                <td><?php echo $i;?></td>                
                <td><?php echo $common_row['document_name'];?></td>
                <td><?php echo $common_row['created_at'];?></td>              
                <td><a href="/<?php echo $common_row['document'];?>" target="_blank" ><img src="images/download.png"></a></td>
                <td><?php echo $common_row['remarks'];?></td>
                <td><?php echo $common_row['document_type'];?></td>
                <td><?php echo $common_row['action_by'];?></td>

               <td><?php if($common_row['status']=="approved"){
                echo'<span class="status_a">Approved</span>';
                }else if($common_row['status']=="rejected"){
                   echo'<span class="status_r">Rejected</span>'; 
               }else if($common_row['status']=="pending"){
                   echo'<span class="status_p">Pending</span>'; 
               } ?></td>
          
                <td><a href="vendor_registration_list.php?id=<?php echo $common_row['id']; ?>&status=approved&action=approveCommonDoc&vendor_id=<?php echo $vendor_id;?>&doc_name=<?php echo $common_row['document_name'];?>" class="approve" data-name="approve"  id="<?php echo $common_row['id'];?>" data-id="<?php echo $common_row['id'];?>" onClick="return(window.confirm('Are you sure you want to Approve.'));">Approve</a>
                  &nbsp;&nbsp;&nbsp;
                  <a  href="vendor_registration_list.php?id=<?php echo $common_row['id']; ?>&action=rejectCommonDoc&vendor_id=<?php echo $vendor_id;?>&doc_name=<?php echo $common_row['document_name'];?>" class="reject"  data-name="reject"  id="<?php echo $common_row['id'];?>" data-id="<?php echo $common_row['id'];?>" onClick="return(window.confirm('Are you sure you want to Reject.'));">Reject</a></td>
         
            </tr>
            <?php
			  $i++;
				 }
			   }
			?>
          </tbody>
        </table>        
</div>

<?php } ?>   
<?php if($_REQUEST['action']=='viewVariableDocs') {
$area_id = $_REQUEST['area_id'];
?>
<div class="content_details1">
    <h3>Uploaded Area Specific Documents</h3>
<table id="example" class="" style="width:100%">
        <thead>
            <tr class="orange1">
                <th>Sr. No.</th>      
                <th>Document Name</th>
                <th>Uploaded At</th>
                <th>View</th>
                <th>Remarks</th>
                <th>Document Type</th>
                <th>Action by</th>
				<th>Document Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php    
		$i=1;
		//$variableSql = "SELECT * FROM area_spec_doc_upload where vendor_id=? AND area_id=?";
    $variableSql = "SELECT asd.id AS id, asd.area_id AS area_id,asd.vendor_id AS vendor_id, 
                    asd.document_name AS document_name, asd.document_key AS document_key,
                    asd.document AS document,asd.`status` AS status,asd.remarks AS remarks, asd.created_at AS created_at,
                    asd.action_by AS action_by, vd.`type` AS type, vd.access AS document_type
                    FROM area_spec_doc_upload AS asd
                    LEFT JOIN vendor_documents AS vd on asd.document_key = vd.document_key 
                    where vendor_id=? AND area_id=?";
		$query = $conn -> prepare($variableSql);
		$query->bind_param("is", $_REQUEST['id'],$area_id);
		$query->execute();			
		$result = $query->get_result();
		$rCount=0;
		$rCount=$result->num_rows;		
		if($rCount>0)
		{
		while($variable_row = $result->fetch_assoc())
		  { 
		?>
            <tr>
                <td><?php echo $i;?></td>
              
                <td><?php echo $variable_row['document_name'];?></td>
                <td><?php echo $variable_row['created_at'];?></td>            
                <td><a href="/<?php echo $variable_row['document'];?>" target="_blank" ><img src="images/download.png"></a></td>
				<td><?php echo $variable_row['remarks'];?></td>
        <td><?php echo $variable_row['document_type'];?></td>
				<td><?php echo $variable_row['action_by'];?></td>
				<td><?php if($variable_row['status']=="approved"){
                echo'<span class="status_a">Approved</span>';
                }else if($variable_row['status']=="rejected"){
                   echo'<span class="status_r">Rejected</span>'; 
               }else if($variable_row['status']=="pending"){
                   echo'<span class="status_p">Pending</span>'; 
               } ?></td>
          
                <td><a href="vendor_registration_list.php?id=<?php echo $variable_row['id']; ?>&area_id=<?php echo $variable_row['area_id'];?>&document_key=<?php echo $variable_row['document_key'];?>&status=approved&action=approveVariableDoc&vendor_id=<?php echo  $_REQUEST[id]; ?>&doc_name=<?php echo $variable_row['document_name'];?>" class="approve" data-name="approve"  id="<?php echo $variable_row['id'];?>" data-id="<?php echo $variable_row['id'];?>" onClick="return(window.confirm('Are you sure you want to Approve.'));">Approve</a>
                  &nbsp;&nbsp;&nbsp;
                  <a  href="vendor_registration_list.php?id=<?php echo $variable_row['id']; ?>&action=rejectVariableDoc&vendor_id=<?php echo $_REQUEST[id];?>&area_id=<?php echo $variable_row['area_id'] ?>&doc_name=<?php echo $variable_row['document_name'];?>" class="reject"  data-name="reject"  id="<?php echo $variable_row['id'];?>" data-id="<?php echo $variable_row['id'];?>" onClick="return(window.confirm('Are you sure you want to Reject.'));">Reject</a></td>
         
            </tr>
             <?php
			  $i++;
				 }
			   }
			   ?>
          </tbody>
        </table>        
</div>
       
<?php } ?>   
<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script>
  $(document).ready(function() {
    $('#example').DataTable();

} );
</script>
</body>
</html>
