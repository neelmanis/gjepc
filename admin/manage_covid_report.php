<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
  $adminId = intval(filter($_SESSION['curruser_login_id']));
  $registration_id = intval(filter($_REQUEST['regid']));
  $orderId = filter($_REQUEST['orderId']);
  $id = intval(filter($_REQUEST['id']));
?>
<?php 
function getVisIdFromEmail($email,$conn){
    $query_sel = "SELECT `visitor_id` FROM `globalExhibition` WHERE email like '$email' AND participant_Type='INTL'";    
    $result = $conn->query($query_sel);
    $row = $result->fetch_assoc();      
    return $row['visitor_id'];
}

function ExhbitorName($visitor_id){
        $host="localhost";
        $user="appadmin";
        $password="G@k593#sgtk";
        $dbname="manual_iijs2021";
        // Create connection
        $conn2 = new mysqli($host, $user, $password, $dbname);
        $query_sel = "SELECT Badge_Name FROM manual_iijs2021.iijs_badge_items where Badge_Item_ID='$visitor_id'";
        $result = $conn2->query($query_sel);
        $row = $result->fetch_assoc();      
        return $row['Badge_Name'];
}

function ExhbitorNameEXHM($visitor_id){
        $host="localhost";
        $user="appadmin";
        $password="#21SAq109@65%n";
        $dbname="manual_igjme";
        // Create connection
        $conn2 = new mysqli($host, $user, $password, $dbname);
        $query_sel = "SELECT Badge_Name FROM manual_igjme.iijs_badge_items where Badge_Item_ID='$visitor_id'";
        $result = $conn2->query($query_sel);
        $row = $result->fetch_assoc();      
        return $row['Badge_Name'];
}
?>
<?php
if(($_REQUEST['action']=='updateApproval')&&($_REQUEST['id']!='') &&($_REQUEST['regid']!=''))
{   
    $id    = intval(filter($_REQUEST['id']));
    $registration_id    = intval(filter($_REQUEST['regid']));
    
    $dose1_status   = filter($_REQUEST['dose1_status']);
    $dose2_status   = filter($_REQUEST['dose2_status']);
    $booster_dose_status   = filter($_REQUEST['booster_dose_status']);
    $remark = filter($_REQUEST['remark']);
    $modified_at = date("Y-m-d H:i:s");

    $website = "IIJS PREMIERE 2022";
    $websiteUrl = "https://gjepc.org/iijs-premiere/";
   
    $cert = "Vaccine Certificate";
    $reason = "Duplicate Certificate";
    $contact = "1800-103-4353";
    $badgeDate = "10-02-2022";

    $labInfo = $conn->query("SELECT * FROM visitor_lab_info WHERE id='$id'");
    $rowLabInfo = $labInfo->fetch_assoc();
    $category_for = $rowLabInfo['category_for'];
    $visitor_id = $rowLabInfo['visitor_id'];
    $visitorMobile = $rowLabInfo['mobile_no'];
    
    if($category_for =="VIS"){
       $name = VisitorName($visitor_id,$conn);
       $email = VisitorEmail($visitor_id,$conn);
       $websiteLink = "https://registration.gjepc.org/visitor-covid-report-upload.php";
    }else if($category_for=="INTL"){
       $name = intlVisitorName($visitor_id,$conn);
       $email = intlVisitorEmail($visitor_id,$conn);
    }else if($category_for=="EXH"){
       $name = ExhbitorName($visitor_id,$conn2); 
       $websiteLink = "https://registration.gjepc.org/login.php";
    }else if($category_for=="EXHM"){
       $name = ExhbitorNameEXHM($visitor_id,$conn2); 
       $websiteLink = "https://gjepc.org/igjme/login.php";
    }

   if( $dose2_status =="Y" || $booster_dose_status =="Y")
   {
   $approval_status ="Y";
   $remark ="";
   $app = "GJEPC app";

   //$messagev ="Dear $name, your Vaccination Certificate has been approved, kindly download your E-badge from $app Team GJEPC";
   //$messagev ="Dear $name, your Vaccination Certificate has been approved, kindly download your E-badge from $app after 25th December 2021 Team GJEPC";
   //$messagev = "Dear $name, your $cert has been approved, kindly download your E-badge from $app after $badgeDate Team GJEPC";
   $messagev = "Dear $name, your $cert has been approved.";
   } else if($dose2_status =="N"){
   $approval_status ="N";
   //$messagev ="Dear $name, your $cert has been disapproved, due to $remark. Please visit $websiteUrl and re-upload $cert. For any further assistance please contact $contact. Regards, GJEPC";
    $messagev ="Dear $name, your $cert has been disapproved, due to $remark. Kindly re upload your valid VC on $websiteLink For any further assistance please contact $contact. Regards, GJEPC"; 
   
   } elseif( $dose2_status =="P"){

   $approval_status ="P";
   $remark="";

  }elseif($dose1_status =="N" || $dose2_status=="P"){

   $approval_status ="N";
   $messagev ="Dear $name, your $cert has been disapproved, due to $remark. Kindly re upload your valid VC on $websiteLink For any further assistance please contact $contact. Regards, GJEPC";
  }elseif($dose2_status =="N" || $dose1_status=="P"){

   $approval_status ="N";
   $messagev ="Dear $name, your $cert has been disapproved, due to $remark. Kindly re upload your valid VC on $websiteLink For any further assistance please contact $contact. Regards, GJEPC";
  }else{
   $approval_status ="P";
   $remark='';
  }
/*
Dear {#var#}, your Vaccine Certificate has been disapproved, due to {#var#}. Kindly re upload your valid VC on {#var#}{#var#}{#var#}For any further assistance please contact {#var#}. Regards, GJEPC

Dear {#var#}, your Vaccination   Certificate has been approved, kindly download your E-badge from {#var#} Team GJEPC

*/
$sqlx = "UPDATE `visitor_lab_info` SET `approval_status`='$approval_status',`dose1_status`='$dose1_status',`dose2_status`='$dose2_status',`booster_dose_status`='$booster_dose_status',`remark`='$remark',adminId='$adminId' WHERE id='$id' and registration_id='$registration_id'";
 $resultx = $conn ->query($sqlx);
    
if($resultx )
{   
    $getDetails = $conn->query("SELECT * FROM visitor_lab_info WHERE `id`='$id' AND `registration_id`='$registration_id'");
    $row =$getDetails->fetch_assoc();
    $visitor_id = $row['visitor_id']; 
    $category_for = $row['category_for']; 
    $certificate = $row['certificate']; 

    if($approval_status =="N"){
      $covid_report_status = "positive";
      $approval_status = "D";

    }else if($approval_status =="Y"){
      $covid_report_status = "negative";
      $approval_status = "Y";

    }else{
      $covid_report_status = "pending";
      $approval_status = "P";
    }

    $checkEntry = $conn->query("SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='$category_for'");
    $checkCount = $checkEntry->num_rows;
    $checkEntryRow = $checkEntry->fetch_assoc();

    if($checkCount >0){
          $isDownload = $checkEntryRow['isDataPosted'];
          $refund_status = $checkEntryRow['status'];
         if($isDownload =="N"){
            $updateStatus = "I";
         }else{
            $updateStatus = "U";
         }
         if($refund_status =="R"){
            echo "<script langauge=\"javascript\">alert(\"Refunded visitor not allowed\");location.href='manage_covid_report.php?action=view';</script>";exit;
         }
        $updateCovidStatus = "UPDATE globalExhibition SET `covid_report_status`='$covid_report_status',`status`='$approval_status',`certificate`='$certificate',`dose1_status`='$dose1_status',`dose2_status`='$dose2_status',`booster_dose_status`='$booster_dose_status',`modified_date`='$modified_at',isDataPosted='N',`updateStatus`='$updateStatus' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `participant_Type`='$category_for' ";
        $resultStatusUpdate = $conn->query($updateCovidStatus);
        if($resultStatusUpdate){

    /*============================== SEND NOTIFICATION AFTER DATA UPDATE START ==================  ======*/

    /*=============================== SMS NOTIFICATION ==================================================*/
       if($category_for=="VIS" || $category_for=="EXH"){
            if($approval_status =="Y" || $approval_status =="D"){
                
              //  send_sms($messagev,$visitorMobile);
            }
       }
    /*================================= EMAIL NOTIFICATION ==============================================*/
        if($approval_status =="Y" || $approval_status =="D"){
            $message = '<table class="table2" width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;"> <tbody> <tr> <td align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png"> <td align="center"> <img id="mi"> </td></td></tr><tr><td colspan="3" height="30"><hr></td></tr><tr> <td colspan="3" id="content"><p> '.$messagev.'</p><p> You can also check more details on https://gjepc.org/iijs-premiere/</p></td></tr><style type="text/css"> .table2 input{width: 80%;border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000;}.table1 input{border-left: none; border-right: none; border-top: none; border-bottom: 1px solid #000; width: 150px;}}.table2 h4{text-align: center;}</style></tbody></table>';
            $to = $email;
            $subject = "VACCINATION CERTIFICATE APPROVAL/DISAPPROVAL "; 
            $headers  = 'MIME-Version: 1.0' . "\n"; 
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
            $headers .= 'From: GJEPC INDIA  <admin@gjepc.org>';          
            mail($to, $subject, $message, $headers);
        }
    /*============================== SEND NOTIFICATION AFTER DATA UPDATE END ===========================*/
             
            echo "<script langauge=\"javascript\">alert(\" Report Updated to global successfully\");</script>";
        }else{
           die("Error:".$conn->error);
        }
    }else{
      die("Error: Visitor Entry not found in global ");
    }

    echo"<meta http-equiv=refresh content=\"0;url=manage_covid_report.php?action=view\">";
  
} else {
die("Error:" .$conn->error);    
}
}
?>
<?php
if(($_REQUEST['action']=='deleteInfo') && $_REQUEST['id']!='')
{ 
    //echo '<pre>'; print_r($_REQUEST); exit;
    $id = $_REQUEST['id'];

    $ssx = "INSERT INTO visitor_lab_info_log SELECT * FROM visitor_lab_info WHERE id = '$id'";
    $queryData = $conn->query($ssx);
    if($queryData){
    $deletx = "DELETE FROM `visitor_lab_info` WHERE id = '$id' limit 1"; 
    $resultx = $conn->query($deletx);
    if($resultx){
    $updatx = "UPDATE `visitor_lab_info_log` SET `adminId` = '$adminId' WHERE id = '$id' limit 1"; 
    $updatx = $conn->query($updatx);
    echo "<script> alert('Deleted from Visitor Lab Info');</script>";
    echo "<meta http-equiv=refresh content=\"0;url=manage_covid_report.php?action=view\">"; exit;
    }
    } else { die ($conn->error); 
    }
}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company_name']="";
  $_SESSION['pan_no']="";
  $_SESSION['email']="";
  $_SESSION['mobile']="";
  $_SESSION['certificate'] = "";
  $_SESSION['visitor_approval']="";
  $_SESSION['category']="";
  
  header("Location: manage_covid_report.php?action=view");
} else
{
    $search_type=$_REQUEST['search_type'];
    if($search_type=="SEARCH")
    { 
    $_SESSION['company_name']=  filter($_REQUEST['company_name']);
    $_SESSION['pan_no']      =  filter($_REQUEST['pan_no']);
    $_SESSION['email']      =  filter($_REQUEST['email']);
    $_SESSION['mobile']      =  filter($_REQUEST['mobile']);
    $_SESSION['certificate'] = $_REQUEST['certificate'];
    $_SESSION['visitor_approval'] = $_REQUEST['visitor_approval'];
    $_SESSION['category'] = $_REQUEST['category'];
    }
}
//print_r($_SESSION);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS PREMIERE 2022</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="fancybox/jquery-3.3.1.js"></script> 
<script type="text/javascript" src="fancybox/fancybox_js.js"></script>
<script type="text/javascript">     
$("div.fancyDemo a").fancybox();
</script>     
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<!--navigation end-->
<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="fancybox/fancybox_css.css" media="screen" />
<script type="text/javascript">
ddsmoothmenu.init({
    mainmenuid: "smoothmenu1", //menu DIV id
    orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
    classname: 'ddsmoothmenu', //class added to menu's outer DIV
    //customtheme: ["#1c5a80", "#18374a"],
    contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!-- lightbox Thum -->

<script>
$(document).ready(function(){
    $("#disapproval_remark").hide();
    $(".dose_status").change(function(){
    var approval =$(this).val();
    
    if(approval =="N"){
        $("#disapproval_remark").show();
    }else{
        $("#disapproval_remark").hide();
    } 
});
$('#disapproval').hide();

$('#disapprove').click(function(){
//alert('disapprove');
        $('#disapproval').show();
      });
      $('#approve').click(function(){
//alert('disapprove');
        $('#disapproval').hide();
      });
});


</script>

<?php
$sql3 = "SELECT visitor_approval FROM visitor_directory where visitor_id='$id'";
$result3 = $conn ->query($sql3);
if($row3 = $result3->fetch_assoc())
{
$approved = filter($row3['visitor_approval']);
}
?>
<script>
var approv = '<?php echo $approved; ?>';
$(document).ready(function(){
 if(approv == 'D' || approv == 'U')
 {
 $('#disapproval').show();
 }
});
</script>

<script>
$(document).ready(function(){
$('#reg_disapprove').hide();
$('#regdisapprove').click(function(){
        $('#reg_disapprove').show();
});
$('#regapprove').click(function(){
        $('#reg_disapprove').hide();
});
});

$(document).ready(function(){
      
    $("#category").on("change",function(){
        var val = $(this).val();

        if(val=="INTL"){
        $("#email_div").show();
        $("#pan_number_div").hide();
        }else{
        $("#pan_number_div").show();
        $("#email_div").hide();

        }
    });
});
</script>
<script>
    function imageAppear(id) { 
    document.getElementById(id).style.visibility = "visible";
    document.getElementById(id).style.height = "200px";
    document.getElementById(id).style.width = "auto";
    }
    function imageDisappear(id) { 
    document.getElementById(id).style.visibility = "hidden";}
</script>
<?php
$sqlreg1 = "SELECT approval_status FROM registration_master where id='$registration_id'";
$res = $conn ->query($sqlreg1);
if($vals = $res->fetch_assoc())
{
$reg_approved = $vals['approval_status'];
}
?>
<script>
var reg_approv = '<?php echo $reg_approved; ?>';
$(document).ready(function(){
 if(reg_approv == 'D')
 {
 $('#reg_disapprove').show();
 }
});
</script>

<style type="text/css">
.style1 {color: #FF0000}
.style2 {
    font-size: 16px;
    font-weight: bold;
}
<?php if($_REQUEST['action']=='view') { ?>
#search{display:block;}
#page_ids{display:block;}
<?php  } else { ?>
#search{display:none;}
#page_ids{display:none;}
<?php } ?>

.blah{
    width: 100px;
    height: 100px;
}
.content_head{height: auto;}
.fancybox-button--zoom,.fancybox-button--play,.fancybox-button--thumbs,.fancybox-button--arrow_left,.fancybox-button--arrow_right,.fancybox-infobar{display:none!important;}
</style>
<style type="text/css">

.inner {/*  border: 1px solid #ccc;
*/
    border: 1px solid #ccc;
    border-collapse: separate;
    margin: 0;
    padding: 0;
    background: white;
    width: 50%;
    table-layout: fixed;
}
.inner tr {
background: #f8f8f8;
border: 1px solid #ddd;
padding: .35em;
}
.inner th,
.inner td {padding: .625em;text-align: left;padding: 10px 20px;}
.inner th {font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;}

</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
    <div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
    <div class="breadcome"><a href="admin.php">Home</a>
    <?php if($_REQUEST['actions']=='companyedit'){ ?> Covid details
    <?php } else { ?>/ COVID Vaccination Certificate <?php } ?></div>
</div>

<div id="main">
    <div class="content">
    
    <div class="content_head">
        <div style="float: left;">Manage COVID Vaccination Certificate </div>
        <!--<div style="float: right;">
        <a href="https://gjepc.org/admin/upload_vaccination_certificate.php?action=view">Upload Domestic VC</a>&nbsp;&nbsp;|
        <a href="export_domestic_vaccination_report.php">Download Domestic VC Report</a>&nbsp;&nbsp;|
        <a href="export_domestic_pending_disap_vc_report.php">Download Domestic PENDING/DISAPPROVED VC Report</a>&nbsp;|
        <a href="export_domestic_vc_notApplied.php">Download Domestic VC Report Not Apply</a>&nbsp;
        <br/>
        <a href="export_intl_vaccination_report.php">Download INTL vaccination report</a>&nbsp;&nbsp;|
        <br/>
        <a href="export_agnecy_vaccination_report.php">Download Agency vaccination report</a>&nbsp;&nbsp;|
        <a href="export_agency_pending_vaccination_report.php">Download Agency Pending vaccination report</a>&nbsp;&nbsp;|
        <br/>
        <a href="export_exhibitor_vaccination_report.php">Download Exhibitor vaccination report</a>&nbsp;&nbsp;|
        <a href="export_exhibitor_pending_vaccination_report.php">Download Exhibitor Pending vaccination report</a>
        </div>-->
        <?php if($_REQUEST['action']=='covidApproval'){ ?>
        <div class="content_head_button" style="float: right;" >
            <a href="manage_covid_report.php?action=view">Back</a>
        </div> 
        <?php } ?>
        <div class="clear"></div>
    </div>
    
<?php if($_REQUEST['action']=='view') { ?>
<div class="content_details1">
<?php 
    $sql5 = "select * from visitor_lab_info where status='1' ";
    $result5 = $conn ->query($sql5);
    $total_application= $result5->num_rows;
    
    $total_approve=0;
    $total_pending=0;
    $total_disapprove=0;
    $total_updated=0;
    while($rows5 = $result5->fetch_assoc())
    {
        if($rows5['approval_status']=='Y')
        {
            $total_approve=$total_approve+1;
        }else if($rows5['approval_status']=='P')
        {
            $total_pending=$total_pending+1;
        }else if($rows5['approval_status']=='N')
        {
            $total_disapprove=$total_disapprove+1;
        }else if($rows5['approval_status']=='U')
        {
            $total_updated=$total_updated+1;
        }
    }   
?>
          <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
            <tr class="orange1">
              <td colspan="11">Report Summary</td>
            </tr>
            <tr>
              <td><strong>Total Application</strong></td>
              <td><strong>Approve Application</strong></td>
              <td><strong>Disapprove Application</strong></td>
              <td><strong>Pending Application</strong></td>
              <td><strong>Updated Application</strong></td>
            </tr>
            <tr>
              <td><?php echo $total_application;?></td>
              <td><?php echo $total_approve;?></td>
              <td><?php echo $total_disapprove;?></td>
              <td><?php echo $total_pending;?></td>
              <td><?php echo $total_updated;?></td>
            </tr>
        </table>
      </div>
<?php } ?>


<div class="content_details1" id="search">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
 <tr>
<td><strong>Category</strong></td>        
    <td>
        <select name="category" id="category" class="input_txt-select">
        <option value="">Select Category</option>
        <option value="VIS" <?php if($_SESSION['category']=='VIS'){echo "selected='selected'";}?>>Domestic Visitor</option>
        <option value="INTL" <?php if($_SESSION['category']=='INTL'){echo "selected='selected'";}?>>International Visitor</option>
        <option value="EXH" <?php if($_SESSION['category']=='EXH'){echo "selected='selected'";}?>>Exhibitor</option>
        <option value="EXHM" <?php if($_SESSION['category']=='EXHM'){echo "selected='selected'";}?>>Machinery Exhibitor</option>
        <option value="CONTR" <?php if($_SESSION['category']=='CONTR'){echo "selected='selected'";}?>>Contractor/Agency</option>
        <option value="IGJME" <?php if($_SESSION['category']=='IGJME'){echo "selected='selected'";}?>>IGJME</option>
        </select>
    </td>
</tr>
<tr id="pan_number_div">
  <td><strong>PAN Number</strong></td>
  <td><input type="text" name="pan_no" id="pan_no" maxlength="10" class="input_txt" value="<?php echo $_SESSION['pan_no'];?>" autocomplete="off"/></td>
</tr>
<tr id="email_div">
  <td><strong>Email Id</strong></td>
  <td><input type="text" name="email" id="email"  class="input_txt" value="<?php echo $_SESSION['email'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Mobile Number</strong></td>
  <td><input type="text" name="mobile" id="mobile" class="input_txt" value="<?php echo $_SESSION['mobile'];?>" autocomplete="off"/></td>
</tr>
<tr>
<td><strong>Vaccine Dose</strong></td>        
    <td>
        <select name="certificate" class="input_txt-select">
        <option value="">Select Vaccine Dose</option>
        <option value="dose1" <?php if($_SESSION['certificate']=='dose1'){echo "selected='selected'";}?>>First Dose</option>
        <option value="dose2" <?php if($_SESSION['certificate']=='dose2'){echo "selected='selected'";}?>>Second Dose</option>
        <option value="booster_dose" <?php if($_SESSION['certificate']=='booster_dose'){echo "selected='selected'";}?>>Booster Dose</option>
        </select>
    </td>
</tr>
<tr>
<td><strong>Approve/ Disapprove</strong></td>        
    <td>
        <select name="visitor_approval" class="input_txt-select">
        <option value="">Select Status</option>
        <option value="P" <?php if($_SESSION['visitor_approval']=='P'){echo "selected='selected'";}?>>Pending</option>
        <option value="Y" <?php if($_SESSION['visitor_approval']=='Y'){echo "selected='selected'";}?>>Approved</option>
        <option value="N" <?php if($_SESSION['visitor_approval']=='N'){echo "selected='selected'";}?>>Disapproved</option>
        <option value="U" <?php if($_SESSION['visitor_approval']=='U'){echo "selected='selected'";}?>>Updated</option>
        </select>
    </td>
</tr>

<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>   
</table>
</form>      
</div>

<!------------------------------- ORDER DIRECTORY ---------------------------------->

<?php if($_REQUEST['action']=='view') { ?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Company Name</td>
    <td>Visitor Name</td>
    <td>Pan Number</td>
    <td>Mobile Number</td>
    <td>Certificate</td>
    <!--<td>Event</td>-->
    <td>Type</td>
    <td>Date</td>
    <td>Modified Date</td>
    <td>View Report</td>
    <td>Status</td>
    <?php if($_SESSION['curruser_login_id']=='1' || $_SESSION['curruser_login_id']=='28' || $_SESSION['curruser_login_id']=='37' || $_SESSION['curruser_login_id']=='176' || $_SESSION['curruser_login_id']=='55' || $_SESSION['curruser_login_id']=='195' || $_SESSION['curruser_login_id']=='98'){ ?><td>Delete</td><?php } ?>
  </tr>
    <?php  
    $page=1;//Default page
    $limit=25;//Records per page
    $start=0;//starts displaying records from 0
    if(isset($_GET['page']) && $_GET['page']!=''){
    $page=$_GET['page'];    
    }
    $start=($page-1)*$limit;
  
    $sql="SELECT * FROM visitor_lab_info WHERE 1";

    if($_SESSION['pan_no']!="")
    {
    $sql.=" and pan_no like '%".$_SESSION['pan_no']."%'";
    }
    if($_SESSION['email']!="")
    {
    //$visitor_id = getVisIdFromEmail($_SESSION['email'],$conn);
    $sql.=" and email like '%".$_SESSION['email']."%'";
    //$sql.=" and visitor_id = '$visitor_id'";
    }
    if($_SESSION['category']!="")
    {
        if($_SESSION['category']=="VIS"){
        $sql.=" and category_for = '".$_SESSION['category']."'";
        $sql.=" AND visitor_id IN 
        (SELECT o.visitor_id FROM visitor_order_history o, visitor_lab_info l where o.visitor_id=l.visitor_id AND (o.`show`='iijs22' || o.`show`='signature23' || o.`show`='iijstritiya23' || o.`show`='combo23'))";
        /*$sql.=" AND category_for = '".$_SESSION['category']."' AND l.visitor_id IN (
        SELECT visitor_id FROM visitor_order_history o, visitor_lab_info l o.visitor_id=l.visitor_id AND `show`='signature22')";*/
        } else {
        $sql.=" and category_for = '".$_SESSION['category']."'";
        }
    }
    if($_SESSION['mobile']!="")
    {
    $sql.=" and mobile_no like '%".$_SESSION['mobile']."%'";
    }

    if($_SESSION['visitor_approval']!="")
    { 
    $sql.=" and approval_status = '".$_SESSION['visitor_approval']."'";
    }

    if($_SESSION['certificate']!="")
    { 
    $sql.=" and certificate = '".$_SESSION['certificate']."'";
    }  
 //  echo '-'.$sql;
    $result = $conn ->query($sql);

    $rCount = $result->num_rows;
     $sql1= $sql." order by modified_at desc limit $start, $limit ";
    $result1= $conn ->query($sql1);
        
  if($rCount>0)
  { 
  while($rows = $result1->fetch_assoc())
  {
    if($rows['category_for'] =='CONTR'){
        $company_name = getAgencyName($rows['registration_id'], $conn);
    }else if($rows['category_for'] =='VIS' || $rows['category_for'] =='IGJME' || $rows['category_for'] =='INTL' || $rows['category_for'] =='EXH' || $rows['category_for'] =='EXHM' ){
        $company_name = getCompanyNameFromregistration($rows['registration_id'], $conn);
    }else{
        $company_name = "";
    }

    if($rows['category_for'] =='CONTR'){
        $visitor_name = getAgencyVisitorName($rows['visitor_id'], $conn);
        $pan_no = $rows['pan_no'];
        $mobile_no = $rows['mobile_no'];
    }else if($rows['category_for'] =='VIS'){
        $visitor_name = VisitorName($rows['visitor_id'], $conn);
        $pan_no = $rows['pan_no'];
        $mobile_no = $rows['mobile_no'];
    }else if($rows['category_for'] =='IGJME'){
        $visitor_name = VisitorName($rows['visitor_id'], $conn);
        $pan_no = $rows['pan_no'];
        $mobile_no = $rows['mobile_no'];
    }else if($rows['category_for'] =='EXH'){
        $visitor_name = ExhbitorName($rows['visitor_id'],$conn);
        $pan_no = $rows['pan_no'];
        $mobile_no = $rows['mobile_no'];
    }else if($rows['category_for'] =='EXHM'){
        $visitor_name = ExhbitorNameEXHM($rows['visitor_id'],$conn);
        $pan_no = $rows['pan_no'];
        $mobile_no = $rows['mobile_no'];
    }else if( $rows['category_for'] =='INTL'){
        $pan_no = "";
        $visitor_name = intlVisitorName($rows['visitor_id'], $conn);
        $mobile_no = intlVisitorMobile($rows['visitor_id'], $conn);
    }
    $certificate = $rows['certificate'];
    if($certificate == "dose1"){
       $certificate = "1st Dose";
    }elseif($certificate == "dose2"){
        $certificate = "2nd Dose";
    }elseif($certificate == "booster_dose"){
        $certificate = "Booster Dose";
    }
     
     $event = getVisEventName($rows['event'],$conn);
     
  ?>

  <tr>
    <td><?php echo strtoupper($company_name);?></td>
    <td><?php echo strtoupper($visitor_name);?></td>
    <td><?php echo filter($pan_no);?></td>
    <td><?php echo filter($mobile_no);?></td>   
    <td><?php echo filter($certificate);?></td>   
    <!--<td><?php echo $event;?></td>-->
    <td><?php echo $rows['category_for'];?></td>   
    <td><?php echo $rows['create_date'];?></td>   
    <td><?php echo $rows['modified_at'];?></td>   
   
    <td align="center" valign="middle">
        <a href="manage_covid_report.php?action=covidApproval&lab_report_id=<?php echo $rows['id'];?>">
        <img class="icons" src="images/view.png" title="Report Details / Approval" border="0" /></a>
    </td>
    <td>
    <?php
    if($rows['approval_status']=="") 
                echo "<img src='images/notification-exclamation.gif' border='0' />";    
            elseif($rows['approval_status']=="Y")
                echo "<img src='images/yes.gif' border='0' />"; 
            elseif($rows['approval_status']=="N")
                echo "<img src='images/no.gif' border='0' />";
            elseif($rows['approval_status']=="U")
                echo "<img src='images/update_icon.png' width='20' border='0' title='pending' />";
            elseif($rows['approval_status']=="P")
                echo "<img src='images/notification-exclamation.gif' width='20' border='0' title='pending' />";     
    ?>
    </td>
    <?php if($_SESSION['curruser_login_id']=='91' || $_SESSION['curruser_login_id']=='1' || $_SESSION['curruser_login_id']=='28' || $_SESSION['curruser_login_id']=='37' || $_SESSION['curruser_login_id']=='44' || $_SESSION['curruser_login_id']=='176' || $_SESSION['curruser_login_id']=='123' || $_SESSION['curruser_login_id']=='55' || $_SESSION['curruser_login_id']=='195' || $_SESSION['curruser_login_id']=='98'){ ?>
    <td><a href="manage_covid_report.php?action=deleteInfo&id=<?php echo $rows['id'];?>" onClick="return(window.confirm('Are you sure you want to Delete.'));"><img src="images/no.gif" title="DELETE" border="0" width="15" height="15" /></a></td>
    <?php } ?>
   
  </tr>
  <?php
   $i++;
   } 
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }      ?>
</table>
</form>
</div>
<?php } ?>  
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
<div class="pages_1" id="page_ids">Total Number Company : <?php echo $rCount;?>
<?php echo pagination($limit,$page,'manage_covid_report.php?action=view&page=',$rCount); //call function to show pagination?>
</div>  

<!------------------------------- VIEW REGISTRATION ---------------------------------->
<!------------------------ UPDATE FOR EMPLOYEE DIRECTORY ------------------------------->
  
<?php    
if(($_REQUEST['action']=='covidApproval'))
{
  $action='updateApproval';
  if(($_REQUEST['lab_report_id']!=''))
  {
    $lab_report_id =$_REQUEST['lab_report_id']; 
        
        $result2 = $conn ->query("SELECT * FROM visitor_lab_info where id='$lab_report_id'");
        if($row2 = $result2->fetch_assoc())
        {           
            if($row2['category_for'] =='CONTR'){
                    $visitor_name = getAgencyVisitorName($row2['visitor_id'], $conn);
                }else if($row2['category_for'] =='VIS'){
                    $visitor_name = VisitorName($row2['visitor_id'], $conn);
                }else if( $row2['category_for'] =='EXH'){
                    $visitor_name = "";
                }else if( $row2['category_for'] =='EXHM'){
                    $visitor_name = "";
                }else if( $row2['category_for'] =='INTL'){
                    $visitor_name = "";
                }
                
            if($row2['category_for'] =='CONTR'){
                 $company_name = getAgencyName($row2['registration_id'], $conn);
            }else if($row2['category_for'] =='VIS' || $row2['category_for'] =='IGJME' || $row2['category_for'] =='INTL' ){
                $company_name = getCompanyNameFromregistration($row2['registration_id'], $conn);
            }else{
                $company_name = "";
            }

            switch ($row2['category_for']) {
                case 'CONTR':
                    $visitor_name = getAgencyVisitorName($row2['visitor_id'], $conn);
                    $company_name = getAgencyName($row2['registration_id'], $conn);
                
                    $dose1_certificate = "https://registration.gjepc.org/images/covid/contr/".$row2['registration_id']."/vaccine_certificate/".$row2['dose1']."";
                    $dose2_certificate = "https://registration.gjepc.org/images/covid/contr/".$row2['registration_id']."/vaccine_certificate/".$row2['dose2']."";
                    $booster_dose_certificate = "https://registration.gjepc.org/images/covid/contr/".$row2['registration_id']."/vaccine_certificate/".$row2['booster_dose']."";
                break;
                case 'EXH':
                    $visitor_name =  ExhbitorName($row2['visitor_id']);
                    $company_name = getCompanyNameFromregistration($row2['registration_id'], $conn);
                    $reportPath = "https://registration.gjepc.org/images/covid/exh/".$row2['registration_id']."/vaccine_certificate/".$attatchment."";
                    $dose1_certificate = "https://registration.gjepc.org/images/covid/exh/".$row2['registration_id']."/vaccine_certificate/".$row2['dose1']."";
                    $dose2_certificate = "https://registration.gjepc.org/images/covid/exh/".$row2['registration_id']."/vaccine_certificate/".$row2['dose2']."";
                    $booster_dose_certificate = "https://registration.gjepc.org/images/covid/exh/".$row2['registration_id']."/vaccine_certificate/".$row2['booster_dose']."";
                break;
				case 'EXHM': 
                    $visitor_name =  ExhbitorNameEXHM($row2['visitor_id']);
                    $company_name = getCompanyNameFromregistration($row2['registration_id'], $conn);
                    $reportPath = "https://gjepc.org/igjme/manual/images/covid/exhm/".$row2['registration_id']."/vaccine_certificate/".$attatchment."";
                    $dose1_certificate = "https://gjepc.org/igjme/manual/images/covid/exhm/".$row2['registration_id']."/vaccine_certificate/".$row2['dose1']."";
                    $dose2_certificate = "https://gjepc.org/igjme/manual/images/covid/exhm/".$row2['registration_id']."/vaccine_certificate/".$row2['dose2']."";
                    $booster_dose_certificate = "https://gjepc.org/igjme/manual/images/covid/exhm/".$row2['registration_id']."/vaccine_certificate/".$row2['booster_dose']."";
                break;
                case 'VIS':
                    $visitor_name = VisitorName($row2['visitor_id'], $conn);
                    $company_name = getCompanyNameFromregistration($row2['registration_id'], $conn);
                    $reportPath = "https://registration.gjepc.org/images/covid/vis/".$row2['registration_id']."/vaccine_certificate/".$attatchment."";
                    $dose1_certificate = "https://registration.gjepc.org/images/covid/vis/".$row2['registration_id']."/vaccine_certificate/".$row2['dose1']."";
                    $dose2_certificate = "https://registration.gjepc.org/images/covid/vis/".$row2['registration_id']."/vaccine_certificate/".$row2['dose2']."";
                    $booster_dose_certificate = "https://registration.gjepc.org/images/covid/vis/".$row2['registration_id']."/vaccine_certificate/".$row2['booster_dose']."";
                break;
                case 'IGJME':
                    $visitor_name = VisitorName($row2['visitor_id'], $conn);
                    $company_name = getCompanyNameFromregistration($row2['registration_id'], $conn);
                    $reportPath = "https://registration.gjepc.org/images/covid/vis/".$row2['registration_id']."/vaccine_certificate/".$attatchment."";
                    $dose1_certificate = "https://registration.gjepc.org/images/covid/vis/".$row2['registration_id']."/vaccine_certificate/".$row2['dose1']."";
                    $dose2_certificate = "https://registration.gjepc.org/images/covid/vis/".$row2['registration_id']."/vaccine_certificate/".$row2['dose2']."";
                    $booster_dose_certificate = "https://registration.gjepc.org/images/covid/vis/".$row2['registration_id']."/vaccine_certificate/".$row2['booster_dose']."";
                break;
                case 'INTL':
                    $visitor_name = intlVisitorName($row2['visitor_id'], $conn);
                    $company_name = getCompanyNameFromregistration($row2['registration_id'], $conn);
                    $dose1_certificate = "https://registration.gjepc.org/images/covid/intl/".$row2['registration_id']."/vaccine_certificate/".$row2['dose1']."";
                    $dose2_certificate = "https://registration.gjepc.org/images/covid/intl/".$row2['registration_id']."/vaccine_certificate/".$row2['dose2']."";
                    $booster_dose_certificate = "https://registration.gjepc.org/images/covid/intl/".$row2['registration_id']."/vaccine_certificate/".$row2['booster_dose']."";
                break;
                
                default :
                    $dose1_certificate = "";
                    $dose2_certificate ="";
                    $booster_dose_certificate ="";
                    $visitor_name = "";
                    $company_name = "";
                    $reportPath = "";
                break;
            }
            $mobile_no  =   filter($row2['mobile_no']);
            $pan_no =   filter($row2['pan_no']);
            $approval_status    =   filter($row2['approval_status']);
            $self_report    =   filter($row2['self_report']);
            $registration_id    =   filter($row2['registration_id']);
            $certificate = filter($row2['certificate']);
            $dose1_status = filter($row2['dose1_status']);
            $dose2_status = filter($row2['dose2_status']);
            $booster_dose_status = filter($row2['booster_dose_status']);
            $dose1_ext = pathinfo($row2['dose1'], PATHINFO_EXTENSION);
            $dose2_ext = pathinfo($row2['dose2'], PATHINFO_EXTENSION);
            $booster_dose_ext = pathinfo($row2['booster_dose'], PATHINFO_EXTENSION);
            $remark = filter($row2['remark']);
            
        }
    }
?>

<div class="content_details1">
<form name="details" action="" method="post" >          
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
     <td colspan="11">Report Details</td>
  </tr>
  <tr>
    <td ><strong>Company Name</strong></td>
    <td> <?php echo $company_name;?></td>
  </tr>
  <tr>
    <td ><strong>Visitor Name</strong></td>
    <td><?php echo strtoupper($visitor_name);?></td>
  </tr>
 <tr>
    <td ><strong>Latest Uploaded Certificate</strong></td>
    <td><?php if($certificate =='dose1'){ echo "1st Dose Certificate";}else{ echo "2nd Dose Certificate"; }?></td>
  </tr>
  <tr>
    <td ><strong>1st Dose Certificate</strong></td>
    <td>  
        <select name="dose1_status" class="input_txt dose_status" id="dose1_status">
          <option value="">Select 1st Dose Status</option>
          <option value="P" <?php if($dose1_status=='P' || $dose1_status=='U'){echo "selected='selected'";}?>>Pending</option>
          <option value="Y" <?php if($dose1_status=='Y'){echo "selected='selected'";}?>>Approve</option>   
          <option value="N" <?php if($dose1_status=='N'){echo "selected='selected'";}?>>Disapprove</option>  
        </select>
        <?php if($row2['dose1'] !=""){ ?>           
           <a <?php if($dose1_ext =="pdf" || $dose1_ext =="PDF"){?> <?php }else{?> data-fancybox="gallery" <?php }?>  href="<?php echo $dose1_certificate;?>" target="_blank">View Report</a>
        <?php } else {
            echo "Not Uploaded";
        } ?>
        <br>
        <?php if($dose1_status =="N"){echo $remark;}?>       
    </td>
  </tr>
  
  <tr>
    <td><strong>2st Dose Certificate</strong></td>
    <td>  
        <select name="dose2_status" class="input_txt dose_status" id="dose2_status" >   
          <option value="">Select 2nd Dose Status</option>
          <option value="P" <?php if($dose2_status=='P' || $dose2_status=='U'){echo "selected='selected'";}?>>Pending</option>
          <option value="Y" <?php if($dose2_status=='Y'){echo "selected='selected'";}?>>Approve</option>   
          <option value="N" <?php if($dose2_status=='N'){echo "selected='selected'";}?>>Disapprove</option>  
        </select>
        <?php if($row2['dose2'] !=""){ ?>
           <a <?php if($dose2_ext =="pdf" || $dose2_ext =="PDF"){?> <?php }else{?> data-fancybox="gallery" <?php }?> href="<?php echo $dose2_certificate;?>" target="_blank">View Report</a>
        <?php } else {
            echo "Not Uploaded";
        } ?> <br>
        <?php if($dose2_status =="N"){ echo $remark; }?>       
    </td>
  </tr>
<tr>
    <td>
        <strong>Booster Dose Certificate</strong>
    </td>
    <td>  
        <input type="hidden" name="booster_dose_status" value="P">
        <select name="booster_dose_status" class="input_txt dose_status" id="booster_dose_status" >   
          <option value="">Select Booster Dose Status</option>
          <option value="P" <?php if($booster_dose_status=='P' || $booster_dose_status=='U'){echo "selected='selected'";}?>>Pending</option>
          <option value="Y" <?php if($booster_dose_status=='Y'){echo "selected='selected'";}?>>Approve</option>   
          <option value="N" <?php if($booster_dose_status=='N'){echo "selected='selected'";}?>>Disapprove</option>  
        </select>
        <?php if($row2['booster_dose'] !=""){?>
           <a <?php if($booster_dose_ext =="pdf" || $booster_dose_ext =="PDF"){?> <?php }else{?> data-fancybox="gallery" <?php }?> href="<?php echo        $booster_dose_certificate;?>" target="_blank">View Report</a>
        <?php } else {
           // echo "Not Uploaded";
        } ?> <br>
        <?php if($booster_dose_status =="N"){echo $remark;}?>       
    </td>
</tr>
  
  <tr id="disapproval_remark">
  <td><strong>Remark:</strong></td>
  <td><textarea type="text" name="remark"  id="remark" rows="5" class="input_txt">Invalid certificate</textarea></td>
</tr>
  <tr >
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $lab_report_id;?>" />
    <input type="hidden" name="regid"   value="<?php echo $registration_id;?>" />
    </td>
  </tr>
</table>
</form> 
</div>
<?php } ?>     

<!----------------------- Company Edits ---------------------------->
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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

<style>
.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4);    
}
@keyframes modalFade {
  from {transform: translateY(-50%);opacity: 0;}
  to {transform: translateY(0);opacity: 1;}
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
     animation-name: modalFade;
  animation-duration: .6s;
}
.modal_inner_content{margin: 20px 10px;}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.form-horizontal{border: 1px solid #ccc;padding: 25px;margin-top: 10px;}
.form-control{width: 100%;margin-bottom: 15px;}
.form-control label{width: 150px;display: inline-block;}
.form-control input{width: auto;}
</style>
</body>
</html>