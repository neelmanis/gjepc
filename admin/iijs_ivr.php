<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
?>
<?php
$shortcode = $_REQUEST['shortcode'];
if($shortcode =="signature22"){
  $trade_show = "IIJS SIGNATURE 2022";
}else if($shortcode =="iijs21"){
  $trade_show = "IIJS 2021";
}else{
  $trade_show = $shortcode;
}
$showInfo = $conn->query("SELECT * FROM visitor_event_master WHERE `shortcode`='$shortcode'");
$showInfoResult = $showInfo->fetch_assoc();
$show_name = $showInfoResult['event_name'];

if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['first_name']="";
  $_SESSION['last_name']="";
  $_SESSION['company_name']="";
  $_SESSION['email']="";
  $_SESSION['from_date']="";
    $_SESSION['to_date']="";
    $_SESSION['country']="";
    $_SESSION['status']="";
  $_SESSION['visitor_approval'] = "";
  $_SESSION['SHOW'] = "";
  
  
  header("Location: iijs_ivr.php?action=view");
  
} else
{ 
    $search_type=$_REQUEST['search_type'];
    if($search_type=="SEARCH")
  { 
    $_SESSION['first_name']=$_REQUEST['first_name'];
    $_SESSION['last_name']=$_REQUEST['last_name'];
    $_SESSION['company_name']= filter($_REQUEST['company_name']);
    $_SESSION['email']=$_REQUEST['email'];
    $_SESSION['from_date']=$_REQUEST['from_date'];
    $_SESSION['to_date']=$_REQUEST['to_date'];
    $_SESSION['country']=$_REQUEST['country'];
    $_SESSION['status']=$_REQUEST['status'];
    $_SESSION['visitor_approval'] = $_REQUEST['visitor_approval'];
    $_SESSION['SHOW'] = $_REQUEST['SHOW'];
  }
if($search_type=='SEARCH')
{
if($_SESSION['first_name']=="" && $_SESSION['company_name']=="" && $_SESSION['from_date']=="Form" && $_SESSION['to_date']=="To" && $_SESSION['country']=="" && $_SESSION['status']=="" && $_SESSION['SHOW'] =="")
{
$_SESSION['error_msg']="Please fill atleast one field to search";
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

<?php
if(($_REQUEST['action']=='delVisitor') && ($_REQUEST['visitor_id']!='') && ($_REQUEST['registration_id']!=''))
{ 
	//echo '<pre>'; print_r($_REQUEST); exit;
	$visitor_id = filter($_REQUEST['visitor_id']);	
	$registration_id  = filter(intval($_REQUEST['registration_id']));
	
	$sqlPaymentCheck = "SELECT * FROM ivr_registration_history WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND status='1' AND payment_status='Y' AND ( `show`='iijs22' )";
    $resultPaymentCheck = $conn->query($sqlPaymentCheck);
    $countPaymentCheck = $resultPaymentCheck->num_rows;
    if($countPaymentCheck > 0 ){
	echo "<script> alert('Visitor is Already Registered for Current Show');</script>";
	echo "<meta http-equiv=refresh content=\"0;url=iijs_ivr.php?action=employeesList&registration_id=$registration_id\">"; exit;
	} else {
    $ssx = "INSERT INTO ivr_registration_details_deleted
		SELECT * FROM  ivr_registration_details WHERE eid = $visitor_id AND `uid`='$registration_id'";
	$queryData = $conn->query($ssx);
	
	$ssy = "INSERT INTO visitor_lab_info_log SELECT * FROM visitor_lab_info WHERE visitor_id = '$visitor_id' AND `registration_id`='$registration_id'";
	$queryDatas = $conn->query($ssy);
	if($queryDatas){
	$deletxy = "DELETE FROM `visitor_lab_info` WHERE visitor_id = $visitor_id AND `registration_id`='$registration_id' limit 1";
	$resultxy = $conn->query($deletxy);
	}
	
	if($queryData){
	$deletx = "DELETE FROM `ivr_registration_details` WHERE `uid`='$registration_id' AND `eid` ='$visitor_id' limit 1"; 
	$resultx = $conn->query($deletx);
	if($resultx){
	$updatx = "UPDATE `ivr_registration_details_deleted` SET `admin_delete_id` = '$adminID' WHERE `uid`='$registration_id' AND `eid` ='$visitor_id' limit 1"; 
	$updatx = $conn->query($updatx);
	echo "<script> alert('Deleted from Visitor directory');</script>";
	echo "<meta http-equiv=refresh content=\"0;url=iijs_ivr.php?action=employeesList&registration_id=$registration_id\">"; exit;
	}
	} else { die ($conn->error); }	
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS International Visitor Registration - <?php echo $show_name; ?></title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
  $('#popupDatepicker').datepick();
  $('#inlineDatepicker').datepick({onSelect: showDate});
  $('#popupDatepicker1').datepick();
  $('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
  alert('The date chosen is ' + date);}
</script>

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

<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $("div.fancyDemo a").fancybox();
    });
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
  <div class="breadcome"><a href="admin.php">Home</a> >IIJS IVR</div>
</div>

<div id="main">
  <div class="content">    
    <div class="content_head">
    <a href="iijs_ivr.php?action=view"><div class="content_head_button">Manage IIJS IVR</div></a> 
    <a href="iijs_ivr_onspot.php?action=view"><div class="content_head_button">Manage ONSPOT IIJS IVR</div></a> 
    <?php if(!empty($adminID)){ ?>
    <!--<a href="iijs_ivr_old_registration.php"><div class="content_head_button">IIJS IVR Old Registration</div> </a>-->
    <!--<a href="iijs_ivr_old_step.php?action=view"><div class="content_head_button">IIJS IVR Old Process Registration</div></a>-->
    <?php if($adminID!=198){ ?>
    <!--<div style="float:right; padding-right:10px; font-size:12px;"><a href="export_approve_iijs_ivr.php">&nbsp;Download Approved Data</a></div>
    <div style="float:right; padding-right:10px; font-size:12px;"><a href="export_disapprove_iijs_ivr.php">&nbsp;Download DisApproved Data</a></div>-->
    <div class="clear"></div>
    <!--<div style="float:right; padding-right:10px; font-size:12px;"><a href="export_iijs_ivr_vc.php">&nbsp;Download All Data with VC</a></div>-->
    <!--<div style="float:right; padding-right:10px; font-size:12px;"><a href="export_iijs_ivr.php">&nbsp;Download All Data without VC</a></div>-->
    <br/>
    <!--<div style="float:right; padding-right:10px; font-size:12px;"><a href="export_history_ivr_show.php">&nbsp;<u>Download PREMIERE 22 Registration</u></a></div>-->
    <?php } ?>
    <?php } ?>
    </div>

<?php if($_REQUEST['action'] == "view"){ ?>
<div class="content_details1">
<?php 
  $sql5="SELECT * FROM `ivr_registration_history` WHERE 1 AND `show` = 'signature23' AND `payment_status`='Y'";
  $result5=$conn ->query($sql5);
  $total_application=$result5->num_rows;
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
    <td>IIJS SIGNATURE 2023 Summary</td>
  </tr>
  <tr>
    <td><strong>Total Application</strong></td>
  </tr>
   <tr>
    <td><?php echo $total_application;?></td>
  </tr>
</table>
</div> 
<?php }?>
<div class="content_details1">
<?php 
  $sql5="SELECT * FROM  `ivr_registration_details` WHERE 1 ";
  $result5=$conn ->query($sql5);
  $total_application=$result5->num_rows;
  
  $total_approve=0;
  $total_pending=0;
  $total_disapprove=0;
  while($rows5=$result5->fetch_assoc())
  {
    if($rows5['application_approved']=='Y'  )
    {
      $total_approve=$total_approve+1;

    }else if($rows5['application_approved']=='P'  )
    {
      $total_pending=$total_pending+1;
      
    }else if($rows5['application_approved']=='N' )
    {
      $total_disapprove=$total_disapprove+1;
    }
  }
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
    <td colspan="11">Employee Directory Summary</td>
  </tr>
  <tr>
    <td><strong>Total Application</strong></td>
    <td><strong>Approve Application</strong></td>
    <td><strong>Disapprove Application</strong></td>
    <td><strong>Pending Application</strong></td>
  </tr>
   <tr>
    <td><?php echo $total_application;?></td>
    <td><?php echo $total_approve;?></td>
    <td><?php echo $total_disapprove;?></td>
    <td><?php echo $total_pending;?></td>
  </tr>
</table>
</div>      
<div class="clear"></div>
<?php if($_REQUEST['action'] == "view"  ){?>
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />          
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
    <td colspan="11" >Search Options</td>
  </tr>
  <!-- <tr>
    <td width="19%"><strong>First Name</strong></td>
    <td width="81%"><input type="text" name="first_name" id="first_name" class="input_txt" value="<?php echo $_SESSION['first_name'];?>" /></td>
  </tr>
  <tr>
    <td><strong>Last Name</strong></td>
    <td><input type="text" name="last_name" id="last_name" class="input_txt" value="<?php echo $_SESSION['last_name'];?>" /></td>
  </tr> -->
  <tr>
    <td><strong>Company Name</strong></td>
    <td><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" /></td>
  </tr>
  <tr>
    <td><strong>Email ID</strong></td>
    <td><input type="text" name="email" id="email" class="input_txt" value="<?php echo $_SESSION['email'];?>" /></td>
  </tr>

  <tr >
    <td><strong>Country</strong></td>
    <td><select name="country" id="country" class="input_txt">
      <option value="">Please Select Country Name</option>
      <?php 
        $sql2="select * from country_master where status=1";
        $result2=$conn ->query($sql2);
        while($rows2=$result2->fetch_assoc())
        {
        if($_SESSION['country_code']==$rows2['country_code'])
        {
        echo "<option value='$rows2[country_code]' selected='selected'>$rows2[country_name]</option>";
        }else
        {
        echo "<option value='$rows2[country_code]'>$rows2[country_name]</option>";
        }
        }
      ?>
      </select></td>
  </tr>
    <tr>
    <td><strong>Visitor Status</strong></td>        
        <td>
            <select name="visitor_approval" class="input_txt-select">
            <option value="">Select Status</option>
            <option value="P" <?php if($_SESSION['visitor_approval']=='P'){echo "selected='selected'";}?>>Pending</option>
            <option value="Y" <?php if($_SESSION['visitor_approval']=='Y'){echo "selected='selected'";}?>>Approved</option>
            <option value="N" <?php if($_SESSION['visitor_approval']=='N'){echo "selected='selected'";}?>>Disapproved</option>
          
            </select>
        </td>
    </tr>
    <tr>
    <td><strong>Show</strong></td>        
        <td>
            <select name="SHOW" class="input_txt-select">
            <option value="">Select Show</option>
            <!-- <option value="iijs22" <?php if($_SESSION['SHOW']=='iijs22'){echo "selected='selected'";}?>>IIJS PREMIERE 2022</option> -->
            <option value="signature23" <?php if($_SESSION['SHOW']=='signature23'){echo "selected='selected'";}?>>IIJS SIGNATURE 2023</option>
            </select>
        </td>
    </tr>
 
  <tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" />
      <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
  </tr>
</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="7%" height="10">#</td>
    
    <td width="24%">Company Name</td>
    <td width="17%" align="center">Email</td>
    <td width="20%">Country</td>
    <td width="20%">View Details</td>
    <td width="10%">Registration Under Signature Show</td>
   <!--  <td width="24%">Registration For Show</td> -->
    <td width="15%">Date</td>
    <td width="15%">Directory Status</td>
 
    
  </tr>
  <?php
  $counter = 1;
  $page=1;//Default page
  $limit=20;//Records per page
  $start=0;//starts displaying records from 0
  if(isset($_GET['page']) && $_GET['page']!=''){
  $page=$_GET['page'];
  
  }
  $start=($page-1)*$limit;

  //$sql="SELECT count(vd.uid) as total_persons,rm.id, rm.company_name, rm.email_id, rm.mobile_no,rm.approval_status,vd.uid,rm.country,vd.eid,vd.application_approved,vh.show FROM registration_master rm inner join ivr_registration_details vd on rm.id=vd.uid inner join ivr_registration_history vh on rm.id=vh.registration_id where rm.country!='IN' and vh.show='iijs22' ";
 /* $sql="SELECT count(vd.uid) as total_persons,rm.id,vh.payment_made_for,vh.create_date, rm.company_name, rm.email_id, rm.mobile_no,rm.approval_status,vd.uid,rm.country,vd.eid,vd.application_approved,vh.show FROM registration_master rm inner join ivr_registration_details vd on rm.id=vd.uid inner join ivr_registration_history vh on rm.id=vh.registration_id where rm.country!='IN'  "; Join table for show details*/
  $sql="SELECT count(vd.uid) as total_persons,rm.id,vd.trade_show,vh.payment_made_for,vd.modified_date as create_date, rm.company_name, rm.email_id, rm.mobile_no,rm.approval_status,vd.uid,rm.country,vd.eid,vd.application_approved,vh.show, vd.personal_info_approval,vd.photo_approval,vd.valid_passport_copy_approval,vd.visiting_card_approval,vd.nri_photo_approval FROM registration_master rm inner join ivr_registration_details vd on rm.id=vd.uid left join ivr_registration_history vh on rm.id=vh.registration_id where rm.country!='IN'  ";

  if($_SESSION['first_name']!="")
  {
  $sql.=" and vd.first_name like '%".$_SESSION['first_name']."%'";
  }
  
  if($_SESSION['last_name']!="")
  {
  $sql.=" and vd.last_name like '%".$_SESSION['last_name']."%'";
  }
  
  if($_SESSION['company_name']!="")
  {
  $sql.=" and rm.company_name like '%".$_SESSION['company_name']."%'";
  }
  
  if($_SESSION['email']!="")
  {
  $sql.=" and rm.email_id like '%".$_SESSION['email']."%'";
  }
  
  if($_SESSION['country']!="")
  {
  $sql.=" and rm.country='".$_SESSION['country']."'";
  }
   if($_SESSION['visitor_approval']!="")
  { 
    if($_SESSION['visitor_approval']=="P"){

        $sql.=" and ( vd.personal_info_approval = '".$_SESSION['visitor_approval']."' or vd.photo_approval = '".$_SESSION['visitor_approval']."'
      or vd.valid_passport_copy_approval = '".$_SESSION['visitor_approval']."' or vd.visiting_card_approval = '".$_SESSION['visitor_approval']."' or vd.nri_photo_approval = '".$_SESSION['visitor_approval']."') ";
    
    } if($_SESSION['visitor_approval']=="Y"){
        $sql.=" and ( vd.personal_info_approval = '".$_SESSION['visitor_approval']."' and vd.photo_approval = '".$_SESSION['visitor_approval']."'
      and vd.valid_passport_copy_approval = '".$_SESSION['visitor_approval']."' and vd.visiting_card_approval = '".$_SESSION['visitor_approval']."' and vd.nri_photo_approval = '".$_SESSION['visitor_approval']."' ) ";

    } if($_SESSION['visitor_approval']=="N") {

      $sql.=" and ( vd.personal_info_approval = '".$_SESSION['visitor_approval']."' and vd.photo_approval = '".$_SESSION['visitor_approval']."'
      and vd.valid_passport_copy_approval = '".$_SESSION['visitor_approval']."' and vd.visiting_card_approval = '".$_SESSION['visitor_approval']."' and vd.nri_photo_approval = '".$_SESSION['visitor_approval']."' ) ";

    }
    
  }


  //    if($_SESSION['visitor_approval']!="")
  // { 
  //     $sql.=" and vd.application_approved='".$_SESSION['visitor_approval']."'";
  
    
  // }

  if($_SESSION['SHOW']!="")
  {
    $sql.=" and `vh`.`show` like '%".$_SESSION['SHOW']."%'";
  }
  
   
  $sql.=" GROUP BY rm.id ORDER BY vh.create_date desc "; 
  $sql;
  $result=$conn ->query($sql);

  $rCount=$result->num_rows;
  $sql1= $sql."  limit $start, $limit";
  $result1=$conn ->query($sql1);
  
if($rCount>0)
  { 
  while($rows=$result1->fetch_assoc())
  {
    $date = $rows['create_date'] != '' &&   $rows['create_date'] != null ? $date =  $rows['create_date'] : '';
  ?>
  <tr>
    <?php //echo "<pre>";print_r($rows);?>
    <td><?php echo $counter++ ;?></td>
   
    <td><?php echo strtoupper(filter($rows['company_name']));?></td>
    <td><?php echo $rows['email_id'];?></td>
    <td><?php echo getCountryName($rows['country'],$conn);?></td>
    <td> <a href="iijs_ivr.php?action=employeesList&registration_id=<?php echo $rows['uid'];?>">View directory  </a> / <a href="iijs_ivr.php?action=ordersList&registration_id=<?php echo $rows['uid'];?>"> order history  </a></td>
    <td> <?php if($rows['payment_made_for'] =="signature23"){ echo "IIJS SIGNATURE 2023"; }else{ echo ""; } ?> </td>
    <!-- <td><?php //echo strtoupper(filter($rows['trade_show']));?></td> -->
    <td> <?php echo date("Y-m-d", strtotime($date)); ?> </td>
    <td>
    <?php 
    if($rows['application_approved'] =="P" || $rows['personal_info_approval']=="P" || $rows['photo_approval']=="P" || $rows['valid_passport_copy_approval']=="P" || $rows['visiting_card_approval']=="P" || $rows['nri_photo_approval']=="P" ){
      echo "Pending"; 
    }else if($rows['application_approved'] =="Y" && $rows['personal_info_approval']=="Y" && $rows['photo_approval']=="Y" && $rows['valid_passport_copy_approval']=="Y" && $rows['visiting_card_approval']=="Y" && $rows['nri_photo_approval']=="Y"){ 
      echo "Approved";
    } else if($rows['application_approved'] =="N" || $rows['personal_info_approval']=="N" || $rows['photo_approval']=="N" || $rows['valid_passport_copy_approval']=="N" || $rows['visiting_card_approval']=="N" || $rows['nri_photo_approval']=="N"){ 
      echo "Disapproved"; 
    } 
    ?></td> 
    <!-- <td><?php //echo checkIvrApproval_status($rows['id'],$conn);?></td> -->


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
  
   <?php  } ?>  
</table>
<div class="pages_1">Total number of Companies: <?php echo $rCount;?>
<?php echo pagination(20,$page,'iijs_ivr.php?action=view&page=',$rCount); //call function to show pagination?>
</div> 
</form>

</div>  

<?php } ?>

<?php if($_REQUEST['action'] == "employeesList"  ){ 

   $registration_id = $_REQUEST['registration_id'];?>


<div class="content_details1">
  <?php 

  $query_sel = "SELECT company_name FROM  registration_master  where id='$registration_id'";  
  $result = $conn->query($query_sel);
  $row = $result->fetch_assoc();    
   $company_name = $row['company_name'];
  ?>
  Company Name: <?php echo $company_name; ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_ivr.php?action=view">Back</a></div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="7%" height="10">#</td>
    <td width="10%" height="30">Name</td>
    <td width="14%">Company Name</td>
    <td width="6%">Email ID</td>
    <td width="10%">Country</td>
    <td width="10%">Registration Date</td>
   
    <td width="5%">Apply Visa</td>
    <td width="5%">OTP</td>
    <td width="7%" align="center">Status</td>
    <td width="7%">Action</td>
    <?php if($adminID==1 || $adminID==45 || $adminID==154 ){?><td>Delete</td><?php } ?>
   
  </tr>
  <?php
  

 
   $sql_employees="SELECT * FROM  `ivr_registration_details` WHERE 1 AND  `uid` = '$registration_id' order by time_stamp desc ";
  
    
  
  
$counter_e = 1;
  $result_employees=$conn ->query($sql_employees);
  $eCount=$result_employees->num_rows;;


  
  if($eCount>0)
  { 
  while($rows_employees=$result_employees->fetch_assoc())
  {
  ?>
  <tr >
    <td><?php echo $counter_e++; ?></td>
    <td><?php echo strtoupper(filter($rows_employees['first_name'])) ." ".strtoupper(filter($rows_employees['last_name']));?></td>
    <td><?php echo strtoupper(filter($rows_employees['company_name']));?></td>
    <td><?php echo $rows_employees['email'];?></td>
    <td><?php echo getCountryName($rows_employees['country'],$conn);?></td>
    <td><?php echo date("d-m-Y",strtotime($rows_employees['modified_date']));?></td>
    
    <td><?php if($rows_employees['apply_visa']=="1"){echo "Yes";}else{echo "No";} ?></td>
    <td><?php echo $rows_employees['otp'];  ?></td>
    <td align="center">
  <?php 
  if($rows_employees['personal_info_approval']=='Y' && $rows_employees['photo_approval']=='Y' && $rows_employees['valid_passport_copy_approval']=='Y' && $rows_employees['visiting_card_approval']=='Y' && $rows_employees['nri_photo_approval']=='Y' )
  {
    echo "<img src='images/yes.gif' border='0' />"; 
  }else if($rows_employees['personal_info_approval']=='P' || $rows_employees['photo_approval']=='P' || $rows_employees['valid_passport_copy_approval']=='P' || $rows_employees['visiting_card_approval']=='P' || $rows_employees['nri_photo_approval']=='P')
  {
    echo "<img src='images/notification-exclamation.gif' border='0' />";  
  }else
  {
    echo "<img src='images/no.gif' border='0' />";  
  }
  ?>
    
    </td>
    <td align="left" valign="middle"><a href="iijs_personal_information_IVR.php?id=<?php echo $rows_employees['eid'];?>&registration_id=<?php echo $rows_employees['uid'];?>"><img src="images/edit1.png" border="0" /></a> </td>
    <?php if($adminID==1 || $adminID==45 || $adminID==154 ){ ?>
	<td><a style="text-decoration:none;" href="iijs_ivr.php?action=delVisitor&visitor_id=<?php echo $rows_employees['eid'];?>&registration_id=<?php echo $rows_employees['uid'];?>" onClick="return(window.confirm('Are you sure you want to Delete.'));"><img src="images/no.gif" border="0" title="Delete"/></a></td>
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
  
   <?php  } ?>  
</table>
</div>
<?php } ?>
<?php if($_REQUEST['action'] == "ordersList"  ){ 

   $registration_id = $_REQUEST['registration_id'];?>


<div class="content_details1">
  <?php 

  $query_sel_order = "SELECT company_name FROM  registration_master  where id='$registration_id'";  
  $result_order = $conn->query($query_sel_order);
  $row_order = $result_order->fetch_assoc();    
   $company_name = $row_order['company_name'];
  ?>
  Company Name: <?php echo $company_name; ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_ivr.php?action=view">Back</a></div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="7%" height="10">#</td>
    <td width="10%" height="30">Name</td>
    <td width="10%" height="30">Email</td>
    <td width="14%">Show </td>
    <td width="6%">Year</td>
    <td width="10%">Registered from </td>
  
  </tr>
  <?php
  

 
   $sql_order="SELECT * FROM  `ivr_registration_history` WHERE 1 AND  `registration_id` = '$registration_id' and `show`='signature23' order by create_date desc ";
  
    
  
  
$counter_e = 1;
  $result_order=$conn ->query($sql_order);
  $oCount=$result_order->num_rows;;


  
  if($oCount>0)
  { 
  while($rows_order=$result_order->fetch_assoc())
  {
  ?>
  <tr >
    <td><?php echo $counter_e++; ?></td>
    <td><?php echo intlVisitorName($rows_order['visitor_id'],$conn);?></td>
    <td><?php echo intlVisitorEmail($rows_order['visitor_id'],$conn);?></td>
    
   
    <td><?php echo $rows_order['show'];?></td>
    <td><?php echo $rows_order['year'];?></td>
     <td><?php echo $rows_order['paymentThrough'];?></td>
    
  
 
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
  
   <?php  } ?>  
</table>
</div>
<?php } ?>

<?php
function pagination($per_page, $page = 1, $url = '', $total){ 

$adjacents = "2";
$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$per_page=20;
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
       
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>