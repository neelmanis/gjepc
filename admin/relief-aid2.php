<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
include('../db.inc.php');
include('../functions.php');

$adminRegion = $_SESSION['curruser_region_id'];
$region = gotStatesName($adminRegion,$conn);

$adminRegionWiseAccess = rtrim($_SESSION['curruser_region_access'], ',');
$getRegionAccess = gotRegionwiseAccess($adminRegionWiseAccess,$conn);
?>

<?php
$adminID	=	intval(filter($_SESSION['curruser_login_id']));
if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
//	echo '<pre>'. print_r($_POST); exit;
	 $id = intval(filter($_REQUEST['id']));
	$application_status = filter($_REQUEST['application_status']);
	$remark = filter($_REQUEST['remark']);
	if($application_status == "Y")		{ $disapprove_reason = ""; }
	else if($application_status == "P") { $disapprove_reason = ""; }
	else { $application_status == "C"; }
	
	$disapprove_reason = filter($_REQUEST['disapprove_reason']);
	
	$sqlx = "UPDATE `relief_aid` SET `adminId`='$adminID',`admin_update_date`=NOW(),`application_status`='$application_status',`disapprove_reason`='$disapprove_reason',remark='$remark' WHERE id='$id'";
	$resultx = $conn ->query($sqlx);
	if($resultx){
	echo "<meta http-equiv=refresh content=\"0;url=relief-aid.php?action=edit&id=$id\">";
	} else { 
		echo '<script language="javascript">';
		echo 'alert("Something Error!! Kindly Check again")';
		echo '</script>'; 
		}
}
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['fname']="";
  $_SESSION['mobile_no']="";
  $_SESSION['region']="";
  $_SESSION['application_status']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";  
  header("Location: relief-aid.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['fname']=filter($_REQUEST['fname']);
	$_SESSION['mobile_no']=filter($_REQUEST['mobile_no']);
	$_SESSION['application_status']  =	$_REQUEST['application_status'];
	$_SESSION['region']=$_REQUEST['region'];
	$_SESSION['from_date']=$_REQUEST['from_date'];
	$_SESSION['to_date']=$_REQUEST['to_date'];
	}
}
?>

<?php
if(isset($_POST['export']))
{
	if($_SESSION['application_status']=="" && $_SESSION['region']=="")
	{
		$_SESSION['error_msg']="Please select Any Status";
	} else {
	
$table = $display = "";	
if($_SESSION["region"]!='') { $pRegion=$_SESSION["region"]; } else { $pRegion="all"; }
$fn = "relief-aid_".$pRegion. date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Date</td>
<td>Modified Date</td>
<td>Registration No</td>
<td>Region</td>
<td>Worker Type</td>
<td>Parichay Card</td>
<td>Name</td>
<td>Father Name</td>
<td>Gender</td>
<td>Birth Date</td>
<td>Address</td>
<td>City</td>
<td>State</td>
<td>Pincode</td>
<td>Mobile</td>
<td>OTP Verified</td>
<td>Email</td>
<td>Owner Name 1</td>
<td>Owner Mobile 1</td>
<td>Owner Name 2</td>
<td>Owner Mobile 2</td>
<td>Industry Type</td>
<td>Nature of Work</td>
<td>Member of Any Registered Association</td>
<td>Name of Registered Association</td>
<td>AADHAR NO</td>
<td>BANK NAME</td>
<td>BANK BRANCH</td>
<td>BANK IFSC</td>
<td>BANK Account No</td>
<td>Passbook Copy</td>
<td>ID Copy</td>
<td>Statement 1</td>
<td>Statement 2</td>
<td>Statement 3</td>
<td>Application Status</td>
<td>By Admin</td>
<td>Admin Modified Date</td>
<td>Reject Reason</td>
<td>Remark</td>
</tr>';

	$sql="SELECT * FROM `relief_aid` WHERE 1";
	if($_SESSION['fname']!="")
	{
	$sql.=" and fname like '%".$_SESSION['fname']."%'";
	}
	
	if($_SESSION['mobile_no']!="")
	{
	$sql.=" and mobile_no like '%".$_SESSION['mobile_no']."%'";
	}
	
	if($_SESSION['application_status']!="")
	{ 
		if($_SESSION['application_status']=='Y')
		{
		$sql.=" and application_status='Y' ";
		}else if($_SESSION['application_status']=='P')
		{
			$sql.=" and application_status='P' ";
		}else{
			$sql.=" and application_status='C' ";
		}
	}
  
	if($_SESSION["region"]!="")
	{
	$getRegion = $_SESSION["region"];
	$myRegion = gotStatesName($getRegion,$conn);
	$sql.=" and state IN (".$myRegion.")";
	} else {
		if($_SESSION['curruser_role']=="Admin")
		{
		  $sql.=" and state IN (".$getRegionAccess.") ";
		}
	}
	
	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="From" && $_SESSION['to_date']!="To")
	{
   // $sql.=" and mod_date between '".date("Y-m-d",strtotime($_SESSION['from_date']))."' and '".date("Y-m-d",strtotime($_SESSION['to_date']))."'";
	$sql.=" and mod_date between '".date("Y-m-d",strtotime($_SESSION['from_date']))." 00:00:00' and '".date("Y-m-d",strtotime($_SESSION['to_date']))." 23:59:59'";
	}
	
	$sql.= "  ".$attach." "; 
//	echo $sql;
	$result = $conn ->query($sql);
	while($row2 = $result->fetch_assoc())
	{	
			$post_date = $row2['post_date'];
			$mod_date = $row2['mod_date'];
			$id = $row2['id'];
			$worker_type=filter($row2['worker_type']);
			$fname=filter($row2['fname']);
			$father_name=filter($row2['father_name']);
			$gender=filter($row2['gender']);
			$birth_date=filter($row2['birthdate']);
			$address=filter($row2['address']);
			$city=filter($row2['city']);
			$state=filter($row2['state']);
			$region=filter(gotStateRegionName($row2['state'],$conn));
			$pincode=filter($row2['pincode']);

			$mobile_no=filter($row2['mobile_no']);
			if($row2['otpVerified']==1){ $otpVerified='VERIFIED';}
			if($row2['otpVerified']==0){ $otpVerified='NOT VERIFIED';}
			$email=filter($row2['email']);	
			$owner_name1=filter($row2['owner_name1']);
			$owner_mobile1=filter($row2['owner_mobile1']);					
			$owner_name2=filter($row2['owner_name2']);			
			$owner_mobile2=filter($row2['owner_mobile2']);
			
			$industry_type=filter($row2['industry_type']);
			$nature_work=$row2['nature_work'];
			
			$member_of_any_other_organisation=filter($row2['member_of_any_other_organisation']);
			$name_of_organisation=filter($row2['name_of_organisation']);
			$bank_name=filter($row2['bank_name']);
			$bank_branch=filter($row2['bank_branch']);
			$bank_ifsc=filter($row2['bank_ifsc']);
			$bank_account_no=filter($row2['bank_account_no']);
			$aadhar_no=$row2['aadhar_no'];
			$parichay_card_no=filter($row2['parichay_card_no']);
			
			$upload_bank_passbook=$row2['upload_bank_passbook'];
			$id_scan_copy=$row2['id_scan_copy'];
			$statment_1=$row2['statement_1'];
			$statment_2=$row2['statement_2'];
			$statment_3=$row2['statement_3'];
			
			$application_getstatus=filter($row2['application_status']);
			if($application_getstatus == "Y"){ $application_status="APPROVED"; }
			if($application_getstatus == "P"){ $application_status="PENDING"; }
			if($application_getstatus == "C"){ $application_status="REJECT"; }
			$byAdmin =filter(getAdminName($row2['adminId'],$conn));
			$disapprove_reason=filter($row2['disapprove_reason']);
			$adminModifyDate=filter($row2['admin_update_date']);
			$remark=filter($row2['remark']);
	
$table .= '<tr>
<td>'.$post_date.'</td>
<td>'.$mod_date.'</td>
<td>GJEPC/CARE/00000'.$id.'</td>
<td>'.$region.'</td>
<td>'.$worker_type.'</td>
<td>'.$parichay_card_no.'</td>
<td>'.$fname.'</td>
<td>'.$father_name.'</td>
<td>'.$gender.'</td>
<td>'.$birth_date.'</td>
<td>'.$address.'</td>
<td>'.$city.'</td>
<td>'.getState($state,$conn).'</td>
<td>'.$pincode.'</td>
<td>'.$mobile_no.'</td>
<td>'.$otpVerified.'</td>
<td>'.$email.'</td>
<td>'.$owner_name1.'</td>
<td>'.$owner_mobile1.'</td>
<td>'.$owner_name2.'</td>
<td>'.$owner_mobile2.'</td>
<td>'.$industry_type.'</td>
<td>'.$nature_work.'</td>
<td>'.$member_of_any_other_organisation.'</td>
<td>'.$name_of_organisation.'</td>
<td>'.$aadhar_no.'</td>
<td>'.$bank_name.'</td>
<td>'.$bank_branch.'</td>
<td>'.$bank_ifsc.'</td>
<td>'.'\''.$bank_account_no.'</td>
<td>'.$upload_bank_passbook.'</td>
<td>'.$id_scan_copy.'</td>
<td>'.$statment_1.'</td>
<td>'.$statment_2.'</td>
<td>'.$statment_3.'</td>
<td>'.$application_status.'</td>
<td>'.$byAdmin.'</td>
<td>'.$adminModifyDate.'</td>
<td>'.$disapprove_reason.'</td>
<td>'.$remark.'</td>
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
<title>Manage Participant ||GJEPC||</title>
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

<script>
$(document).ready(function(){
$('#disapproval').hide();

$('#disapprove').click(function(){
//alert('disapprove');
		$('#disapproval').show();
});
$('#approve').click(function(){
//alert('approve');
		$('#disapproval').hide();
});
$('#pending').click(function(){
//alert('pending');
		$('#disapproval').hide();
});
});
</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>
<div class="clear"></div>
<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Manage Registration</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage Participant &nbsp;&nbsp;
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="relief-aid.php?action=view">Back to Participant</a></div>
        <?php } ?>
        <!--<a href="relief_export.php">Export Participant List</a>&nbsp;&nbsp;-->
		<?php if($adminID=='78' || $adminID=='1'){ ?><a href="relief-aid-csv-dump.php">Import Participant List</a> <?php } ?>
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
    <td colspan="11" >Search Options</td>
</tr>
<tr>
    <td width="19%" ><strong>Mobile NO</strong></td>
    <td width="81%"><input type="text" name="mobile_no" id="mobile_no" class="input_txt" value="<?php echo $_SESSION['mobile_no'];?>" maxlength="10" autocomplete="off"/></td>
</tr>       
<tr>
  <td><strong>Name</strong></td>
  <td><input type="text" name="fname" id="fname" class="input_txt" value="<?php echo $_SESSION['fname'];?>" autocomplete="off"/></td>
</tr>
<tr>
    <td><strong>Application Status</strong></td>        
    <td>
	<select name="application_status" class="input_txt-select" >
      <option value="">Select Status</option>
      <option value="Y" <?php if($_SESSION['application_status']=='Y'){echo "selected";}?>>Application Approved</option>
	  <option value="P" <?php if($_SESSION['application_status']=='P'){echo "selected";}?>>Application Pending</option>
      <option value="C" <?php if($_SESSION['application_status']=='C'){echo "selected";}?>>Application Disapproved</option>      
    </select>
	</td>
</tr> 
<tr>
    <td><b>Region</b></td>
    <td>
    <select name="region">
        <option value="">---Select  Region---</option>
    	<?php 
		if($_SESSION['curruser_role']=="Admin")
		{
			$result_string = "'" . str_replace(",", "','", $adminRegionWiseAccess) . "'";
			$region_query = "select * from region_master where region_name IN(".$result_string.")";
		} else {
			$region_query = "select * from region_master";
		}
		$execute_region = $conn ->query($region_query);
		while($show_region = $execute_region->fetch_assoc()){?>
    	<option value="<?php echo $show_region["region_name"]; ?>" <?php if($_SESSION["region"]==$show_region["region_name"]) echo "selected"; ?>><?php echo $show_region["region_name"]; ?></option>
    	<?php	}	?>
    </select>
    </td>
</tr>
<tr>
    <td><strong>Date</strong></td>
    <td>
	<input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "From";}else{echo $_SESSION['from_date'];}?>"  class="input_date" readonly/>
    <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date" readonly/></td>
</tr>
<td>&nbsp;</td>
<td>
<input type="submit" name="Submit" value="Search" class="input_submit"/> 
<input type="submit" name="Reset" value="Reset"  class="input_submit" />
<input type="submit" name="export" value="Export" class="input_submit" />
</td>
</tr>	
</table>
</form>      
</div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">Registration No.</a></td>
		<td width="10%">Date</td>
		<td width="10%">Modified Date</td>
		<td width="20%">Name</td>
		<td width="20%">Mobile No</td>
        <td width="25%">State</td>       
        <td width="15%">Email ID</td>
        <td width="15%">OTP Status</td>
		<td width="10%">Application Status</td>		
		<td width="10%">Action</td>		
    </tr>
    
    <?php 	
 	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    $sql="SELECT * FROM `relief_aid` WHERE 1";
	
	if($_SESSION['fname']!="")
	{
	$sql.=" and fname like '%".$_SESSION['fname']."%'";
	}
	
	if($_SESSION['mobile_no']!="")
	{
	$sql.=" and mobile_no like '%".$_SESSION['mobile_no']."%'";
	}
	
	if($_SESSION['application_status']!="")
	{ 
		if($_SESSION['application_status']=='Y')
		{
		$sql.=" and application_status='Y' ";
		}else if($_SESSION['application_status']=='P')
		{
			$sql.=" and application_status='P' ";
		}else{
			$sql.=" and application_status='C' ";
		}
	}
  
	if($_SESSION["region"]!="")
	{
	$getRegion = $_SESSION["region"];
	$myRegion = gotStatesName($getRegion,$conn);
	$sql.=" and state IN (".$myRegion.")";
	} else {
		if($_SESSION['curruser_role']=="Admin")
		{
		  $sql.=" and state IN(".$getRegionAccess.") ";
		}
	}
	
	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="From" && $_SESSION['to_date']!="To")
	{
    //$sql.=" and mod_date between '".date("Y-m-d",strtotime($_SESSION['from_date']))."' and '".date("Y-m-d",strtotime($_SESSION['to_date']))."'";
	$sql.=" and mod_date between '".date("Y-m-d",strtotime($_SESSION['from_date']))." 00:00:00' and '".date("Y-m-d",strtotime($_SESSION['to_date']))." 23:59:59'";
	}
	
	$sql.= "  ".$attach." ";
//	echo $sql;
	$result1=$conn ->query($sql);
	$rCount= $result1->num_rows;	
	$sql1= $sql." limit $start, $limit";
	$result=$conn ->query($sql1);

    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td>GJEPC/CARE/00000<?php echo $row['id'];?></td>
		<td align="left"><?php echo $row['post_date']; ?></td>	
		<td align="left"><?php echo $row['mod_date']; ?></td>	
		<td><?php echo strtoupper(filter($row['fname']));?></td>
		<td><?php echo strtoupper(filter($row['mobile_no']));?></td>
        <td><?php echo strtoupper(filter(getState($row['state'],$conn)));?></td>           
        <td align="left"><?php echo filter($row['email']);?></td>
        <td align="left">
		<?php if($row['otpVerified']=='1'){ echo '<span style="color:green">Verified</span>'; } 
		elseif($row['otpVerified']=='0'){ echo '<span style="color:red">Not Verified</span>'; } 
		else { echo '<span style="color:red">X</span>'; }?>
		</td>
		<td align="left">
		<?php 
		if($row['application_status']=='P'){ echo 'PENDING'; }
		elseif($row['application_status']=='Y'){ echo '<span style="color:green">APPROVED</span>'; } 
		elseif($row['application_status']=='D'){ echo '<span style="color:red">DISAPPROVED</span>'; } 
		elseif($row['application_status']=='U'){ echo '<span style="color:red">UPDATED</span>'; } 
		else { echo '<span style="color:red">X</span>'; } ?>
		</td> 		
       
        <!--<td align="left"><a href="relief-aid.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>-->
	<!--<td align="left"><a href="printBadges.php?action=print&id=<?php echo $row['id']?>" target="_blank"><img src="images/print.png" title="Print" border="0" /></a></td>-->
		<td align="left"><a href="relief-aid.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" title="Edit" border="0" /></a></td>
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
<?php echo pagination($limit,$page,'relief-aid.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = $conn ->query("SELECT * FROM relief_aid where id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{	
			$worker_type=filter($row2['worker_type']);
			$fname=filter($row2['fname']);
			$father_name=filter($row2['father_name']);
			$gender=filter($row2['gender']);
			$birth_date=filter($row2['birthdate']);
			$address=filter($row2['address']);
			$city=filter($row2['city']);
			$state=filter($row2['state']);
			$pincode=filter($row2['pincode']);

			$mobile_no=filter($row2['mobile_no']);
			$otpVerified=filter($row2['otpVerified']);
			$email=filter($row2['email']);	
			$owner_name1=filter($row2['owner_name1']);
			$owner_mobile1=filter($row2['owner_mobile1']);					
			$owner_name2=filter($row2['owner_name2']);			
			$owner_mobile2=filter($row2['owner_mobile2']);
			
			$industry_type=filter($row2['industry_type']);
			$nature_work=$row2['nature_work'];
			
			$member_of_any_other_organisation=filter($row2['member_of_any_other_organisation']);
			$name_of_organisation=filter($row2['name_of_organisation']);
			$bank_name=filter($row2['bank_name']);
			$bank_branch=filter($row2['bank_branch']);
			$bank_ifsc=filter($row2['bank_ifsc']);
			$bank_account_no=filter($row2['bank_account_no']);
			$aadhar_no=filter($row2['aadhar_no']);
			$parichay_card_no=filter($row2['parichay_card_no']);
			
			$upload_bank_passbook=$row2['upload_bank_passbook'];
			$statement_1=$row2['statement_1'];
			$statement_2=$row2['statement_2'];
			$statement_3=$row2['statement_3'];
			$id_scan_copy=$row2['id_scan_copy'];
			
			$approval=filter($row2['status_approval']);
			$application_status=filter($row2['application_status']);
			$disapprove_reason=filter($row2['disapprove_reason']);
			$remark=filter($row2['remark']);
		
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"/>
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Edit Form </td>
    </tr>
	<tr>
       <td class="content_txt">Photo of Passbook </td>      
       <td>
	    <div>
	    <?php
		$passbook_ext =  pathinfo($upload_bank_passbook, PATHINFO_EXTENSION);
		if($upload_bank_passbook=="")
		{
		    echo "<img src='images/user_pic.jpg' width='100' height='100' />";
		} else { ?>
		<div class="fancyDemo"><p align="left">Passbook <a rel="group" href="../relief/passbook/<?php echo $upload_bank_passbook;?>"></p>
		<img src='../relief/passbook/<?php echo $upload_bank_passbook;?>' width='100' height='100'/></a>
		<?php if($passbook_ext == "pdf" ||  $passbook_ext == "PDF"){ ?><img src="images/pdf_icon.png"/><?php } ?>
		</div>
		<?php } ?>
		</div>
		<div>
	    <?php
		$statement_1_ext =  pathinfo($statement_1, PATHINFO_EXTENSION);
		if($statement_1=="")
		 {
		    echo " <p align='left'>Statement 1  <img src='images/user_pic.jpg' width='100' height='100' /></p>";
		 } else { ?>
		<div class="fancyDemo"><p align="left">Statement 1 <a rel="group" href="../relief/statement_1/<?php echo $statement_1;?>"></p>
		<img src='../relief/statement_1/<?php echo $statement_1;?>' width='100' height='100'/></a>
		<?php if($statement_1_ext == "pdf" ||  $statement_1_ext == "PDF"){ ?><img src="images/pdf_icon.png"/><?php } ?>
		</div>
		<?php } ?>
		</div>
		<div>
	    <?php 
		$statement_2_ext =  pathinfo($statement_2, PATHINFO_EXTENSION);
		 if($statement_2=="")
		 {
		    echo "<p align='left'>Statement 2 <img src='images/user_pic.jpg' width='100' height='100' /></p>";
		 } else { ?>
		<div class="fancyDemo"> <p align="left">Statement 2 <a rel="group" href="../relief/statement_2/<?php echo $statement_2;?>"></p>
		<img src='../relief/statement_2/<?php echo $statement_2;?>' width='100' height='100'/></a>
		<?php if($statement_2_ext == "pdf" ||  $statement_2_ext == "PDF"){ ?><img src="images/pdf_icon.png"/><?php } ?>
		</div>
		<?php } ?>
		</div>
		<div>
	    <?php 
		$statement_3_ext =  pathinfo($statement_3, PATHINFO_EXTENSION);
		 if($statement_3=="")
		 {
		    echo "<p align='left'> Statement 3 <img src='images/user_pic.jpg' width='100' height='100' /></p>";
		 } else { ?>
		<div class="fancyDemo"> <p align="left">Statement 3 <a rel="group" href="../relief/statement_3/<?php echo $statement_3;?>"></p>
		<img src='../relief/statement_3/<?php echo $statement_3;?>' width='100' height='100'/></a>
		<?php if($statement_3_ext == "pdf" ||  $statement_3_ext == "PDF"){ ?><img src="images/pdf_icon.png"/><?php } ?>
		</div>
		<?php } ?>
		</div>
       </td>
	 </tr>
	 <tr>
       <td class="content_txt">Photo of Aadhar Card</td>      
       <td>
	    <?php 
		$aadhar_ext =  pathinfo($id_scan_copy, PATHINFO_EXTENSION);
		 if($id_scan_copy=="")
		 {
		    echo "<img src='images/user_pic.jpg' width='100' height='100' />";
		 } else { ?>
		<div class="fancyDemo"> <a rel="group" href="../relief/scan_copy/<?php echo $id_scan_copy;?>">
		<img src='../relief/scan_copy/<?php echo $id_scan_copy;?>' width='100' height='100'/></a>
		<?php if($aadhar_ext == "pdf" ||  $aadhar_ext == "PDF"){ ?><img src="images/pdf_icon.png"/><?php } ?>
		</div>
		<?php } ?>
       </td>
	 </tr>
	 <tr>
		<td class="content_txt">Wages Worker?</td>
		<td colspan="2">
		<input type='radio' name='worker_type' id='worker_type' value='V' <?php if($worker_type=='YES'){ echo "checked='checked'"; }?>/>YES
		<input type='radio' name='worker_type' id='worker_type' value='M' <?php if($worker_type=='NO'){ echo "checked='checked'"; }?>/>NO
		</td>
	</tr>
	<tr>
       <td class="content_txt" width="15%">Name </td>
       <td><input type="text" class="input_txt" value="<?php echo $fname; ?>" readonly="readonly"/></td>
     </tr>
	<tr>
       <td class="content_txt" width="15%">Father Name </td>
       <td><input type="text" class="input_txt" value="<?php echo $father_name; ?>" readonly="readonly"/></td>
     </tr> 
    <tr>
		<td class="content_txt">Gender</td>
		<td colspan="2">
		<input type='radio' value='F' <?php if($gender=='F'){ echo "checked='checked'"; }?>/>Female
		<input type='radio'  value='M' <?php if($gender=='M'){ echo "checked='checked'"; }?>/>Male
		</td>
	</tr>    
      <tr>
       <td class="content_txt">Birth Date </td>
       <td><input type="text"  class="input_txt" value="<?php echo $birth_date; ?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Office Address </td>
       <td><input type="text"  class="input_txt" value="<?php echo $address; ?>" readonly="readonly" /></td>
     </tr>
	 <tr>
       <td class="content_txt">State </td>
       <td><input type="text" class="input_txt" value="<?php echo filter(getState($state,$conn)); ?>" readonly="readonly" /></td>
     </tr>
	 <tr>
       <td class="content_txt">City </td>
       <td><input type="text"  class="input_txt" value="<?php echo $city; ?>" readonly="readonly" /></td>
     </tr>
     <tr>
       <td class="content_txt">Pincode</td>
       <td><input type="text"  class="input_txt" value="<?php echo $pincode; ?>" readonly="readonly" /></td>
     </tr>     
     <tr>
       <td class="content_txt">Mobile No </td>
       <td><input type="text"  class="input_txt" value="<?php echo $mobile_no; ?>" readonly="readonly" /></td>
     </tr>
     <tr>
       <td class="content_txt">Email ID </td>
       <td><input type="text" class="input_txt" value="<?php echo $email;?>" readonly="readonly"/></td>
     </tr>    
	<tr class="orange1">
    <td colspan="2"> &nbsp; Industry Reference and Association Details </td>
    </tr>
     <tr>
       <td class="content_txt">Owner Name 1 </td>
       <td><input type="text"  class="input_txt" value="<?php echo $owner_name1;?>" readonly="readonly"/></td>
     </tr>
	  <tr>
       <td class="content_txt">Owner Mobile 1 </td>
       <td><input type="text" class="input_txt" value="<?php echo $owner_mobile1;?>" readonly="readonly"/></td>
     </tr>
	 <tr>
       <td class="content_txt">Owner Name 2 </td>
       <td><input type="text" class="input_txt" value="<?php echo $owner_name2;?>" readonly="readonly"/></td>
     </tr>
	  <tr>
       <td class="content_txt">Owner Mobile 2</td>
       <td><input type="text"  class="input_txt" value="<?php echo $owner_mobile2;?>" readonly="readonly"/></td>
     </tr>
	 <tr>
		<td class="content_txt">Industry Type</td>
		<td colspan="2">
		<input type='radio'  value="Diamonds"  <?php if($industry_type=='Diamonds'){ echo "checked='checked'"; }?>/>Diamonds
		<input type='radio'  value="Gemstone"  <?php if($industry_type=='Gemstone'){ echo "checked='checked'"; }?>/>Gemstone
		<input type='radio'  value="Jewellery"  <?php if($industry_type=='Jewellery'){ echo "checked='checked'"; }?>/>Jewellery		
		</td>
	</tr>
     <tr>
       <td class="content_txt">Nature / Type of Work</td>
       <td><input type="text" class="input_txt" value="<?php echo $nature_work;?>" readonly="readonly"/></td>
     </tr>	
	 <tr>
		<td class="content_txt">Member of Any Registered Association</td>
		<td colspan="2">
		<input type='radio' value="YES"  <?php if($member_of_any_other_organisation=='YES'){ echo "checked='checked'"; }?>/>YES
		<input type='radio' value="NO"  <?php if($member_of_any_other_organisation=='NO'){ echo "checked='checked'"; }?>/>NO			
		</td>
	</tr>
	 <tr>
       <td class="content_txt">Name of Registered Association</td>
       <td><input type="text" class="input_txt" value="<?php echo $name_of_organisation;?>" readonly="readonly"/></td>
     </tr>	
	<tr class="orange1">
    <td colspan="2"> &nbsp; Bank Details of Beneficiary (Worker/Karigar)</td>
    </tr>
	<tr>
       <td class="content_txt">Bank Name</td>
       <td><input type="text" class="input_txt" value="<?php echo $bank_name;?>" readonly="readonly"/></td>
     </tr>	
	 <tr>
       <td class="content_txt">Bank Branch Address</td>
       <td><input type="text"  class="input_txt" value="<?php echo $bank_branch;?>" readonly="readonly"/></td>
     </tr>	
	 <tr>
       <td class="content_txt">IFSC Code</td>
       <td><input type="text" class="input_txt" value="<?php echo $bank_ifsc;?>" readonly="readonly"/></td>
     </tr>	
	 <tr>
       <td class="content_txt">Bank Account Number</td>
       <td><input type="text"  class="input_txt" value="<?php echo $bank_account_no;?>" readonly="readonly"/></td>
     </tr>	
	 <tr class="orange1">
    <td colspan="2"> &nbsp; Identity Details of Karagir</td>
    </tr>
	<tr>
       <td class="content_txt">Aadhar Card Number</td>
       <td><input type="text" class="input_txt" value="<?php echo $aadhar_no;?>" readonly="readonly"/></td>
    </tr>	
	<tr>
       <td class="content_txt">GJEPC Parichay Card Number</td>
       <td><input type="text" class="input_txt" value="<?php echo $parichay_card_no;?>" readonly="readonly"/></td>
    </tr>
	<tr>
		<td class="content_txt">Application Approval Status</td>
		<td colspan="5">
		<input type='radio' name='application_status' id='approve' value='Y' <?php if($application_status=='Y'){ echo "checked='checked'"; }?> />Approve
		<input type='radio' name='application_status' id='pending' value='P' <?php if($application_status=='P'){ echo "checked='checked'"; }?>/>Pending
		<input type='radio' name='application_status' id='disapprove' value='C' <?php if($application_status=='C'){ echo "checked='checked'"; }?>/>Reject
		</td>
	</tr>
	<tr id="disapproval">
    <td class="content_txt">&nbsp;</td>
    <td colspan="5">
	Disapprove Reason :
	<select name="disapprove_reason" id="disapprove_reason" class="input_txt-select">
        <option value="0">Select Status</option>
        <option value="Incomplete passbook" <?php if($disapprove_reason=='Incomplete passbook'){ echo "selected='selected'";}?>>Incomplete passbook</option>
        <option value="Passbook not attached" <?php if($disapprove_reason=='Passbook not attached'){ echo "selected='selected'";}?>>Passbook not attached</option>
        <option value="Balance is more than 15k" <?php if($disapprove_reason=='Balance is more than 15k'){ echo "selected='selected'";}?>>Balance is more than 15k</option>
        <option value="No transaction" <?php if($disapprove_reason=='No transaction'){ echo "selected='selected'";}?>>No transaction </option>
        <option value="Not a Karigar" <?php if($disapprove_reason=='Not a Karigar'){ echo "selected='selected'";}?>>Not a Karigar</option>
        <option value="Record Not Visible Properly" <?php if($disapprove_reason=='Record Not Visible Properly'){ echo "selected='selected'";}?>>Record Not Visible Properly</option>
        <option value="Not in need of Financial aid" <?php if($disapprove_reason=='Not in need of Financial aid'){ echo "selected='selected'";}?>>Not in need of Financial aid</option>
        <option value="Unable to send the Bk statement as required" <?php if($disapprove_reason=='Unable to send the Bk statement as required'){ echo "selected='selected'";}?>>Unable to send the Bk statement as required </option>
		<option value="Duplicate entry" <?php if($disapprove_reason=='Duplicate entry'){ echo "selected='selected'";}?>>Duplicate entry</option>
    </select>
    </td>
	</tr>
	<tr>
       <td class="content_txt">Remark</td>
       <td><input type="text" name="remark" id="remark" class="input_txt" value="<?php echo $remark;?>" maxlength="40"/></td>
    </tr>	
	 	
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <a href="relief-aid.php?action=view" class="input_submit">Back to Home</a>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
    </tr>
	
</table>
</form>
        </div>
        
<?php } ?>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>

<script>
var approv = '<?php echo $application_status; ?>';
$(document).ready(function(){
 if(approv == 'C')
 {
 $('#disapproval').show();
 }
});
</script>