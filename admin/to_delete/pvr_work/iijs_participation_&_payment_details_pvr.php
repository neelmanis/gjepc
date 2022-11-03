<?php session_start();ob_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{
	$id=intval($_REQUEST['id']);
	$registration_id=intval($_REQUEST['registration_id']);
	
	$payment_made_flag=$_POST["payment_made_for"];
	if($payment_made_flag==1)
		$msg.="select valid payment made for<br>";
	else
		$payment_made_for=$_POST['payment_made_for'];
	
	$payment_mode=$_POST['payment_mode'];
	
	$drawn_on_bank_flag=$_POST["drawn_on_bank"];
	if($drawn_on_bank_flag==1)
		$msg.="select valid Bank name<br>";
	else
		$drawn_on_bank=$_POST['drawn_on_bank'];
	
	$branch_of_bank_flag=$_POST['branch_of_bank'];
	if($branch_of_bank_flag==1)
		$msg.="Enter valid Branch of bank<br>";
	else	
		$branch_of_bank=$_POST['branch_of_bank'];
		
		$branch_city_flag=$_POST['branch_city'];
		if($branch_city_flag==1)
			$msg.="Enter valid branch city";
		else	
			$branch_city=$_POST['branch_city'];
	
	$branch_postal_flag=$_POST['branch_postal'];
	if($branch_postal_flag==1)
		$msg.="Enter valid branch postal<br>";
	else	
		$branch_postal=$_POST['branch_postal'];
		
		$cheque_dd_no_flag=$_POST['cheque_dd_no'];
		if($cheque_dd_no_flag==1)
			$msg.="Enter valid cheque dd no<br>";
		else
			$cheque_dd_no=$_POST['cheque_dd_no'];
			
			$cheque_dd_dt_flag=$_POST['cheque_dd_dt'];
			if($cheque_dd_dt_flag==1)
				$msg.="Enter valid cheque date<br>";
			else
				$cheque_dd_dt=date("Y-m-d",strtotime($_POST['cheque_dd_dt']));
	
	$participation_fee_flag=$_POST['participation_fee'];
	if($participation_fee_flag==1)
		$msg.="Enter valid participation fee<br>";
	else	
		$participation_fee=intval($_POST['participation_fee']);
	$payment_approve=$_REQUEST['payment_approve'];
	if($payment_approve=='Y')
	{
	$payment_reason="";
	}else
	{
		$payment_reason_flag=$_REQUEST['payment_reason'];
		if($payment_reason_flag==1)
			$msg.="Enter valid payment rerason flag";
		else	
			$payment_reason=$_REQUEST['payment_reason'];
	}
	
	if($msg!="")
	{
		$_SESSION['err_msg']=$msg;
		header("location:iijs_participation_&_payment_details_pvr.php?id=$id&registration_id=$registration_id");
		exit;
	
	}else
	{
	 $updatequery="update pvr_registration_details set payment_made_for='".$payment_made_for."',payment_mode='".$payment_mode."',drawn_on_bank='".$drawn_on_bank."',branch_of_bank='".$branch_of_bank."',branch_city='".$branch_city."',branch_postal='".$branch_postal."',cheque_dd_no='".$cheque_dd_no."',cheque_dd_dt='".$cheque_dd_dt."',participation_fee='".$participation_fee."',payment_approve='".$payment_approve."',payment_reason='".$payment_reason."',modified_dt=NOW() where id='$id' and uid='$registration_id'"; 

	$update_result = mysql_query($updatequery);
	if(!$update_result){
		echo "Error: ".mysql_error();	
	}

$_SESSION['succ_msg']="Payment updated successfully";
header("Location:iijs_change_photo_form_pvr.php?id=$id&registration_id=$registration_id");
exit;

}
}
?>


<?php
$id=intval($_REQUEST['id']);
$registration_id=intval($_REQUEST['registration_id']);
	$sql="SELECT * FROM `pvr_registration_details` WHERE 1 and id='$id' and uid='$registration_id'";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	
	$payment_made_for=$rows['payment_made_for'];
	$payment_mode=$rows['payment_mode'];
	$drawn_on_bank=$rows['drawn_on_bank'];
	$branch_of_bank=$rows['branch_of_bank'];
	$branch_city=$rows['branch_city'];
	$branch_postal=$rows['branch_postal'];
	$cheque_dd_no=$rows['cheque_dd_no'];
	$cheque_dd_dt=date("d-m-Y",strtotime($rows['cheque_dd_dt']));
	$participation_fee=$rows['participation_fee'];
	$payment_approve=$rows['payment_approve'];
	$payment_reason=$rows['payment_reason'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS &gt; PVR &gt;&gt; Participation &amp; Payment Details</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>

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

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}

-->
</style>
<script> 
 function check_disable(){
    if ($('input[name=\'payment_approve\']:checked').val() == "N"){
        $("#payment_reason_text").show();
    }
    else{
        $("#payment_reason_text").hide();
    }	
}
</script>

<script type="text/javascript">
function fees_calculate(show)
{
	registration_id=$('#registration_id').val();
	$.ajax({
    	type: "POST",  
        url: "ajax-fees-display.php",
        data: "show="+show+"&registration_id="+registration_id,
        success: function(response){ 
		//alert(response); 
			$("#participation_fee").val(response); 
        }      
	});
	
}
</script>
</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> >  PVR > Participation & Payment Details</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">IIJS &gt; PVR >&gt; Participation & Payment Details
          <div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_pvr.php">Back to Search</a></div>
        </div>
    <div class="clear"></div>
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
if($_SESSION['error_msg1']!=""){
echo "<span class='notification n-attention'>".$_SESSION['error_msg1']."</span>";
}
if($_SESSION['err_msg']!=""){
echo "<span class='notification n-attention'>".$_SESSION['err_msg']."</span>";
$_SESSION['err_msg']="";
}
if($_SESSION['error_msg2']!=""){
echo "<span class='notification n-attention'>".$_SESSION['error_msg2']."</span>";
}
?>
<form name="search" action="" method="post" > 
<div id="formAdmin">
<div id="formContainer">

<div id="form">
    <ul id="tabs" class="tab_1">
    <li id=""><a href="#"><strong>Step 1 Information</strong></a></li>
    <li id=""><a href="#"><strong>Step 2 OBMP Info</strong></a></li>  
    <li id=""><a href="#" class="active"><strong>Step 3 Payment</strong></a></li>
    <li id=""><a href="#"  class="lastBg"><strong>Step 4 Photo</strong></a></li>   
    
    <div class="clear"></div>
    
</ul>

<div class="clear bottomSpace"></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt pvr bottomSpace" >

<tr class="orange1">
    <td colspan="11">Participation Details</td>
</tr>

<tr>
    <td colspan="11" >
    
    <div class="field">
    <div class="leftTitle" style="padding-top:0px;">Would like to participate for trade shows :</div>
    <div class="clear" style="margin-bottom:8px;"></div>
    <div>
       <label style="min-width:179px;">Payment For :</label>
       <select name="payment_made_for" id="payment_made_for" onchange="fees_calculate(this.value)" class="selectField" >
        <option value="">---Please Select One---</option>
		<option value="COMBO" <?php if($payment_made_for=="COMBO") echo "selected"; ?>>Combo (IIJS 2017 + Signature IIJS 2017)</option>
		<option value="iijs" <?php if($payment_made_for=="iijs") echo "selected"; ?>>IIJS 2017 Only</option>
        <option value="igjme_signature" <?php if($payment_made_for=="igjme_signature") echo "selected"; ?>>Signature IIJS 2017 + IGJME 2017</option>
		<option value="igjme" <?php if($payment_made_for=="igjme") echo "selected"; ?>>Only IGJME 2017 (Complementary)</option>
        </select>
    </div>
      <div class="clear" style="margin-bottom:8px;"></div>
    <div>
       <label style="min-width:179px;">Payable Fees :</label>
       <input name="participation_fee" id="participation_fee" type="text" class="textField" value="<?php echo $participation_fee; ?>"/>
    </div>
	</div>
    
    </td>
</tr>
</table>
      
      
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt pvr bottomSpace" >
<tr class="orange1">
  <td colspan="11">Payment & Badge Details</td>
</tr>
<tr>
  <td colspan="11" >
  <div class="field bottomSpace">
    <div class="leftTitle" style="padding-top:0px;">Badges to be :</div>
    
    <div class="rightContent bottomSpace">
       
    <strong> All Badges will be courier on the above mention address (only if application received on or before 23rd Jan, 2014. 
Badges received after the predetermined date will be available at the venue for pickup from 17th Feb, 2014)</strong>
      
    </div>
<div class="clear" style="margin-bottom:8px;"></div>



<div style="padding-top:0px;" class="bottomSpace">
    
<div class="leftTitle" style="padding-top:0px; min-width:165px;">Payment mode :</div>
    
<div class="rightContent paymentMode">

			 <span>Cash</span>
			 <input name="payment_mode" type="radio" value="Cash" class="radio" <?php if(preg_match('/Cash/',$payment_mode)) echo "checked"; ?> />
           
            <span>Debit / Credit Card</span>
            <input name="payment_mode" type="radio" value="1" class="radio" <?php if(preg_match('/1/',$payment_mode)) echo "checked"; ?> />
			
			<span>Net Banking</span>
            <input name="payment_mode" type="radio" value="3" class="radio" <?php if(preg_match('/3/',$payment_mode)) echo "checked"; ?> />
            
            <span>Cheque / DD</span>
            <input name="payment_mode" type="radio" value="Cheque or DD" class="radio" id="DD" <?php if(preg_match('/Cheque or DD/',$payment_mode)) echo "checked"; ?> />
    <!--<span>Credit Card</span>
    
    <input name="payment_mode" type="radio" value="Credit Card"  class="radio" <?php //if(preg_match('/Credit Card/',$payment_mode)) echo "checked"; ?> /> 
    
    <span>Cash</span>
    <input name="payment_mode" type="radio" value="Cash" class="radio" <?php //if(preg_match('/Cash/',$payment_mode)) echo "checked"; ?> />
    
    <span>DD</span>
    <input name="payment_mode" type="radio" value="DD" class="radio" <?php //if(preg_match('/DD/',$payment_mode)) echo "checked"; ?> />
    
    <span>Debit Card</span>
    <input name="payment_mode" type="radio" value="Debit Card" class="radio" <?php //if(preg_match('/Debit Card/',$payment_mode)) echo "checked"; ?> />
    
    <span>Cheque</span>
    <input name="payment_mode" type="radio" value="Cheque" class="radio" <?php //if(preg_match('/Cheque/',$payment_mode)) echo "checked"; ?> />-->
    
    </div>
<div class="clear"></div>
</div>


<p class="bottomSpace">(Only cheque/drafts payments will be accepted through courier. No guarantee of the cash will be undertaken by Council, if it is sent through courier. Cash will be accepted only with the application which is submitted personally.)</p>

    
<p class="bottomSpace"><strong>Cheque / DD details</strong></p>
    
<div class="bottomSpace">
<label>Drawn on Bank :</label>
<select name="drawn_on_bank" class="textField">
    <option selected="selected" value=""> -- Please Selected -- </option>
    <?php 
	$fetchBank = "select * from bank_master";
	$get_bank=mysql_query($fetchBank);
	while($show_bank = mysql_fetch_array($get_bank)){?>
    <option value="<?php echo $show_bank['bank_name']; ?>" <?php if($show_bank['bank_name']==$drawn_on_bank) echo "selected"; ?>><?php echo $show_bank['bank_name']; ?></option>
     <?php }?>
</select>
</div>


<div class="bottomSpace">
<label>Bank Branch  :</label>
<input name="branch_of_bank" type="text" class="textField" value="<?php echo $branch_of_bank; ?>" autocomplete="off" />
</div>

<div class="bottomSpace">
<label>Bank City Name  :</label>
<input name="branch_city" type="text" class="textField" value="<?php echo $branch_city; ?>" autocomplete="off" />
</div>

<div class="bottomSpace">
<label>Bank Postal Code : </label>
<input name="branch_postal" type="text" class="textField" value="<?php echo $branch_postal; ?>" autocomplete="off" />
</div>

<div class="bottomSpace">
<label>Cheque / DD No.  :</label>
<input name="cheque_dd_no" type="text" class="textField" value="<?php echo $cheque_dd_no; ?>" autocomplete="off" />
</div>

<div class="bottomSpace">
<label>Cheque / DD Date  :</label>
<input name="cheque_dd_dt" type="text" class="textField" id="popupDatepicker" value="<?php echo $cheque_dd_dt; ?>" autocomplete="off" />
</div>

<div class="bottomSpace">
<label>Payment Approval Status : </label>

<input type="radio" name="payment_approve" id="payment_approve" value="Y" onchange="check_disable()" <?php if($payment_approve=="Y"){?> checked="checked" <?php }?> /> Approve 
<input type="radio" name="payment_approve" id="payment_approve" value="N" onchange="check_disable()"  <?php if($payment_approve=="N"){?> checked="checked" <?php }?> /> Disapprove
<p id="payment_reason_text" <?php if($payment_approve=="Y"){?> style="display:none;" <?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<textarea name="payment_reason" cols="40" rows="6" id="payment_reason"  ><?php echo $payment_reason;?></textarea>
</p>

</div>   
    </div>
    </td>
</tr>
      </table>

      
</div>
</div>

<div style="padding-left:250px; margin-top:5px;">
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Update" class="input_submit"/>
<a href="iijs_obmp_profile_pvr.php?id=<?php echo $id;?>&registration_id=<?php echo $registration_id;?>">
<div class="button">Previous</div></a>
<a href="iijs_change_photo_form_pvr.php?id=<?php echo $id;?>&registration_id=<?php echo $registration_id;?>">
<div class="button">Next</div></a>
</div>

</div>

</form>      
</div>
 
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
