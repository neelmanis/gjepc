<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
include('../db.inc.php');
//include('../functions.php');
?>
<?php  
function getStateName($id,$conn)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['state_name'];		
}

function getRegionName($id,$conn)
{
	$query_sel = "SELECT region FROM state_master where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['region'];
}

function getVisitorDesignationID($id,$conn)
{
	$query_sel = "SELECT type_of_designation FROM visitor_designation_master where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();  		
		return $row['type_of_designation'];
}

function CheckMembership($registration_id,$conn)
{
	$sql = "SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' and issue_membership_certificate_expire_status='Y'";
	$result = $conn ->query($sql);
	$num_rows = $result->num_rows;
	if($num_rows>0)
	{
		return 'M';
	} else {
		return 'NM';
	}
}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['category']="";
  $_SESSION['visited_show']="";
  $_SESSION['designation']="";
  $_SESSION['state']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  $_SESSION['firm_type']="";
  $_SESSION['member_type']="";  
  $_SESSION['company_name']="";
  $_SESSION['company_pan_no']="";
  $_SESSION['fname']="";
  $_SESSION['lname']="";
  $_SESSION['email_id']="";
  $_SESSION['order_id']="";
  $_SESSION['visitor_approval']="";    
  header("Location: manage_visitor_reports.php?action=view");
} else {
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['category']=filter($_REQUEST['category']);
	$_SESSION['visited_show']=filter($_REQUEST['visited_show']);
	$_SESSION['designation']=filter($_REQUEST['designation']);
	$_SESSION['state']=filter($_REQUEST['state']);
	$_SESSION['from_date']=$_REQUEST['from_date'];
	$_SESSION['to_date']=$_REQUEST['to_date'];
	$_SESSION['firm_type']=$_REQUEST['firm_type'];
	$_SESSION['member_type']=$_REQUEST['member_type'];	
	$_SESSION['company_name']=filter($_REQUEST['company_name']);
	$_SESSION['company_pan_no']=filter($_REQUEST['company_pan_no']);
	$_SESSION['fname']=filter($_REQUEST['fname']);
	$_SESSION['lname']=filter($_REQUEST['lname']);
	$_SESSION['email_id']=filter($_REQUEST['email_id']);
	$_SESSION['order_id']=filter($_REQUEST['order_id']);	
	$_SESSION['visitor_approval']  =	$_REQUEST['visitor_approval'];
	}
}
?>

<?php
if(isset($_POST['export']))
{
	if($_SESSION['visitor_approval']=="")
	{
		$_SESSION['error_msg']="Please select Any Status";
	} else {
	
$table = $display = "";	
//if($_SESSION["region"]!='') { $pRegion=$_SESSION["region"]; } else { $pRegion="all"; }

$fn = "visitor_reports_".$pRegion. date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Date</td>
<td>Visitor PAN</td>
<td>Company PAN</td>
<td>Category</td>
<td>Company Name</td>
<td>First Name</td>
<td>Last Name</td>
<td>Designation</td>
<td>Address1</td>
<td>Address2</td>
<td>State</td>
<td>City</td>
<td>Region</td>
<td>Pincode</td>
<td>Company Tel</td>
<td>Company Mobile</td>
<td>Company Email</td>
<td>Image</td>
<td>Member/NonMember</td>
<td>Show visited</td>
<td>Order ID</td>
<td>Amount</td>
<td>Application Status</td>
<td>Payment Status</td>
<td>Payment Made for</td>
<td>Remarks For Admin</td>
</tr>';

	//$sql="select oh.visitor_id, oh.create_date as 'create_date', rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.land_line_no,rm.mobile_no,rm.email_id, oh.orderId, vd.badge_id,vd.bp_number,vd.name,vd.lname,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.photo, oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status' from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id where oh.payment_status='Y' and oh.status = '1' and oh.show='vbsm1' and oh.year='2021'";
	$sql="SELECT oh.visitor_id, oh.create_date as 'create_date',oh.orderId, rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.state,rm.land_line_no,rm.mobile_no,rm.email_id,rm.company_type,
    vd.bp_number,vd.name,vd.lname,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.photo,vd.category,vd.visitor_approval, 
	oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status',oh.`show`, oh.year
	from visitor_order_history oh 
	inner join registration_master rm on oh.registration_id=rm.id 
	inner join visitor_directory vd on oh.visitor_id=vd.visitor_id where 1";
	
	if($_SESSION['category']!="")
	{
		if($_SESSION['category']=="visitor"){
		$sql.=" ";
		} else {
		$sql.=" and vd.category ='".$_SESSION['category']."'";
		}
	}
	
	if($_SESSION['visited_show']!="")
	{
		$arr_string = explode("-",$_SESSION['visited_show']); 
		$show = $arr_string[0];
		$year = $arr_string[1];
	$sql.=" and oh.`show` ='".$show."' AND oh.year='".$year."'";
	}
	
	if($_SESSION['designation']!="")
	{
		$sql.=" and vd.`designation` ='".$_SESSION['designation']."'";
	}
	
	if($_SESSION['state']!="")
	{
		$sql.=" and rm.state ='".$_SESSION['state']."'";
	}
	
	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="From" && $_SESSION['to_date']!="To")
	{
	$sql.=" and oh.create_date BETWEEN '".date("Y-m-d",strtotime($_SESSION['from_date']))." 00:00:00' AND '".date("Y-m-d",strtotime($_SESSION['to_date']))." 23:59:59'";
	} 
	
	if($_SESSION['firm_type']!="")
	{
		$sql.=" and rm.company_type ='".$_SESSION['firm_type']."'";
	}
	
	if($_SESSION['company_name']!="")
	{
	$sql.=" and rm.company_name like '%".$_SESSION['company_name']."%'";
	}
	
	if($_SESSION['company_pan_no']!="")
	{
	$sql.=" and rm.company_pan_no ='".$_SESSION['company_pan_no']."'";
	}
	
	if($_SESSION['fname']!="")
	{
	$sql.=" and vd.name like '%".$_SESSION['fname']."%'";
	}
	
	if($_SESSION['lname']!="")
	{
	$sql.=" and vd.lname like '%".$_SESSION['lname']."%'";
	}
	
	if($_SESSION['email_id']!="")
	{
	$sql.=" and rm.email_id like '%".$_SESSION['email_id']."%'";
	}
	
	if($_SESSION['order_id']!="")
	{
	$sql.=" and orderId ='".$_SESSION['order_id']."'";
	}
	
	if($_SESSION['visitor_approval']!="")
	{ 
		if($_SESSION['visitor_approval']=='Y')
		{
		$sql.=" and vd.visitor_approval='Y' ";
		} else if($_SESSION['visitor_approval']=='P')
		{
			$sql.=" and vd.visitor_approval='P' ";
		} else {
			$sql.=" and vd.visitor_approval='D' ";
		}
	}	
	
	
	$attach=" order by oh.create_date desc"; 
	$sql.= "  ".$attach." "; 
	//echo $sql; exit;
	$result = $conn ->query($sql);
	$rCount = $result->num_rows;
	while($row = $result->fetch_assoc())
	{ 
		$registration_id=$row['id'];
		$payment_date = date("d-m-Y", strtotime($row['create_date']));
		$pan_no=$row['pan_no'];
		$company_pan_no=$row['company_pan_no'];
		$category=$row['category'];		
		$company_name=$row['company_name'];
		
		$orderid=$row['orderId'];
		
		$payment_status=$row['payment_status'];
		$name = strtoupper($row['name']);
		$lname = strtoupper($row['lname']);
		
		$designation=getVisitorDesignationID($row['designation'],$conn);
		$land_line_no=$row['land_line_no'];
		$c_mobile_no=$row['mobile_no'];
		$c_email_id=$row['email_id'];		

		$photo="https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$row['photo'];
		if($row['payment_made_for']=="vbsm" || $row['payment_made_for']=="vbsm2"){
		$payment_made_for = "Virtual";
		} else { 
		$payment_made_for = $row['payment_made_for'];
		}
		$amount=$row['Amount'];
		
		$show_visited = strtoupper($row['show']).'-'.$row['year'];
		$visitor_approval = $row['visitor_approval'];

		$getAddress ="SELECT * FROM `registration_master` WHERE `id` = '$registration_id'";
		$getAddressResult = $conn ->query($getAddress);
		$getAddressRow = $getAddressResult->fetch_assoc();
		$address_line1=strtoupper($getAddressRow['address_line1']);
		$address_line2=strtoupper($getAddressRow['address_line2']);
		$city=strtoupper($getAddressRow['city']);
		$country=strtoupper($getAddressRow['country']);
		$state=strtoupper(getStateName($getAddressRow['state'],$conn));
		$region = strtoupper(getRegionName($getAddressRow['state'],$conn));
		$pincode=$getAddressRow['pin_code'];
		
		$getapplication ="SELECT * FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$orderid' AND payment_status='Y'";
		$getApplicationResult = $conn ->query($getapplication);
		$getApplicationRow= $getApplicationResult->fetch_assoc();
		$type_of_member = $getApplicationRow['type_of_member']; 
		$delivery_id = $getApplicationRow['delivery_id'];
		$sales_order_no = $getApplicationRow['sales_order_no'];

		/*if($type_of_member == "M"){
		$addflag = "SELECT * FROM `communication_address_master` WHERE `address_identity`='CTC' and `registration_id`='$registration_id' AND id='$delivery_id'";
		$deliveryQuery = $conn ->query($addflag);
		$deliveryResult = $deliveryQuery->fetch_assoc();
		$d_address1=strtoupper($deliveryResult['address1']);
		$d_address2=strtoupper($deliveryResult['address2']);
		$d_city=strtoupper($deliveryResult['city']);
		$d_country=strtoupper($deliveryResult['country']);
		$d_state=strtoupper(getStateName($deliveryResult['state'],$conn));
		$d_region=strtoupper(getRegionName($deliveryResult['state'],$conn));
		$d_pincode=$deliveryResult['pincode'];
		} else {
		$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id' AND id='$delivery_id'";
		$deliveryQuery = $conn ->query($addflag);
		$deliveryResult = $deliveryQuery->fetch_assoc();
		$d_address1=strtoupper($deliveryResult['address1']); if($d_address1==""){ $d_address1=$address_line1; } else { $d_address1; } 
		$d_address2=strtoupper($deliveryResult['address2']); if($d_address2==""){ $d_address2=$address_line2; } else { $d_address2; } 
		$d_city=strtoupper($deliveryResult['city']);		 if($d_city==""){ $d_city=$city; } else { $d_city; } 
		$d_country=strtoupper($deliveryResult['country']);	 if($d_country==""){ $d_country=$country; } else { $d_country; } 
		$d_state=strtoupper(getStateName($deliveryResult['state'],$conn)); if($d_state==""){ $d_state=$state; } else { $d_state; } 
		$d_region=strtoupper(getRegionName($deliveryResult['state'],$conn));
		$d_pincode=$deliveryResult['pin_code'];				 if($d_pincode==""){ $d_pincode=$pincode; } else { $d_pincode; } 
		}
		
		if($d_address1==""){ $d_address1=$address_line1; }
		if($d_address2==""){ $d_address2=$address_line2; }
		if($d_city==""){ $d_city=$city; }
		if($d_state==""){ $d_state=$state; }
		if($d_region==""){ $d_region = strtoupper(getRegionName($getAddressRow['state'],$conn)); }
		if($d_pincode==""){ $d_pincode = $pincode; }
		*/
		
		$table .= '<tr>
		<td>'.$payment_date.'</td>
		<td>'.$pan_no.'</td>
		<td>'.$company_pan_no.'</td>
		<td>'.$category.'</td>
		<td>'.$company_name.'</td>
		<td>'.$name.'</td>
		<td>'.$lname.'</td>
		<td>'.$designation.'</td>
		<td>'.$address_line1.'</td>
		<td>'.$address_line2.'</td>
		<td>'.$state.'</td>
		<td>'.$city.'</td>
		<td>'.$region.'</td>
		<td>'.$pincode.'</td>
		<td>'.$land_line_no.'</td>
		<td>'.$c_mobile_no.'</td>
		<td>'.$c_email_id.'</td>
		<td>'.$photo.'</td>
		<td>'.$type_of_member.'</td>
		<td>'.$show_visited.'</td>
		<td>'.$orderid.'</td>
		<td>'.$amount.'</td>
		<td>'.$visitor_approval.'</td>
		<td>'.$payment_status.'</td>
		<td>'.$payment_made_for.'</td>
		<td></td>
		
		</tr>';
		
}
$table .= $display;
$table .= '</table>';

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
exit;
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Visitor || GJEPC ||</title>
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

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>
<div class="clear"></div>
<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Manage Visitor</div></div>

<div id="main">
	<div class="content">
    <div class="content_head">Manage Visitor &nbsp; &nbsp;
    <?php if($_REQUEST['action']=='view_details'){ ?>
    <div style="float:right; padding-right:10px; font-size:12px;"><a href="manage_visitor_reports.php?action=view">Back to Visitor</a></div>
    <?php } ?>
    </div>
<div class="content_details1">
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="POST"> 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
<tr>
<tr>
    <td><strong>Category</strong></td>        
    <td>
	<select name="category" class="input_txt">
      <option value="">Select Category</option>
      <option value="VIP" <?php if($_SESSION['category']=='VIP'){echo "selected";}?>>VIP</option>
      <option value="VVIP" <?php if($_SESSION['category']=='VVIP'){echo "selected";}?>>VVIP</option>   
      <option value="Elite" <?php if($_SESSION['category']=='Elite'){echo "selected";}?>>ELITE</option>   
      <option value="visitor" <?php if($_SESSION['category']=='visitor'){echo "selected";}?>>Registered Visitors</option>   
    </select>
	</td>
</tr>
<tr>
    <td><strong>Show Visited </strong></td>        
    <td>
	<select name="visited_show" class="input_txt">
      <option value="">Select Show</option>
      <option value="iijs-2019" <?php if($_SESSION['visited_show']=='iijs-2019'){echo "selected";}?>>IIJS 2019</option>
      <!--<option value="signature-2019" <?php if($_SESSION['visited_show']=='signature-2019'){echo "selected";}?>>SIGNATURE 2019</option>-->
      <option value="vbsm-2020" <?php if($_SESSION['visited_show']=='vbsm-2020'){echo "selected";}?>>IIJS Virtual 2020</option>
      <option value="vbsm2-2021" <?php if($_SESSION['visited_show']=='vbsm2-2021'){echo "selected";}?>>IIJS Virtual 2021</option>
    </select>
	</td>
</tr>
<tr>
    <td><strong>Designation</strong></td>        
    <td>
	<select name="designation" class="input_txt">
      <option value="">Select Designation</option>
      <option value="19" <?php if($_SESSION['designation']=='19'){echo "selected";}?>>Partners</option>
      <option value="18" <?php if($_SESSION['designation']=='18'){echo "selected";}?>>Properitor</option>
      <option value="23" <?php if($_SESSION['designation']=='23'){echo "selected";}?>>CEO</option>
	  <option value="26" <?php if($_SESSION['designation']=='26'){echo "selected";}?>>MD</option>
      <option value="20" <?php if($_SESSION['designation']=='20'){echo "selected";}?>>Director</option>
      <option value="21" <?php if($_SESSION['designation']=='21'){echo "selected";}?>>Chairman</option>     
    </select>
	</td>
</tr>  
<tr>
    <td><strong>State</strong></td>        
    <td>
	<select name="state" id="state" class="input_txt">
		<option value="">Select State</option>
		<?php 
		$query = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
		while($result= $query->fetch_assoc()){ ?>
		<option value="<?php echo $result['state_code'];?>"  <?php if($result['state_code']==$state){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
		<?php } ?>
	</select> 
	</td>
</tr>
<tr>
    <td><strong>Date</strong></td>
    <td>
	<input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "From";}else{echo $_SESSION['from_date'];}?>"  class="input_date" readonly/>
    <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date" readonly/></td>
</tr>
<tr>
    <td><strong>Firm Type</strong></td>
    <td>
    <select name="firm_type" id="firm_type" class="input_txt">
    <option value="">Please Select Firm Type</option>	
    <?php 
	$sqlF="select * from type_of_firm_master where status='1'";
	$result = $conn ->query($sqlF);
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

<!--<tr>
  <td><strong>Member Type</strong></td>
  <td>
    <select name="member_type" class="input_txt">
    <option value="">Please Select Member Type</option>
	<option value="M" <?php if($_SESSION['member_type']=='M'){echo "selected";}?>>Member</option>
    <option value="NM" <?php if($_SESSION['member_type']=='NM'){echo "selected";}?>>NonMember</option> 	  
	</select>
  </td>
</tr>-->

<tr>
    <td><strong>Application Status</strong></td>        
    <td>
	<select name="visitor_approval" class="input_txt">
      <option value="">Select Status</option>
      <option value="Y" <?php if($_SESSION['visitor_approval']=='Y'){echo "selected";}?>>Application Approved</option>
	  <option value="P" <?php if($_SESSION['visitor_approval']=='P'){echo "selected";}?>>Application Pending</option>
      <option value="D" <?php if($_SESSION['visitor_approval']=='D'){echo "selected";}?>>Application Disapproved</option>      
    </select>
	</td>
</tr> 

<tr>
    <td width="19%"><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" autocomplete="off"/></td>
</tr>     
<tr>
  <td><strong>Company PAN Number</strong></td>
  <td><input type="text" name="company_pan_no" id="company_pan_no" maxlength="10" class="input_txt" value="<?php echo $_SESSION['company_pan_no'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>First Name</strong></td>
  <td><input type="text" name="fname" id="fname" class="input_txt" value="<?php echo $_SESSION['fname'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Last Name</strong></td>
  <td><input type="text" name="lname" id="lname" class="input_txt" value="<?php echo $_SESSION['lname'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Company Email</strong></td>
  <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $_SESSION['email_id'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Order ID</strong></td>
  <td><input type="text" name="order_id" id="order_id" class="input_txt" value="<?php echo $_SESSION['order_id'];?>" autocomplete="off"/></td>
</tr>
<td>&nbsp;</td>
<td>
<input type="submit" name="Submit" value="Search" class="input_submit"/>
<input type="submit" name="Reset" value="Reset" class="input_submit" />
<?php if(isset($_POST['Submit'])){?><input type="submit" name="export" value="Export" class="input_submit" /><?php } ?>
</td>
</tr>	
</table>
</form>      
</div>

<?php  if($_REQUEST['action']=='view') { 
		//$_SESSION['submit'] = $_POST['Submit'];
	  // if(isset($_POST['Submit'])){ ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
    <td>Company Name</td>
    <td>Pan Number</td>
    <td>GST Number</td>
    <td>Email</td>
	</tr>
    
    <?php 	
 	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
	
    $i=1;
	$sql="SELECT oh.visitor_id, oh.create_date as 'create_date',oh.orderId, rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.state,rm.land_line_no,rm.mobile_no,rm.email_id,rm.company_type,
    vd.bp_number,vd.name,vd.lname,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.photo,vd.category,vd.visitor_approval, 
	oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status',oh.`show`, oh.year
	from visitor_order_history oh 
	inner join registration_master rm on oh.registration_id=rm.id 
	inner join visitor_directory vd on oh.visitor_id=vd.visitor_id where 1";
	
	if($_SESSION['category']!="")
	{
		if($_SESSION['category']=="visitor"){
		$sql.="";
		} else {
		$sql.=" and vd.category ='".$_SESSION['category']."'";
		}
	}
	
	if($_SESSION['visited_show']!="")
	{
		$arr_string = explode("-",$_SESSION['visited_show']); 
		$show = $arr_string[0];
		$year = $arr_string[1];
	$sql.=" and oh.`show` ='".$show."' AND oh.year='".$year."'";
	}
	
	if($_SESSION['designation']!="")
	{
		$sql.=" and vd.`designation` ='".$_SESSION['designation']."'";
	}
	
	if($_SESSION['state']!="")
	{
		$sql.=" and rm.state ='".$_SESSION['state']."'";
	}
	
	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="From" && $_SESSION['to_date']!="To")
	{
	$sql.=" and oh.create_date BETWEEN '".date("Y-m-d",strtotime($_SESSION['from_date']))." 00:00:00' AND '".date("Y-m-d",strtotime($_SESSION['to_date']))." 23:59:59'";
	} 
	
	if($_SESSION['firm_type']!="")
	{
		$sql.=" and rm.company_type ='".$_SESSION['firm_type']."'";
	}
	
	if($_SESSION['company_name']!="")
	{
	$sql.=" and rm.company_name like '%".$_SESSION['company_name']."%'";
	}
	
	if($_SESSION['company_pan_no']!="")
	{
	$sql.=" and rm.company_pan_no ='".$_SESSION['company_pan_no']."'";
	}
	
	if($_SESSION['fname']!="")
	{
	$sql.=" and vd.name like '%".$_SESSION['fname']."%'";
	}
	
	if($_SESSION['lname']!="")
	{
	$sql.=" and vd.lname like '%".$_SESSION['lname']."%'";
	}
	
	if($_SESSION['email_id']!="")
	{
	$sql.=" and rm.email_id like '%".$_SESSION['email_id']."%'";
	}
	
	if($_SESSION['order_id']!="")
	{
	$sql.=" and orderId ='".$_SESSION['order_id']."'";
	}
	
	if($_SESSION['visitor_approval']!="")
	{ 
		if($_SESSION['visitor_approval']=='Y')
		{
		$sql.=" and vd.visitor_approval='Y' ";
		} else if($_SESSION['visitor_approval']=='P')
		{
			$sql.=" and vd.visitor_approval='P' ";
		} else {
			$sql.=" and vd.visitor_approval='D' ";
		}
	}	
	
	
	$attach=" order by oh.create_date desc"; 
	$sql.= "  ".$attach." "; 
	echo $sql; 

	$result1=$conn ->query($sql);
	$rCount= $result1->num_rows;	
	$sql1= $sql." limit $start, $limit";
	$result=$conn ->query($sql1);

    if($rCount>0)
    {	
	while($rows = $result->fetch_assoc())
	{	
    ?>  
 	<tr>
    <td><?php echo strtoupper($rows['company_name']);?></td>
	<td><?php echo filter($rows['company_pan_no']);?></td>
    <td><?php echo filter($rows['company_gstn']);?></td>   
    <td><?php echo filter($rows['email_id']);?></td>
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
    <?php  }  	?>
</table>
</div>

<?php } ?> 
<?php //} ?> 
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
<div class="pages_1">Total number of Participant: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'manage_visitor_reports.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>