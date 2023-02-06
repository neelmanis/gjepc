<?php 
session_start(); 
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
?>
<?php
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
    $_SESSION['last_yr_participant']="";	
	
	$_SESSION['selected_area']="";
	$_SESSION['selected_premium_type']="";
	$_SESSION['payment_status']="";
    $_SESSION['document_status']="";
    $_SESSION['search_region']="";
	  
  header("Location: igjme_exhibitor_rgistration.php");
  
}else
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
	  $_SESSION['application_status']=$_REQUEST['status'];
	  $_SESSION['last_yr_participant']=$_REQUEST['last_yr_participant'];
	 // $_SESSION['section']=$_REQUEST['section'];
	  
	  $_SESSION['selected_area']=$_REQUEST['selected_area'];
	  $_SESSION['selected_premium_type']=$_REQUEST['selected_premium_type'];
	  $_SESSION['payment_status']=$_REQUEST['payment_status'];
  	  $_SESSION['document_status']=$_REQUEST['document_status'];
	  $_SESSION['search_region']=$_REQUEST['region'];
      $_SESSION['status']=$_REQUEST["status"];	 	 
	}
	if($search_type=='SEARCH')
	{
		if($_SESSION['first_name']=="" && $_SESSION['company_name']=="" && $_SESSION['from_date']=="Form" && $_SESSION['to_date']=="To" && $_SESSION['country']=="" && $_SESSION['status']=="" && $_SESSION['last_yr_participant']=="" && $_SESSION['section']=="" && $_SESSION['selected_area']=="" && $_SESSION['selected_premium_type']=="" && $_SESSION['payment_status']=="" && $_SESSION['region']=="")
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
if($_REQUEST['action']=='old_to_part')
{
		$get = "SELECT * FROM exh_reg_payment_details where `show`='IGJME' AND (sales_order_no='tem categor' || sales_order_no='rror in doc' || sales_order_no='old-to part' || sales_order_no='pecify eith' || sales_order_no='o customer')";
		$result_query = $conn ->query($get);
		$getCount = $result_query->num_rows;
		
		$get2 = "SELECT * FROM `utr_history` where `show` ='IGJME'  AND (first_sales_order_no='tem categor' || first_sales_order_no='rror in doc' || first_sales_order_no='old-to part' || first_sales_order_no='pecify eith' || first_sales_order_no='o customer')";
		$result_query2 = $conn ->query($get2);
		$getCount2 = $result_query2->num_rows;
		
		if($getCount >0 && $getCount2 >0){
		$sql="UPDATE `exh_reg_payment_details` SET `sap_sale_order_create_status` = '0', `sales_order_no` = '' WHERE `show`='IGJME' AND (sales_order_no='tem categor' || sales_order_no='rror in doc' || sales_order_no='old-to part' || sales_order_no='pecify eith' || sales_order_no='o customer') AND `sap_sale_order_create_status` = '1'";
		$result = $conn ->query($sql);  
		
		$sql2="UPDATE `utr_history` SET `sap_so_status` = '0', `first_sales_order_no` =  '' WHERE `show`='IGJME'  AND (first_sales_order_no='tem categor' || first_sales_order_no='rror in doc' || first_sales_order_no='old-to part' || first_sales_order_no='pecify eith' || first_sales_order_no='o customer') AND `sap_so_status` = '1'";
		$result2 = $conn ->query($sql2); 
		 
        if(!$result) die ($conn->error);
		echo "<meta http-equiv=refresh content=\"0;url=igjme_exhibitor_rgistration.php\">";
		} else { 
		echo "<script> alert('No old To Part Found');</script>";
		echo "<meta http-equiv=refresh content=\"0;url=igjme_exhibitor_rgistration.php\">";
		}		
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IGJME Exhibitor List</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});

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
	<div class="breadcome"><a href="admin.php">Home</a> >IGJME Exhibitor</div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head"><a href="igjme_exhibitor_rgistration.php">
    	<div class="content_head_button">IGJME Exhibitor List</div></a>
		<?php if(!empty($adminID)){?>
		<div style="float:right; padding-right:10px; font-size:12px;">
        <a href="export_utr_igjme_exhibitor_rgistration.php">&nbsp;Download Payment Data</a>
		<a href="export_approve_igjme_exhibitor_registration.php">&nbsp;Download All Data</a>
		</div><?php } ?>
		<?php
		if($_SESSION['curruser_login_id']=='28' || $_SESSION['curruser_login_id']=='1'){ ?>
		<a href="igjme_exhibitor_rgistration.php?action=old_to_part" onClick="return(window.confirm('Are you sure you want to Clear Old to Part Data'));" >Clear SAP Error</a>	
		<?php }	?>
		</div>
    <div class="content_details1">
   	<?php 
	if($_SESSION['curruser_role']=="Super Admin")
	{
	$sql5="select a.id,a.company_name,a.contact_person,a.region,a.created_date,b.last_yr_participant,b.selected_area,b.selected_premium_type,c.payment_status,c.document_status,c.application_status from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid where a.event_for='IGJME'";
	} else {	
	if(preg_match('/L/',$_SESSION['curruser_admin_access']))
	{
	$sql5="select a.id,a.company_name,a.contact_person,a.region,a.created_date,b.last_yr_participant,
	b.selected_area,b.selected_premium_type,c.payment_status,c.document_status,c.application_status from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid where a.event_for='IGJME'";	
	} else {
	$sql5="select a.id,a.company_name,a.contact_person,a.region,a.created_date,b.last_yr_participant,
	b.selected_area,b.selected_premium_type,c.payment_status,c.document_status,c.application_status from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid where a.event_for='IGJME' AND a.region='".$_SESSION["curruser_region_id"]."' ";
	}
	}
	//echo $sql5;
	$result5=$conn->query($sql5);
	$total_application=$result5->num_rows;
	
	$total_approve=0;
	$total_pending=0;
	$total_disapprove=0;
	while($rows5=$result5->fetch_assoc())
	{
		if($rows5['application_status']=='approved')
		{
			$total_approve=$total_approve+1;
		}else if($rows5['application_status']=='pending')
		{
			$total_pending=$total_pending+1;
		}else if($rows5['application_status']=='rejected')
		{
			$total_disapprove=$total_disapprove+1;
		}
	}	
	?>
   	      <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
   	        <tr class="orange1">
   	          <td colspan="11" >Report Summary</td>
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
<div class="content_details1">

<form name="search" action="" method="POST"> 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt">
  <tr class="orange1"><td colspan="11">Search Options</td></tr>
  <tr>
    <td><strong>Company Name</strong></td>
    <td><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>"/></td>
  </tr>
  <tr>
    <td><strong>Email ID</strong></td>
    <td><input type="text" name="email" id="email" class="input_txt" value="<?php echo $_SESSION['email'];?>"/></td>
  </tr>
  <tr>
    <td><strong>Country</strong></td>
    <td>
	<select name="country" id="country" class="input_txt">
    <option value="">Please Select Country Name</option>
    <?php 
	$sql2="select * from country_master where status=1";
	$result2=$conn->query($sql2);
	while($rows2=$result2->fetch_assoc())
	{
		if($_SESSION['country_code']==$rows2['country_code'])
		{
		echo "<option value='$rows2[country_code]' selected='selected'>$rows2[country_name]</option>";
		} else {
		echo "<option value='$rows2[country_code]'>$rows2[country_name]</option>";
		}
	}
	?>
    </select>
	</td>
  </tr>
  <tr>
    <td><strong>Date</strong></td>
    <td><input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "Form";}else{echo $_SESSION['from_date'];}?>"  class="input_date"/>
      <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date"/></td>
  </tr>  
  <tr class="orange1">
  	<td colspan="11">Stall Details</td>
  </tr>

  <tr>
    <td><b>Selected Area</b></td>
    <td>
    <select name="selected_area" >
    <option value="">---Select Area---</option>
    <?php
	$section_query = "select * from igjme_area_master";
	$execute_section = $conn->query($section_query);
	while($show_section = $execute_section->fetch_assoc())
	{
	?>
    <option value=<?php echo $show_section["area"]; ?> <?php if($_SESSION["selected_area"]==$show_section["area"]) echo "selected"; ?>><?php echo $show_section["area"]; ?></option>    		
	<?php }	?>
    </select>
    </td>
 </tr>

  <tr>
    <td><b>Selected Premium Type</b></td>
    <td>
    <select name="selected_premium_type" >
        <option value="">---Select Premium Type---</option>
    	 <?php 
		 $section_query = "select * from igjme_premium_master";
		 $execute_section = $conn->query($section_query);			
		 while($show_section = $execute_section->fetch_assoc())
		 {	?>
    	<option value=<?php echo $show_section["premium"];?> <?php if($_SESSION["selected_premium_type"]==$show_section["premium"]) echo "selected";?>><?php echo $show_section["premium_desc"]; ?></option>
	<?php }	?>
    </select>
    </td>
 </tr>
 
 <tr>
    <td><b>Region</b></td>
    <td>
	<select name="region">
       <option value="">---Select  Region---</option>
       <?php 
	    $region_query = "select * from region_master";
		$execute_region = $conn->query($region_query);		
		while($show_region = $execute_region->fetch_assoc())
		{			
	   ?>
       <option value="<?php echo $show_region["region_name"]; ?>" <?php if($_SESSION["search_region"]==$show_region["region_name"]) echo "selected"; ?>><?php echo $show_region["region_name"]; ?></option>
       <?php }	?>
    </select>
	</td>
 </tr>
 
 <tr class="orange1">
  	<td colspan="11">Approval Details</td>
  </tr>
  
  <tr>
    <td><strong>Application Status</strong></td>        
    <td><select name="status" class="input_txt-select" >
      <option value="">Select Status</option>
      <option value="approved" <?php if($_SESSION['status']=='approved'){echo "selected";}?>>Application Approved</option>
      <option value="rejected" <?php if($_SESSION['status']=='rejected'){echo "selected";}?>>Application Disapproved</option>
      <option value="pending" <?php if($_SESSION['status']=='pending'){echo "selected";}?>>Application Pending</option>
      </select></td>
  </tr>
   
   <tr >
    <td><strong>Payment Status</strong></td>
    <td>
    <select name="payment_status" class="input_txt-select" >
      <option value="">Select Status</option>
      <option value="approved" <?php if($_SESSION['payment_status']=='approved'){echo "selected='selected'";}?>>Payment Approved</option>
      <option value="rejected" <?php if($_SESSION['payment_status']=='rejected'){echo "selected='selected'";}?>>Payment Disapproved</option>
      <option value="pending" <?php if($_SESSION['payment_status']=='pending'){echo "selected='selected'";}?>>Payment Pending</option>
    </select></td>
  </tr>
   
  <tr>
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
    <td width="7%" height="30">Reg ID</td>
    <td width="14%">Company Name</td>
    <td width="10%">Sales Order Number</td>
    <td width="10%">Region</td>
    <td width="10%">Member Type</td>
    <td width="10%">HO BP No</td>
	<td width="10%">Billing BP No.</td>
    <td width="20%">Stall Details</td>
    <td width="20%">Options</td>
    <td width="7%">Payment Status</td>
    <td width="8%">Application Status</td>
    <td width="7%" align="center">App Date</td>
    <td width="7%">Action</td>
    <td width="7%">Create SO</td>
    <td width="7%">Create BP</td>
  </tr>
  <?php
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
if($_SESSION['curruser_role']=="Super Admin")
{
	 $sql="select a.id,a.uid,a.company_name,a.contact_person,a.region,a.billing_address_id,a.created_date,b.last_yr_participant,b.options,b.selected_area,b.selected_premium_type,b.options,c.payment_id,c.payment_status,c.document_status,c.application_status,c.modified_date,c.sales_order_no,c.sap_sale_order_create_status from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid where a.event_for='IGJME'";
} else {
	if(preg_match('/O/',$_SESSION['curruser_admin_access']))
	{
	$sql="select a.id,a.uid,a.company_name,a.contact_person,a.region,a.billing_address_id,a.created_date,b.last_yr_participant,b.options,
			b.selected_area,b.selected_premium_type,c.payment_id,c.payment_status,c.document_status,c.application_status,c.sales_order_no,c.sap_sale_order_create_status
			from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid where a.event_for='IGJME'";	
	} else {
	$sql="select a.id,a.uid,a.company_name,a.contact_person,a.region,a.billing_address_id,a.created_date,b.last_yr_participant,b.options,	b.selected_area,b.selected_premium_type,c.payment_id,c.payment_status,c.document_status,c.application_status,c.sales_order_no,c.sap_sale_order_create_status from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid where a.event_for='IGJME' AND a.region='".$_SESSION["curruser_region_id"]."' ";
	}
}
  if($_SESSION['first_name']!="")
  {
  		$sql.=" and first_name like '%".$_SESSION['first_name']."%'";
  }
     
  if($_SESSION['last_name']!="")
  {
  		$sql.=" and last_name like '%".$_SESSION['last_name']."%'";
  }
  
  if($_SESSION['company_name']!="")
  {
  		$sql.=" and company_name like '%".$_SESSION['company_name']."%'";
  }
  
  if($_SESSION['email']!="")
  {
  	$sql.=" and email like '%".$_SESSION['email']."%'";
  }
  
  if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
  {
    $sql.=" and time_stamp between '".date("Y-m-d",strtotime($_SESSION['from_date']))."' and '".date("Y-m-d",strtotime($_REQUEST['to_date']))."'";
  }
  
  if($_SESSION['country']!="")
  {
  $sql.=" and country='".$_SESSION['country']."'";
  }
  
  if($_SESSION['application_status']!="")
  { 
  	if($_SESSION['application_status']=='approved')
	{
		$sql.=" and application_status='approved' ";
	} else if($_SESSION['application_status']=='pending')
	{
		$sql.=" and application_status='pending' ";
	} else {
		$sql.=" and application_status='rejected' ";
	}
  }
  
  if($_SESSION['payment_status']!="")
  { 
  	if($_SESSION['payment_status']=='approved')
	{
		$sql.=" and payment_status='approved' ";
	} elseif($_SESSION['payment_status']=='pending')
	{
		$sql.=" and payment_status='pending' ";
	} else {
		$sql.=" and payment_status='rejected' ";
	}
  }
  
  if($_SESSION["search_region"]!="")
  {
	$region = $_SESSION["search_region"];
	$sql.=" and region like '%$region%'";
  }

/*  if($_SESSION["section"]!="")
  {
	$section_search = $_SESSION["section"];
		$sql.=" and section='$section_search'";
  }*/
  
  if($_SESSION["selected_area"]!="")
  {
	$area_search = $_SESSION["selected_area"];
		$sql.=" and selected_area='$area_search'";
  }
  
  if($_SESSION["selected_premium_type"]!="")
  {
	$premium_search = $_SESSION["selected_premium_type"];
		$sql.=" and selected_premium_type='$premium_search'";
  }
  
 	$sql.=" order by c.modified_date desc ,c.payment_id desc"; 
	//echo $sql;
	$result=$conn->query($sql);

	$rCount=$result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1=$conn->query($sql1);	
	
  if($rCount>0)
  {	$i=1;
  while($rows=$result1->fetch_assoc())
  {
  	$schk_membership="SELECT * FROM `approval_master`  WHERE 1 and `registration_id`='".$rows['uid']."' and issue_membership_certificate_expire_status='Y'";
	$qchk_membership=$conn->query($schk_membership);
	$nchk_membership=$qchk_membership->fetch_assoc();
	$bpno=getBPNO($rows['uid'],$conn);
	$nonmemberBP = getCompanyNonMemBPNO($rows['uid'],$conn);
	$billingBP = getBillingBPNO($rows['billing_address_id'],$conn);
  ?>
  <tr>
  	<td><?php echo $rows['id'];?></td>
    <td><?php echo strtoupper(filter($rows['company_name']));?></td>
    <td><?php echo $rows['sales_order_no'];?></td>
    <td><?php echo $rows['region'];?></td>
    <td><?php if($nchk_membership>0){ echo $member_type= 'MEMBER';}else{ echo $member_type= 'NON MEMBER';}?></td>
    <td><?php if($nchk_membership>0) {echo $bpno; } else { echo $nonmemberBP; }?></td>
	<td><?php echo $billingBP;?></td>
    <?php  $premium = getPremiumName($rows['selected_premium_type'],$conn); ?>
    <td><?php echo $rows['last_yr_participant']." | ".$rows['selected_area']." | ".$premium."|".$rows['options']; ?></td>
    <td>
    <?php if($rows['options']=="Same stall position size as of previous year")
			echo "Retain";
		 else if($rows['options']=="Same area but different location as of previous year IGJME")
		 	echo "Different Location";
		else if($rows['options']=="More area than previous year IGJME")
			echo "More Area";
		else if($rows['options']=="Less area as previous year")
			echo "Less Area";
		else
			echo "New Applicant";
	?>
    </td>
    <td>
		<?php //echo $rows['payment_status']; ?>
        <?php
			if($rows['payment_status']=="pending") 
        		echo "<img src='images/notification-exclamation.gif' border='0' />";	
			elseif($rows['payment_status']=="approved")
				echo "<img src='images/yes.gif' border='0' />";	
			else
				echo "<img src='images/no.gif' border='0' />";				
		?>
    </td>
    <td>
	<?php // echo $rows['application_status']?>
    <?php
			if($rows['application_status']=="pending") 
        		echo "<img src='images/notification-exclamation.gif' border='0' />";	
			elseif($rows['application_status']=="approved")
				echo "<img src='images/yes.gif' border='0' />";	
			else
				echo "<img src='images/no.gif' border='0' />";				
		?>
    </td>
    <td><?php echo $rows['modified_date'];?></td>
    <!--<td align="center">
	<?php 
	if($rows['personal_info_approval']=='Y' && $rows['photo_approval']=='Y' && $rows['valid_passport_copy_approval']=='Y' && $rows['visiting_card_approval']=='Y' && $rows['nri_photo_approval']=='Y')
	{
		echo "<img src='images/yes.gif' border='0' />";	
	}else if($rows['personal_info_approval']=='P' || $rows['photo_approval']=='P' || $rows['valid_passport_copy_approval']=='P' || $rows['visiting_card_approval']=='P' || $rows['nri_photo_approval']=='P')
	{
		echo "<img src='images/notification-exclamation.gif' border='0' />";	
	}else
	{
		echo "<img src='images/no.gif' border='0' />";	
	}
	?>
    
    </td>-->
    <td align="left" valign="middle"><a href="igjme_exh_registration_step1.php?id=<?php echo $rows['id'];?>&registration_id=<?php echo $rows['uid'];?>"><img src="images/edit1.png" border="0" /></a> 
		<a href="igjme_exh_registration_step4.php?id=<?php echo $rows['id'];?>&registration_id=<?php echo $rows['uid'];?>">A/D</a>
		<?php if($_SESSION['curruser_role']=="Super Admin") { ?>
		<a href="delete_exh_registration.php?id=<?php echo $rows['id'];?>&registration_id=<?php echo $rows['uid'];?>"> Delete</a>
		<?php } ?>
    </td>
	<?php if($rows['application_status']=="approved"){  ?>
	<?php if($rows['sap_sale_order_create_status'] == 0) { ?>
		<td class="so" data-url="<?php if($bpno==''){ echo $nonmemberBP; }else { echo $bpno; }?> <?php echo $rows['uid'];?> <?php echo csrf_sap_token();?>">CREATE SO</td>
	<?php } else { ?>
    	<td><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
    <?php } ?>
	<?php } else {?>
	<td></td>
	<?php } ?>
	<?php 
	if($nchk_membership==0) {
	if($nonmemberBP=="" || $nonmemberBP==0) { ?>
	<td class="comp" data-url="<?php echo $rows['uid'];?>"><img src="images/reply.png" title="PUSH" border="0" style=""/></td>
	<?php } else { ?>
	<td><a onclick="return(window.confirm('BP Already CreatememberBPd'));"><img src="images/active.png"/></a></td>
	<?php } } ?>
  </tr>
  
  <?php
   $i++;
   }   
}
   else
   {
   ?>
   <tr>
     <td colspan="10">Records Not Found</td>
   </tr>  
   <?php  } ?>  
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
$pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
$pagination.= "<li><a class='current'>Next</a></li>";
$pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
} 
?>	
<div class="pages_1">Total Number of Application: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'igjme_exhibitor_rgistration.php?page=',$rCount); //call function to show pagination?>
</div>        
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
/* Company BP Creation */
$(".comp").click(function() {
	var values = $(this).data('url');
	var registration_id=values;
	//alert(registration_id);
	
	if(confirm("Are you sure you want to Create Company BP")) {
		$.ajax({
		url: "create_nm_igjme_bp_api.php",
		method:"POST",
		data:{registration_id:registration_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			//console.log(data); exit;
			if($.trim(data)==1){
				alert("BP successfully Created..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);		
			}
			//console.log(data);
		},
		});
	}	  
});

$(".so").click(function() {
	var values = $(this).data('url').split(" ");
	var bpno=values[0];
	var registration_id=values[1];
	var csrf_sap_token=values[2];
	//alert(bpno);
	
	if (confirm("Are you sure you want to create Sales Order")) 
	{
		$.ajax({
		url: "api_igjme_exhibition.php",
		method:"POST",
		data:{bpno:bpno,registration_id:registration_id,csrf_sap_token:csrf_sap_token,show:"IGJME"},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{ 	
			//console.log(data); return false;
			if($.trim(data)==1){
				alert("Sales Order successfully Created..");
				window.location.href = "igjme_exhibitor_rgistration.php";
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.href = "igjme_exhibitor_rgistration.php";			
			}
			//console.log(data);
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
</html>