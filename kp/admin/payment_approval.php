<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$MstId=mysqli_real_escape_string($conn,$_REQUEST['MstId']);
$member_type=mysqli_real_escape_string($conn,$_REQUEST['member_type']);

if($member_type=='4')
	$MEMBERTYPE="Member";
elseif($member_type=='4')
	$MEMBERTYPE="NonMember";
else if($member_type=='1')
	$MEMBERTYPE="Agent";
	


$action=$_REQUEST['action'];
if($action=="UPDATE")
{
	$APPLICANT_ID=$_REQUEST['APPLICANT_ID'];
	$PAYMENT_TYPE=$_REQUEST['PAYMENT_TYPE'];
	$PAYMENT_DATE=date("Y-m-d",strtotime($_REQUEST['popupDatepicker']));echo "<br/>";
if($PAYMENT_DATE=="1970-01-01")
{
	$PAYMENT_DATE="";
}
$CHEQUE_NO=$_REQUEST['CHEQUE_NO'];
$CHEQUE_DATE=date("Y-m-d",strtotime($_REQUEST['popupDatepicker1']));
$PAYEE_BANK=$_REQUEST['PAYEE_BANK'];
$PAYEE_BRANCH=$_REQUEST['PAYEE_BRANCH'];
$PAYMENT_AMOUNT=$_REQUEST['PAYMENT_AMOUNT'];
$STATUS=$_REQUEST['STATUS'];
$REMARKS=$_REQUEST['REMARKS'];

$sql="update kp_payment_master set PAYMENT_TYPE='$PAYMENT_TYPE',PAYMENT_DATE='$PAYMENT_DATE',CHEQUE_NO='$CHEQUE_NO',CHEQUE_DATE='$CHEQUE_DATE',PAYEE_BANK='$PAYEE_BANK',PAYEE_BRANCH='$PAYEE_BRANCH',PAYMENT_AMOUNT='$PAYMENT_AMOUNT',STATUS='$STATUS',REMARKS='$REMARKS' where PAYMENT_MST_ID='$MstId'";
$result=mysqli_query($conn,$sql);

$_SESSION['error_msg']="Your Record Update Successfully";
 header("Location: search_payment.php?action=view");
}





$sql="select * from kp_payment_master where 1 and  PAYMENT_MST_ID='$MstId'";
$result=mysqli_query($conn,$sql);
$rows=mysqli_fetch_array($result);
$APPLICANT_ID=$rows['APPLICANT_ID'];
$PAYMENT_TYPE=$rows['PAYMENT_TYPE'];
$PAYMENT_DATE=date("d-m-Y",strtotime($rows['PAYMENT_DATE']));
if($PAYMENT_DATE=="01-01-1970")
{
$PAYMENT_DATE="";
}
$CHEQUE_NO=$rows['CHEQUE_NO'];
$CHEQUE_DATE=date("d-m-Y",strtotime($rows['CHEQUE_DATE']));
$PAYEE_BANK=$rows['PAYEE_BANK'];
$PAYEE_BRANCH=$rows['PAYEE_BRANCH'];
$PAYMENT_AMOUNT=$rows['PAYMENT_AMOUNT'];
$STATUS=$rows['STATUS'];
$REMARKS=$rows['REMARKS'];

if($PAYMENT_TYPE=='93'){
include 'payment_status_admin_api.php';  	/* Hit Payment Status API */
}
?>  


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Approval || KP ||</title>

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
	<div class="breadcome"><a href="search_application.php">Home</a> > Payment Approval</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Payment Approval</div><div align="right" style="padding-right:20px;"><a href="search_payment.php?action=view">Back</a></div></div>
    	
      
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="UPDATE" /> 
<input type="hidden" name="MstId" id="MstId" value="<?php echo $MstId;?>" />       	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="15" >Payment Approve</td>
</tr>
      
<tr >
    <td width="15%"><strong>Applicant</strong></td>
    <td width="31%"><input type="text" name="APPLICANT_ID" id="APPLICANT_ID" value="<?php echo getMemberName($conn,$MEMBERTYPE,$APPLICANT_ID);?>"  class="input_txt1" readonly="readonly"/></td>
     <td width="15%"></td>
     <td width="39%"></td>
</tr>	
    
    
<tr >
  <td><strong><strong><strong>Payment Type</strong></strong></strong></td>
  <td><select name="PAYMENT_TYPE" id="PAYMENT_TYPE" class="input_txt">
      <option value="">Please Select Type</option>
      <?php 
	   $sql="select * from  kp_lookup_details where LOOKUP_ID='15'";
	   $result=mysqli_query($conn,$sql);
	   while($rows=mysqli_fetch_array($result))
	   {
	   if($rows['LOOKUP_VALUE_ID']==$PAYMENT_TYPE)
	   {
	   echo "<option selected='selected' value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }else
	   {
	   echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }
	   }
	   ?>	
    </select>  
    </td>
    <td><strong><strong><strong>Received Date</strong></strong></strong></td>
     <td><input type="text" name="popupDatepicker" id="popupDatepicker" value="<?php echo $PAYMENT_DATE;?>" class="input_date"/></td>
  </tr>

<tr >
  <td><strong><strong><strong>Cheque/DD Date</strong></strong></strong></td>
  <td><input type="text" name="popupDatepicker1" id="popupDatepicker1" value="<?php echo $CHEQUE_DATE;?>"  class="input_date"/></td>
    <td><strong><strong><strong>Cheque/DD No/Reference No</strong></strong></strong></td>
     <td><input type="text" name="CHEQUE_NO" id="CHEQUE_NO" value="<?php echo $CHEQUE_NO;?>"  class="input_txt1"/></td>
  </tr>
<tr >
  <td><strong><strong>Bank</strong></strong></td>
  <td><input type="text" name="PAYEE_BANK" id="PAYEE_BANK" value="<?php echo $PAYEE_BANK;?>"  class="input_txt1"/></td>
    <td><strong>Branch</strong></td>
     <td><input type="text" name="PAYEE_BRANCH" id="PAYEE_BRANCH" value="<?php echo $PAYEE_BRANCH;?>"  class="input_txt1"/></td>
</tr>
<tr >
  <td><strong>Amount</strong></td>
  <td><input type="text" name="PAYMENT_AMOUNT" id="PAYMENT_AMOUNT" value="<?php echo $PAYMENT_AMOUNT;?>"  class="input_txt1"/></td>
  <td></td>
     <td></td>
</tr>
<tr >
    <td><strong>Status</strong></td>
    <td><select name="STATUS" id="STATUS" class="input_txt">
      <option value="">Please Select Status</option>
      <?php 
	   $sql="select * from  kp_lookup_details where LOOKUP_ID='16' order by LOOKUP_VALUE_ORDER";
	   $result=mysqli_query($conn,$sql);
	   while($rows=mysqli_fetch_array($result))
	   {
	   if($rows['LOOKUP_VALUE_ID']==$STATUS)
	   {
	   echo "<option selected='selected' value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }else
	   {
	   echo "<option value='$rows[LOOKUP_VALUE_ID]'>$rows[LOOKUP_VALUE_NAME]</option>";
	   }
	   }
	   ?>
    </select></td>
    <td><strong>Remarks</strong></td>
     <td><input type="text" name="REMARKS" id="REMARKS" value="<?php echo $REMARKS;?>"  class="input_txt1"/></td>
</tr>    
    
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Submit"  class="input_submit" /> </td>
    <td></td>
     <td></td>
</tr>	
</table>
</form>      
</div>
    
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>