<?php
session_start();
include('../db.inc.php');
include('../functions.php');

if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID=$_SESSION['curruser_login_id'];
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['category_type']="";
  $_SESSION['keyword']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  $_SESSION['firm_type']="";
  $_SESSION['member_type']="";
  $_SESSION['status']="";
  
  header("Location: membership-FY2020-21.php");
  
} else
{
  	$search_type=$_REQUEST['search_type'];
  	if($search_type=="SEARCH")
	{ 
	  $_SESSION['category_type']=$_REQUEST['category_type'];
	  $_SESSION['keyword']=$_REQUEST['keyword'];
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
	<div class="breadcome"><a href="membership-FY2020-21.php">Home</a> > Membership</div>
</div>

<div id="main">
<div class="content">

<div class="clear"></div>
<div class="content_details1">
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

<tr >
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
  <option value="pending" <?php if($_SESSION['status']=='pending'){echo "selected='selected'";}?>>Non Renewal</option>
  </select>
  
  </td>
</tr>    
    
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	

</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" >
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
    <td width="8%">Action</td>
    <?php
	if($_SESSION['status']=='pending')
	{
	echo "<td width='15%'>De-Registration</td>";
	}
	/*if($_SESSION['status']=='R')
	{
		echo "<td width='15%'>Renewal Applications</td>";
	} */
	if($_SESSION['status']=='Issue_rcmc_certificate')
	{
	echo "<td width='15%'>Issue RCMC Certificate</td>";
	}
	
	if($_SESSION['status']=='Issue_membership_certificate')
	{
	echo "<td width='15%'>Issue Membership Certificate</td>";
	} 
	?>
	<?php 
	$lastFinancialYear = 2020;
	$nextFinancialYear = $lastFinancialYear +1;
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
  
    $sql="select a.id,b.company_name,b.iec_no,b.region_id,b.member_type_id,c.challan_scanned_copy,c.signature_slip_copy,c.sales_order_no,c.Response_Code,c.Unique_Ref_Number,c.ReferenceNo,c.Transaction_Date,d.gcode,d.merchant_certificate_no,d.manufacturer_certificate_no,d.membership_id,d.eligible_for_renewal,d.information_approve,d.document_approve,d.payment_approve,d.sap_sale_order_create_status,d.sap_bp_create_status,d.de_registered from registration_master a,information_master b,challan_master c,approval_master d where a.id=b.registration_id and a.id=c.registration_id and a.id=d.registration_id and c.challan_financial_year='$lastFinancialYear' ";
  
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
	}else if($_SESSION['status']=='pending'){
		$sql.=" AND c.registration_id NOT IN(SELECT c.registration_id FROM challan_master where c.challan_financial_year='$nextFinancialYear')";
	}
  }	
  
 	$sql.="group by a.id  order by a.id desc limit $start, $limit"; 
	//echo $sql;
	$result = $conn ->query($sql);
	if(!$result) die ($conn->error);
	
	
	//total no of record 
	$sql1="SELECT COUNT( * ) as count FROM ( select a.id from registration_master a,information_master b,challan_master c,approval_master d where a.id=b.registration_id and a.id=c.registration_id and a.id=d.registration_id and c.challan_financial_year='$lastFinancialYear'";
  
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
		}elseif($_SESSION['status']=='Response_Code'){
		$sql1.=" and c.Response_Code='E000' ";
	    }
	}	
	
	$sql1.=") as temp"; 
	//echo "<br>".$sql1;
	$result1 = $conn ->query($sql1);
	 if(!$result1) die ($conn->error);
	$rows1	 = $result1->fetch_assoc();
	$rCount  = $rows1['count'];
	
  if($rCount>0)
  {	
  while($rows = $result->fetch_assoc())
  {
  ?>
  <tr <?php if($i%2==0){ echo "bgcolor='#CCCCCC'";} ?>>
    <td><?php echo strtoupper($rows['company_name']);?></td>
    <td><?php echo $rows['Response_Code']."<br/>".$rows['Unique_Ref_Number']."<br/>".$rows['ReferenceNo'];?></td>
    <td><?php echo getBPNO($rows['id'],$conn);?></td>
    <td><?php echo $rows['sales_order_no'];?></td>
    <td><?php if($rows['member_type_id']==5){ echo "Merchant"; } else { echo "Manufacturer"; } echo "<br/>";
	if($rows['member_type_id']==5){echo $rows['merchant_certificate_no'];}else{echo $rows['manufacturer_certificate_no'];}?>    </td>
    <td><?php echo $rows['membership_id'];?></td>
	<td><?php echo $rows['region_id']?></td>
    <td valign="middle"><a href="information_form-FY2020-21.php?registration_id=<?php echo $rows['id'];?>"><img src="images/edit1.png" border="0" /></a></td>
	<?php
	if($_SESSION['status']=='Issue_membership_certificate')
	{
	echo "<td align='left'><input name='issue_mem_cer[]' type='checkbox' value='$rows[id]' /> /<a href='../rcmc/membership-FY2020-21.php?registration_id=$rows[id]' target='_blank'> View Certificate</a></td>";
	}
	?>	
	<!-------------------- De-Registration Delta Start Here ------------------------------------>
	<?php
	if($_SESSION['status']=='pending'){ 
		if(getBPNO($rows['id'],$conn)!="") {
		if($rows['de_registered']=="N"){ ?>
	<td class="delta" data-url="<?php echo $rows['id'];?>"><img src="images/reply.png" title="PUSH" border="0" style=""/></td>
	<?php } else { ?>
	<td><a onclick="return(window.confirm('Company Already De-Registered'));"><img src="images/active.png"/></a></td>
	<?php } ?>
    <?php } else { ?><td></td><?php } ?>
	<?php }	?>
	<!-------------------- De-Registration Delta End Here ------------------------------------>
	</tr>
  
  <?php
   $i++;
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
<?php echo pagination($limit,$page,'membership-FY2020-21.php?action=view&page=',$rCount); //call function to show pagination?>
</div>        
      
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(".delta").click(function() {
	var values = $(this).data('url');
	var registration_id=values;
	//alert(registration_id);
	
	if (confirm("Are you sure you want to De-Register Company")) {
		$.ajax({
		url: "de_register_delta_api.php",
		method:"POST",
		data:{registration_id:registration_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			console.log(data); exit;
			if($.trim(data)==1){
				alert("Company De-Registered Successfully.");; 
				window.location.href = "membership-FY2020-21.php?action=view";
			} else {
				alert("Sorry There is some problem with SAP response");; 
				window.location.href = "membership-FY2020-21.php?action=view";
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
</html>