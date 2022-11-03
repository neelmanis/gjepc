<?php
session_start();
include('../db.inc.php');
include('../functions.php');

if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; } ?>
<?php
$action=$_REQUEST['action'];
if($action=="update")
{
$registration_id = intval($_REQUEST['registration_id']);
$member_type_id  = $_REQUEST['member_type_id'];

//$iec_issue_date=date('d-m-Y',strtotime($_REQUEST['iec_issue_date']));
if($member_type_id==5){
$merchant_certificate_no = $_REQUEST['merchant_certificate_no'];
$manufacturer_certificate_no  = "";
} else {
$manufacturer_certificate_no  = $_REQUEST['manufacturer_certificate_no'];
$merchant_certificate_no = "";
}

$e_rcmc_certificate_no=$_REQUEST['e_rcmc_certificate_no'];

$rcmc_certificate_issue_date  = $_REQUEST['rcmc_certificate_issue_date'];
$rcmc_certificate_expire_date = $_REQUEST['rcmc_certificate_expire_date'];



$sql1="UPDATE `approval_master` SET `rcmc_certificate_issue_date`='$rcmc_certificate_issue_date',`rcmc_certificate_expire_date`='$rcmc_certificate_expire_date',`merchant_certificate_no`='$merchant_certificate_no',`manufacturer_certificate_no`='$manufacturer_certificate_no',e_rcmc_certificate_no='$e_rcmc_certificate_no' WHERE registration_id='$registration_id'";
$result = $conn ->query($sql1);   
if (!$result) die ($conn->error);

$_SESSION['succ_msg']="Information updated successfully";
header("Location: membership.php?action=view");
}

$registration_id = intval($_REQUEST['registration_id']);
$sql="SELECT * FROM `information_master` WHERE 1 and registration_id=$registration_id";
$result = $conn ->query($sql);
$rows   = $result->fetch_assoc();
$company_name=$rows['company_name'];
$member_type_id=$rows['member_type_id'];

$sqly="SELECT * FROM `approval_master` WHERE 1 and registration_id=$registration_id";
$resulty = $conn ->query($sqly);
$rowsy   = $resulty->fetch_assoc();
$merchant_certificate_no=$rowsy['merchant_certificate_no'];
$manufacturer_certificate_no=$rowsy['manufacturer_certificate_no'];
$e_rcmc_certificate_no=$rowsy['e_rcmc_certificate_no'];
$rcmc_certificate_issue_date=$rowsy['rcmc_certificate_issue_date'];
$rcmc_certificate_expire_date=$rowsy['rcmc_certificate_expire_date'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update RCMC Form ||GJEPC||</title>

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
	<div class="breadcome"><a href="admin.php">Home</a> > Membership  > RCMC Certificate Update</div>
</div>

<div id="main"> 
	<div class="content">
    	<div class="content_head">RCMC Certificate Update
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
    <td colspan="11">RCMC Certificate Details</td>
    </tr>
	<tr>
    <td width="27%"><strong>Company Name </strong></td>
    <td width="73%"><?php echo $company_name;?></td>
    </tr>
 	<tr>
    <td><strong>Member Type </strong></td>
    <td><?php if($member_type_id==5){ echo "Merchant"; } else { echo "Manufacturer"; } ?>
	<input type="hidden" name="member_type_id" class="input_txt_new" value="<?php echo $member_type_id;?>"/></td>
	</tr>
	<tr>
    <td><strong> <?php if($member_type_id==5){ echo "Merchant"; } else { echo "Manufacturer"; } ?> RCMC NO </strong></td>
    <td><?php if($member_type_id==5){ ?>
	<input type="text" name="merchant_certificate_no" id="merchant_certificate_no" class="input_txt_new" value="<?php echo $merchant_certificate_no;?>"/>
	<?php } else { ?>
	<input type="text" name="manufacturer_certificate_no" id="manufacturer_certificate_no" class="input_txt_new" value="<?php echo $manufacturer_certificate_no;?>"/>
	<?php } ?>
	</td>
	</tr>
	<tr>
	  <td><strong>E RCMC NO </strong></td>
	  <td><input type="text" name="e_rcmc_certificate_no" id="e_rcmc_certificate_no" class="input_txt_new" value="<?php echo $e_rcmc_certificate_no;?>" />
      </td>
	</tr>
    <tr>
	  <td><strong>Date of Issue </strong></td>
	  <td><input type="date" name="rcmc_certificate_issue_date" id="rcmc_certificate_issue_date" class="input_txt_new" value="<?php echo $rcmc_certificate_issue_date;?>" />
      </td>
	</tr>
	<tr>
	  <td><strong>Upto</strong></td>
	  <td><input type="date" name="rcmc_certificate_expire_date" id="rcmc_certificate_expire_date" class="input_txt_new" value="<?php echo $rcmc_certificate_expire_date;?>" />
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