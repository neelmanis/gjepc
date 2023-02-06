<?php
session_start();
include('../db.inc.php');
include('../functions.php');

if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
$admin_name = getAdminName($adminID,$conn);
 ?>

<?php
$action=$_REQUEST['action'];
if($action=="update")
{
$registration_id = intval($_REQUEST['registration_id']);
$membership_id = $_REQUEST['membership_id'];
$membership_certificate_type = $_REQUEST['membership_certificate_type'];
$invoice_no = $_REQUEST['invoice_no'];
$receipt_no = $_REQUEST['receipt_no'];
$invoice_date = $_REQUEST['invoice_date'];

$sql1="UPDATE `approval_master` SET membership_id='$membership_id',membership_certificate_type='$membership_certificate_type',invoice_no='$invoice_no',receipt_no='$receipt_no',invoice_date='$invoice_date',receipt_date='$invoice_date',ie_download_status='admin' WHERE registration_id='$registration_id'";
$result = $conn ->query($sql1);   
if (!$result) die ($conn->error);

/*.................................... Maintain Approval Log ..............................................*/
$getCompany = getNameCompany($registration_id,$conn);
$getCompanyName = str_replace(array('&amp;','&AMP;'), '&', $getCompany);
$update_log = "insert into membership_approval_logs set post_date=NOW(),type='update_membership_certificate',registration_id='$registration_id',company='$getCompanyName',admin_id='$adminID',admin_name='$admin_name',action='Y',reason='update membership certificate from admin'";
$update_result_log = $conn ->query($update_log);
if (!$update_result_log) die ($conn->error);

$_SESSION['succ_msg']="Information updated successfully";
header("Location: membership.php?action=view");
}


$registration_id = intval($_REQUEST['registration_id']);
$sql="SELECT member_type_id FROM `information_master` WHERE 1 and registration_id=$registration_id";
$result = $conn ->query($sql);
$rows   = $result->fetch_assoc();

$getCompany = getNameCompany($registration_id,$conn);
$company_name = str_replace(array('&amp;','&AMP;'), '&', $getCompany);

$member_type_id = $rows['member_type_id'];

$sqly="SELECT * FROM `approval_master` WHERE 1 and registration_id=$registration_id";
$resulty = $conn ->query($sqly);
$rowsy   = $resulty->fetch_assoc();

$membership_id = $rowsy['membership_id'];
$membership_certificate_type = $rowsy['membership_certificate_type'];
$invoice_no = $rowsy['invoice_no'];
$invoice_date = $rowsy['invoice_date'];
$receipt_no = $rowsy['receipt_no'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Membership Certificate ||GJEPC||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script> 
 <!--validation-->
<!--<script src="jsvalidation/jquery.js" type="text/javascript"></script>-->
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/cmxform.css" />   

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
</head>

<body>

<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Membership  > Membership Certificate Update</div>
</div>

<div id="main"> 
	<div class="content">
    	<div class="content_head">Membership Certificate Update
    </div>
    	
<!--<form class="cmxform" method="post" name="from1" id="form1">-->
<form action="#" method="post">        

<div class="content_details1">
  <?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}

if($_SESSION['form_chk_msg']!=""){
echo "<span class='notification n-attention'>".$_SESSION['form_chk_msg']."</span>";
$_SESSION['form_chk_msg']="";
}

if($_SESSION['error_msg']!=""){
echo "<span class='notification n-attention'>";
echo $_SESSION['error_msg']."<br>";
echo "</span>";
}
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
    <tr class="orange1">
    <td colspan="11">Membership Certificate Details</td>
    </tr>
	<tr>
    <td width="27%"><strong>Company Name </strong></td>
    <td width="73%"><?php echo $company_name;?></td>
    </tr>
 	<tr>
		<td><strong>Member Type </strong></td>
		<td><?php if($member_type_id==5){ echo "Merchant"; } else { echo "Manufacturer"; } ?></td>
	</tr>
	<tr>
	  <td><strong>Membership Id</strong></td>
	  <td><input type="text" name="membership_id" id="membership_id" class="input_txt_new" value="<?php echo $membership_id;?>" />
      </td>
	</tr>
	<tr>
	  <td><strong>Membership Type</strong></td>
	  <td>
	  <select class="form_text_text" name="membership_certificate_type" id="membership_certificate_type" >
		<option value="0">--- Select ---</option>
		<option value="ZASSOC" <?php if($membership_certificate_type=="ZASSOC") echo 'selected="selected"'; ?>>ASSOCIATE</option>
		<option value="ZORDIN" <?php if($membership_certificate_type=="ZORDIN") echo 'selected="selected"'; ?>>ORDINARY</option>
	  </select>
      </td>
	</tr>
	<tr>
	  <td><strong>Invoice No</strong></td>
	  <td><input type="text" name="invoice_no" id="invoice_no" class="input_txt_new" value="<?php echo $invoice_no;?>" />
      </td>
	</tr>
	<tr>
	  <td><strong>Receipt No</strong></td>
	  <td><input type="text" name="receipt_no" id="receipt_no" class="input_txt_new" value="<?php echo $receipt_no;?>" />
      </td>
	</tr>
    <tr>
	  <td><strong>Date of Issue </strong></td>
	  <td><input type="date" name="invoice_date" id="invoice_date" class="input_txt_new" value="<?php echo $invoice_date;?>" />
      </td>
	</tr>
    </tbody>
    
</table>

</div>  
<div style="padding-left:10px; margin-top:5px;">
<input type="hidden" name="action" value="update" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />
<input type="submit" value="Update" class="input_submit"/>
<a href="membership.php?action=view"><div class="button">Back</div></a>
</div>	
</form>

</div>
<div id="footer_wrap"><?php include("include/footer.php"); $_SESSION['error_msg']="";?></div>
</body>
</html>