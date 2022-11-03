<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
  $adminId = intval(filter($_SESSION['curruser_login_id']));
	$admin_name = getAdminName($adminId,$conn);
  ?>

<?php
if(($_REQUEST['action']=='updateApproval')&&($_REQUEST['id']!='') &&($_REQUEST['regid']!=''))
{
}
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['event']="";
  $_SESSION['company_name']="";
  $_SESSION['pan_no']="";
  $_SESSION['email']="";
  $_SESSION['mobile']="";
  $_SESSION['category']="";
  $_SESSION['fname']="";
  $_SESSION['uniqueIdentifier']="";
  header("Location: manage_onspot_registration.php?action=view");
} else
{
    $search_type=$_REQUEST['search_type'];
    if($search_type=="SEARCH")
    { 
		$_SESSION['event']=  filter($_REQUEST['event']);
		$_SESSION['company_name']=  filter($_REQUEST['company_name']);
		$_SESSION['pan_no']      =  filter($_REQUEST['pan_no']);
		$_SESSION['email']       =  filter($_REQUEST['email']);
		$_SESSION['mobile']      =  filter($_REQUEST['mobile']);
		$_SESSION['category'] = $_REQUEST['category'];
		$_SESSION['fname'] = $_REQUEST['fname'];
		$_SESSION['uniqueIdentifier'] = $_REQUEST['uniqueIdentifier'];
    }
}
?>
<?php $shortcode = $_SESSION['event'];
	$showInfo = $conn->query("SELECT * FROM visitor_event_master WHERE `shortcode`='$shortcode'");
	$showInfoResult = $showInfo->fetch_assoc();
	$show_name = $showInfoResult['event_name'];
?>
<?php 
if(($_REQUEST['action']=='reset') && ($_REQUEST['id']!=''))
{
	$id = filter(intval($_REQUEST['id']));
	$checkData = "SELECT isDataPosted FROM gjepclivedatabase.globalExhibition WHERE 1 and id='$id'" ;
	$resultData =$conn->query($checkData);
	$rows = $resultData->fetch_assoc();
	$isDataPosted=$rows['isDataPosted'];
	if($isDataPosted=="Y")
		$updateStatus='U';
	else
		$updateStatus='I';
		
	$sql="update gjepclivedatabase.globalExhibition set isDataPosted='N',updateStatus='$updateStatus' where id='$id'";
	$query=$conn -> query($sql);
	if($query) {
		echo "<meta http-equiv=refresh content=\"0;url=manage_onspot_registration.php?action=view\">";
	} else {
		die ($conn->error);
	}	
}
?>
<?php 
if(isset($_REQUEST['update']) && $_REQUEST['update']=="UPDATE"){
	
	$id=$_REQUEST['id'];
	$mobile=$_REQUEST['mobile'];
	$email=$_REQUEST['email'];
	$status=$_REQUEST['status'];
	$dose1_status=$_REQUEST['dose1_status'];
	$dose2_status=$_REQUEST['dose2_status'];
	$srl_report_url=$_REQUEST['srl_report_url'];
	//$booster_dose_status=$_REQUEST['booster_dose_status'];
	
	$checkData = "SELECT isDataPosted FROM gjepclivedatabase.globalExhibition WHERE 1 and id='$id'" ;
	$resultData = $conn->query($checkData);
	$rows = $resultData->fetch_assoc();
	$isDataPosted=$rows['isDataPosted'];
	if($isDataPosted=="Y"){
		$updateStatus='U';
		$isDataPosted="N";
	} else {
		$updateStatus='I';
		$isDataPosted="N";
	}
	
	//$sql="update gjepclivedatabase.globalExhibition set mobile='$mobile',srl_report_url='$srl_report_url',status='$status',isDataPosted='$isDataPosted',updateStatus='$updateStatus',email='$email',dose1_status='$dose1_status',dose2_status='$dose2_status' where id='$id'";
	$sql="update gjepclivedatabase.globalExhibition set mobile='$mobile',srl_report_url='$srl_report_url',status='$status',isDataPosted='$isDataPosted',updateStatus='$updateStatus',email='$email',dose2_status='$dose2_status' where id='$id'";
	$resultx = $conn -> query($sql);  
	if($resultx) {
	/* Maintain log */
	$sqlLogs = "INSERT INTO visitor_approval_logs SET post_date=NOW(), visitor_id='$id',admin_id='$adminId',admin_name='$admin_name',type='onspot_approval',action='update'"; 
	$resultLogs = $conn ->query($sqlLogs);
	echo "<meta http-equiv=refresh content=\"0;url=manage_onspot_registration.php?action=view\">";
	} else {
	die ("Mysql Insert Error: " . $conn->error);
	}
}
//print_r($_SESSION);
?>
<?php
if($_REQUEST['action']=='onSpotRegistration')
{
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$path = "onspot/".$mobile."/";
	if (!file_exists($path)) {
		mkdir($path, 0777);
	}
	$digits = 9;	
	$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	$checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	$countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
	while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
	} 
	
	$visitor_photo = $_FILES['visitor_photo']['name'];
	$tmp = $_FILES['visitor_photo']['tmp_name'];
	$ext = pathinfo($visitor_photo, PATHINFO_EXTENSION);

	$vaccine_certificate = $_FILES['vaccine_certificate']['name'];
	$tmp1 = $_FILES['vaccine_certificate']['tmp_name'];
	$ext1 = pathinfo($vaccine_certificate, PATHINFO_EXTENSION);
	
	if($ext=="jpg" || $ext=="JPG" || $ext=="png" || $ext=="PNG" || $ext=="jpeg" || $ext=="JPEG")
	{
		$actual_image_name = $visitor_photo;
		$target_path=$path.$actual_image_name;	
		move_uploaded_file($tmp,$target_path);
	}else{
		echo "<script> alert('Please upload visitor image only');</script>";
	}
	if($ext1=="jpg" || $ext1=="JPG" || $ext1=="png" || $ext1=="PNG" || $ext1=="jpeg" || $ext1=="pdf")
	{
		$actual_certificate_name = $vaccine_certificate;
		$target_path=$path.$actual_certificate_name;	
		move_uploaded_file($tmp1,$target_path);
	}else{
		echo "<script> alert('Please upload allowed extension vaccine file only');</script>";
	}
	
	$event = $_POST['event'];
	$fname = $_POST['fname'];
	$pan_no = $_POST['pan_no'];
	$designation = $_POST['designation'];
	$company = $_POST['company'];
	$certificate=$_POST['valueType'];
	$recommended_by=$_POST['recommended_by'];
	if($certificate=="dose1"){
		$dose1_status="Y";
		$dose2_status="P";
	}
	elseif($certificate=="dose2"){
		$dose2_status="Y";
		$dose1_status="P";
	}
		
	$photo_url="https://gjepc.org/admin/".$path.$actual_image_name;
	$vaccine_url="https://gjepc.org/admin/".$path.$actual_certificate_name;
	$srl_report_url="onspot";
	$participant_Type="CONTR";
	$agency_category = $_POST['category'];
	if($agency_category=='INTL'){
		$participant_Type='INTL';
		$agency_category="";
	}
	else{
		$participant_Type='CONTR';
	}
		
	$registration_id=substr($mobile,0,4);
	$visitor_id=substr($mobile,0,4);
	
	$checkData = "SELECT * FROM gjepclivedatabase.globalExhibition WHERE 1 and mobile='$mobile'" ;
	$resultData =$conn->query($checkData);
	$countData =  $resultData->num_rows;
	if($countData>0){
		echo "<script> alert('This Mobile no is already exist');</script>";
	}else{
	$global = "INSERT INTO gjepclivedatabase.globalExhibition SET `uniqueIdentifier`='$uniqueIdentifier',registration_id='$registration_id',visitor_id='$visitor_id',fname='$fname',mobile='$mobile',email='$email',pan_no='$pan_no',designation='$designation',company='$company',photo_url='$photo_url',vaccine_url='$vaccine_url',srl_report_url='$srl_report_url',participant_Type='$participant_Type',agency_category='$agency_category',covid_report_status='negative',certificate='$certificate',days_allow='all',isDataPosted='N',status='Y',dose1_status='$dose1_status',dose2_status='$dose2_status',event='$event',onspot_adminId='$adminId',onspot_add_date=NOW(),`recommended_by`='$recommended_by'";
	$globalQuery = $conn ->query($global);
	if(!$globalQuery) die ($conn->error);
	}
	 header("Location: manage_onspot_registration.php?action=view");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS <?php echo $show_name; ?></title>
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
     /Manage OnSpot Registration - <?php echo $show_name; ?></div>
</div>

<div id="main">
    <div class="content"> 
    <div class="content_head">
        <div style="float: left;">
			Manage OnSpot Registration - <?php echo $show_name; ?>
		</div>
		
			<div style="float:right; margin-right: 15px; margin-bottom: 15px;">
				<a href="export_active_badge_report.php?action=add">Download active badge report</a>
			</div>
				<div style="clear:both"></div>
		 <div style="float:right;">
		 	<?php if($_SESSION['curruser_login_id']=='1' || $_SESSION['curruser_login_id']=='91'  || $_SESSION['curruser_login_id']=='197' || $_SESSION['curruser_login_id']=='131' || $_SESSION['curruser_login_id']=='145' ){ ?>
	           <a href="manage_onspot_registration.php?action=add"><div class="content_head_button">Add New Visitor</div></a>
		 	<?php } ?>
		
			<a href="manage_onspot_registration.php?action=view"><div class="content_head_button">View List</div></a>
		</div>
		 <div class="clear"></div>
    </div>
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
<td><strong>Select Event</strong></td>        
    <td>
        <select name="event" id="event" class="input_txt-select">
        <option value="">Select Event</option>
        <?php 
          $events_result = $conn->query("SELECT * FROM visitor_event_master WHERE 1");
          	while($events_rows = $events_result->fetch_assoc()){?>
  					<option value="<?php echo $events_rows['shortcode']; ?>" <?php if($_SESSION['event']==$events_rows['shortcode']){echo "selected='selected'";}?>><?php echo $events_rows['event_name']; ?></option>
			<?php } 
        ?>
        </select>
    </td>
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
  <td><strong>Unique ID</strong></td>
  <td><input type="text" name="uniqueIdentifier" id="uniqueIdentifier" maxlength="10" class="input_txt" value="<?php echo $_SESSION['uniqueIdentifier'];?>" autocomplete="off"/></td>
</tr>
<tr id="pan_number_div">
  <td><strong>Visitor Name</strong></td>
  <td><input type="text" name="fname" id="fname"  class="input_txt" value="<?php echo $_SESSION['fname'];?>" autocomplete="off"/></td>
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
</tr>

<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/>
 <input type="submit" name="Reset" value="Reset" class="input_submit"/></td>
</tr>   
</table>
</form>      
</div>
<!------------------------------- ORDER DIRECTORY ---------------------------------->

<?php if($_REQUEST['action']=='view') { ?>  
<div class="content_details1">
<form name="form1" action="" method="post"> 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Unique ID</td>
    <td>Event Name</td>
    <td>Company Name</td>
    <td>Visitor Name</td>
	<?php if($_SESSION['category']=="INTL"){?>
    <td>Email Id</td>
	<?php }else {?>
	<td>Pan Number</td>
	<td>Mobile Number</td>
	<?php }?>
    <td>Comment</td>
	<td>Type</td>
    <td>Status</td>
	<!--<td>D1 Status</td>-->
	<td>Face Status</td>
	<td>D2 Status</td>
	<!--<td>D3 Status</td>-->
	<td>Down</td>
	<td>OTP</td>
	<td width="7%" align="center">Action</td>
  </tr>
    <?php  
		$page=1;//Default page
		$limit=25;//Records per page
		$start=0;//starts displaying records from 0
		if(isset($_GET['page']) && $_GET['page']!=''){
			$page=$_GET['page'];    
		}
		$start=($page-1)*$limit;

		$sql="SELECT * FROM gjepclivedatabase.globalExhibition where 1 ";
		if($_SESSION['event']!="")
		{
			$sql.=" and event = '".$_SESSION['event']."'";
		}
		if($_SESSION['category']!="")
		{
			$sql.=" and participant_Type = '".$_SESSION['category']."'";
		}
		if($_SESSION['uniqueIdentifier']!="")
		{
			$sql.=" and uniqueIdentifier = '".$_SESSION['uniqueIdentifier']."'";
		}
		if($_SESSION['fname']!="")
		{
			$sql.=" and fname like '%".$_SESSION['fname']."%'";
		}
		
		if($_SESSION['pan_no']!="")
		{
			$sql.=" and pan_no like '%".$_SESSION['pan_no']."%'";
		}
		if($_SESSION['email']!="")
		{
			$sql.=" and email like '%".$_SESSION['email']."%'";
		}
		if($_SESSION['mobile']!="")
		{
			$sql.=" and mobile like '%".$_SESSION['mobile']."%'";
		}
		$result = $conn ->query($sql);

		$rCount = $result->num_rows;
		$sql1= $sql."order by post_date DESC  limit $start, $limit ";
		
		$result1= $conn->query($sql1);
		if($rCount>0)
		{ 
		while($rows = $result1->fetch_assoc())
		{
			$company_name=$rows['company'];
			$event=$rows['event'];
			$visitor_name=$rows['fname'];
			$pan_no=$rows['pan_no'];
			$mobile=$rows['mobile'];
			$email=$rows['email'];
			$srl_report_url=$rows['srl_report_url'];
			$participant_Type=$rows['participant_Type'];
			$agency_category=$rows['agency_category'];
			$status=$rows['status'];
			$face_status=$rows['face_status'];
			$dose1_status=$rows['dose1_status'];
			$dose2_status=$rows['dose2_status'];
			$booster_dose_status=$rows['booster_dose_status'];
			$isDataPosted=$rows['isDataPosted'];
			$otp = trim($rows['otp']);			
  ?>
    <form action="" method="POST">
	<tr>
		<td><?php echo $rows['uniqueIdentifier'];?></td>
		<td><?php echo strtoupper($event);?></td>
		<td><?php echo strtoupper($company_name);?></td>
		<td><?php echo strtoupper($visitor_name);?></td>
		<?php if($_SESSION['category']=="INTL"){?>
		<td><input type="text" name="email" id='email' value="<?php echo $email;?>" /></td>
		<?php } else { ?>
		<td><?php echo $pan_no;?></td>
		<td><input type="text" name="mobile" id='mobile' value="<?php echo $mobile;?>" /></td>
		<?php } ?>
		<td>
			<input type="text" name='srl_report_url' id='srl_report_url' value="<?php echo $srl_report_url;?>" />
		</td> 
		<td>
		<?php if($participant_Type=="CONTR"){echo $agency_category;}else{echo $participant_Type;}?></td>		
		<td>
		<select name="status" <?php if($status=="R"){ ?>  disabled="disabled" <?php }?>>
			<option <?php if($status=="Y"){?> selected <?php }?>>Y</option>
			<option <?php if($status=="P"){?> selected <?php }?>>P</option>
			<option <?php if($status=="D"){?> selected <?php }?>>D</option>
			<option <?php if($status=="DA"){?> selected <?php }?>>DA</option>
			<option <?php if($status=="R"){ ?> selected <?php }?>>R</option> 
		</select>
		</td> 
		<!--<td>
		<select name="dose1_status">
			<option <?php if($dose1_status=="Y"){?> selected <?php }?>>Y</option>
			<option <?php if($dose1_status=="N"){?> selected <?php }?>>N</option>
			<option <?php if($dose1_status=="P"){?> selected <?php }?>>P</option>
		</select>
		</td>--> 
		<td>
		<select name="face_status">
			<option <?php if($face_status=="Y"){?> selected <?php }?>>Y</option>
			<option <?php if($face_status=="N"){?> selected <?php }?>>N</option>
			<option <?php if($face_status=="P"){?> selected <?php }?>>P</option>
		</select>
		</td>
		<td>
		<select name="dose2_status">
			<option <?php if($dose2_status=="Y"){?> selected <?php }?>>Y</option>
			<option <?php if($dose2_status=="N"){?> selected <?php }?>>N</option>
			<option <?php if($dose2_status=="P"){?> selected <?php }?>>P</option>
		</select>
		</td>
		<!--<td>
		<select name="booster_dose_status">
			<option <?php if($booster_dose_status=="Y"){?> selected <?php }?>>Y</option>
			<option <?php if($booster_dose_status=="N"){?> selected <?php }?>>N</option>
			<option <?php if($booster_dose_status=="P"){?> selected <?php }?>>P</option>
		</select>
		</td>-->
		<td><?php echo $isDataPosted;?></td>
		<td><?php echo $otp;?></td>
		<td>
		<input type="hidden" name="id" value="<?php echo $rows['id']?>"/>
		
		<?php if($_SESSION['curruser_login_id']=='1'){ ?>
		<input type="submit" value="UPDATE" name="update" style="background-image: url('images/update_icon.png'); border:none; background-repeat:no-repeat;background-size:100% 100%;height: 16px; width: 16px;cursor:pointer;" title="UPDATE">
		
		<a href="manage_onspot_registration.php?action=reset&id=<?php echo $rows['id'];?>"><img src="images/reset.png" title="Reset" border="0" width="16" height="16" /></a>
		<?php } ?>
		
		<?php if($_SESSION['curruser_login_id']=='91' || $_SESSION['curruser_login_id']=='131' || $_SESSION['curruser_login_id']=='28' || $_SESSION['curruser_login_id']=='44'){?>
		<td>
		<input type="submit" value="UPDATE" name="update" style="background-image: url('images/update_icon.png'); border:none; background-repeat:no-repeat;background-size:100% 100%;height: 16px; width: 16px;cursor:pointer;" title="UPDATE">
		</td>
		<?php }?>
	</tr>
	</form>
  <?php
   $i++;
	} }else{
   ?>
	<tr>
		<td colspan="8">Records Not Found</td>
	</tr>
  <?php  }  ?>
  </table>
  </form>
</div>
<?php } ?>

<?php 
if(($_REQUEST['action']=='add'))
{
  $action='save';
?>
 
<div class="content_details1">
<form method="post" name="regisForm" id="regisForm" autocomplete="off" enctype= "multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr class="orange1">
    <td colspan="2">&nbsp; Add New Visitor</td>
    </tr>
    <tr>
    	<tr>
<td><strong>Select Event</strong></td>        
    <td>
        <select name="event" id="event" class="show-tooltip input_txt">
        <option value="">Select Event</option>
        <?php 
          $events_result = $conn->query("SELECT * FROM visitor_event_master WHERE 1 AND shortcode='iijs22'");
          	while($events_rows = $events_result->fetch_assoc()){?>
  					<option value="<?php echo $events_rows['shortcode']; ?>" <?php if($events_rows['shortcode'] =="iijs22"){echo "selected='selected'";}?>><?php echo $events_rows['event_name']; ?></option>
			<?php } 
        ?>
        </select>
    </td>
</tr>
    </tr>
	<tr>
	<td class="content_txt">Select Category: <span class="star">*</span></td>
	<td>
		<select name="category" id="category" title="Please enter agency name" class="show-tooltip input_txt" >
		<option value="">Select category</option>
		<?php $categoryGet =$conn->query("SELECT * FROM visitor_vendor_category WHERE status='1' and onspot_status='1'") ;
		while($rowCat = $categoryGet->fetch_assoc()){?>
		<option value="<?php echo $rowCat['short_name'];?>"><?php echo $rowCat['cat_name'];?></option>
		<?php   }?>
	</select>
	</tr>
    <tr>
		<td class="content_txt">Visitor Name: <span class="star">*</span></td>
		<td><input type="text" name="fname" id="fname" title="Please enter  name" class="show-tooltip input_txt" value=""/></td>
    </tr> 
	<tr>
		<td ><strong>Visitor Photo</strong></td>
		<td><input type="file" name="visitor_photo" id="visitor_photo" class="input_txt"  />(jpg,jpeg,png)</td>
	</tr>
	<tr>
		<td class="content_txt">Mobile: <span class="star">*</span></td>
		<td><input type="text" name="mobile" id="mobile" title="Please enter  Mobile" class="show-tooltip input_txt" value=""/></td>
	</tr> 
	<tr>
		<td class="content_txt">Email: <span class="star">*</span></td>
		<td><input type="text" name="email" id="email" title="Please enter  Email" class="show-tooltip input_txt" value=""/></td>
	</tr> 
	<tr>
		<td class="content_txt">Pan:</td>
		<td><input type="text" name="pan_no" id="pan_no" title="Please enter  pan_no" class="show-tooltip input_txt" value=""/></td>	
	</tr> 
	<tr>
		<td class="content_txt">Designation:</td>
		<td><input type="text" name="designation" id="designation" title="Please enter  designation" class="show-tooltip input_txt" value=""/></td>
	</tr> 
	<tr>
		<td class="content_txt">Company: <span class="star">*</span></td>
		<td><input type="text" name="company" id="company" title="Please enter  company" class="show-tooltip input_txt" value=""/></td>
	</tr> 	

	<tr>
		<td ><strong>Select Dose</strong></td>
		<td>
			<!--<label><input type="radio" checked name="valueType" id="dose1" value="dose1"> Dose 1</label>-->
			<label><input type="radio" checked name="valueType" id="dose2" value="dose2"> Dose 2</label>
		</td>
	</tr>
	<tr>
		<td><strong>Vaccine Certificate</strong></td>
		<td><input type="file" name="vaccine_certificate" id="vaccine_certificate" class="input_txt"  />(jpg,jpeg,png,pdf)</td>
	</tr>
	<tr>
		<td class="content_txt">Recommended By: <span class="star">*</span></td>
		<td><input type="text" name="recommended_by" id="recommended_by" title="Please enter  recommended person name" class="show-tooltip input_txt" value=""/></td>
	</tr> 	
    <tr>
    <td>&nbsp;</td>
    <td>
		<input type="submit" value="Submit" class="input_submit"/>
		<input type="hidden" name="action" id="action" value="onSpotRegistration" />
	</td>
    </tr>
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
<div class="pages_1" id="page_ids">Total Number Visitors : <?php echo $rCount;?>
<?php echo pagination($limit,$page,'manage_onspot_registration.php?action=view&page=',$rCount); //call function to show pagination?>
</div>  
<script src="../assets/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	$("#regisForm").validate({
		rules: {  
			category: {
				required: true,
			},  
			event: {
				required: true,
			},  
			fname: {
				required: true,
			}, 
			visitor_photo: {
				required: true,
			},  
			mobile: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
			},
			company: {
				required: true,
			},
			// vaccine_certificate: {
			// 	required: true,
			// 	specialChrs: true
			// },
		},
		messages: {
			category: {
				required: "Required",
			}, 
			event: {
				required: "Required",
			}, 
			fname: {
				required: "Required",
			},  
			visitor_photo: {
				required: "Required",
			},
			mobile: {
				required:"Please Enter Mobile Number",
				number:"Please Enter Numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},
			company: {
				required: "Required",		
			},
			// vaccine_certificate: {
			// 	required: "Required",
			// }
	 }
	});
});
</script>