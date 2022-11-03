<?php 
session_start(); 
ob_start();
?>
<?php 
include('../db.inc.php');
include('../functions.php');
$registration_id=intval($_REQUEST['registration_id']);

$sql="SELECT * FROM virtual_event_registration where registration_id='$registration_id' and event_version='VIRL2'";
$result1 = $conn ->query($sql);
$rows = $result1->fetch_assoc();
$payment_status=$rows["payment_status"];
$application_status=$rows["application_status"];
$allow_visitor=$rows["allow_visitor"];
$payment_dissapprove_reason=$rows["payment_dissapprove_reason"];
$application_dissapprove_reason=$rows["application_dissapprove_reason"];
$sales_order_no = trim($rows['sales_order_no']);
?>

<?php
$action=@$_REQUEST['action'];
if($action=="UPDATE")
{// echo '<pre>'; print_r($_POST); exit;
	$utr_date = $_POST['utr_date'];
	$utr_approved = $_POST['utr_approved'];
	$comment = $_POST['comment'];
	
	$utr_id1 = $_POST['utr_id'];
	$utr_id2 = explode('-',$utr_id1[0]);
	$utr_id=$utr_id2[0];
	$index=$utr_id2[1];
	
	$utr_approve = $utr_approved[$index];
	$comment = $comment[$index];
	$utr_date = $utr_date[$index];
	
		if($utr_approve == "Y"){ $comment = ""; }
	else if($utr_approve == "P"){ $comment = ""; }
	else { $payment_approval = "D"; }
	
	$sqll = "UPDATE `utr_history` SET utr_date='$utr_date',utr_approved='$utr_approve',comment='$comment' WHERE id='$utr_id' AND `registration_id`='$registration_id' AND event_selected='vbsm2'";
	$mmx = $conn ->query($sqll);
	
	$payment_approval = $_REQUEST["payment_approval"];
	if($payment_approval=="rejected")
	{
		$payment_dissapprove_reason=($_REQUEST['payment_dissapprove_reason']);
	}
	else
	{
		$payment_dissapprove_reason="";
	}
	$application_approval = $_REQUEST["application_approval"];
	if($application_approval=="rejected")
	{
		$application_dissapprove_reason=($_REQUEST['application_dissapprove_reason']);
	}
	else
	{
		$application_dissapprove_reason="";
	}

$update_query = "update virtual_event_registration set modified_date=NOW(), payment_status='$payment_approval', payment_dissapprove_reason='$payment_dissapprove_reason',application_status='$application_approval', application_dissapprove_reason='$application_dissapprove_reason' where registration_id='$registration_id'";
$result_update=$conn ->query($update_query);		
				
$message .='<table width="100%" bgcolor="#fff" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
<tr>
<td style="padding:30px;">
<table width="100%" border="0" background="#fff" cellpadding="0" cellspacing="0">
     <tr>
    	<td align="left" valign="top"><a href="https://www.gjepc.org"><img src="https://gjepc.org/images/gjepc_logon.png" width="150" height="90" /></a></td>
    	<td align="right"><a href="https://gjepc.org/iijs-virtual/"><img src="https://gjepc.org/emailer_gjepc/24.11.2020/logo2.0.jpg" width="174" height="105"/></a></td>
    </tr>	
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>    
    <tr><td colspan="2" height="25px">&nbsp;</td></tr>    
    <tr>
    	<td colspan="2" valign="top" style="font-size:13px;">
    	<p><strong>Company Name : '.getNameCompany($registration_id,$conn).'</strong> </p>
    	</td>
    </tr>    
    <tr>
    <td colspan="2">
<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#fff" style="border-collapse:collapse; float:right;">
  <tr valign="top">
    <td colspan="2"  style="color:#14b3da;"><strong>Application Approval Summary</strong><br /></td>
    </tr>
  <tr valign="top">
    <td width="30%"><strong>Payment Approval Status </strong></td>
    <td width="21%">'.$payment_approval.'</td>
  </tr>
  <tr valign="top">
    <td><strong>Application Approval Status</strong></td>
    <td>'.$application_approval.'</td>
  </tr>
  <tr valign="top">
    <td valign="top"><strong>Payment Dissapproval Reason</strong></td>
    <td valign="top">'.$payment_dissapprove_reason.'</td>
  </tr>
  <tr valign="top">
    <td><strong>Application Dissapproval Reason</strong></td>
    <td>'.$document_dissapprove_reason.'<br /></td>
  </tr>
</table>
	</td>
  </tr>  
  
	<tr>
	<td colspan="2">
	<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#fff" style="border-collapse:collapse; float:right;">
	  <tr valign="top">
		<td colspan="3"  style="color:#14b3da;"><strong>UTR Details</strong><br /></td>
		</tr>
	  <tr valign="top">
		<td width="30%"><strong>UTR No. </strong></td>
		<td width="21%"><strong>Status</strong></td>
		<td width="21%"><strong>Reason</strong></td>
	  </tr>';
	    
		$utrExists = "SELECT id,utr_number,amountPaid,tdsAmount,comment,utr_approved,utr_date,part_salesorder_status FROM `utr_history` WHERE registration_id='$registration_id' AND event_selected='vbsm2' order by `utr_date` asc";
		$existResults = $conn ->query($utrExists);
		while($printutrs = $existResults->fetch_assoc())
		{
			$id = $printutrs['id']; 
			$getUTR_no = $printutrs['utr_number']; 
			$utr_approved = $printutrs['utr_approved'];
			if($utr_approved =="Y"){ $utr_approved_status = "Approved"; }
			else if($utr_approved =="D"){ $utr_approved_status = "Disapproved"; }
			else $utr_approved_status = "Pending"; 
				
			$utr_date = $printutrs['utr_date']; 
			$comment = $printutrs['comment']; 

			$message .='<tr valign="top">
				<td><strong>'.$getUTR_no.'</strong></td>
				<td>'.$utr_approved_status.'</td>
				<td>'.$comment.'</td>
			  </tr>';
		}
	$message .='</table>
	</td>
	</tr>  
	
    <tr>
    	<td colspan="2" height="25px">&nbsp;</td>
    </tr>
    <tr>
</tr>
    
    <tr>
    <td colspan="2" style="line-height:20px;">
<p>Kind Regards,</p>

<p><strong>IIJS Team Virtual</strong></p>

</td>
</tr>
</table>
</td>
</tr>
</table>';
				
				$to=getUserEmail($registration_id,$conn).',notification@gjepcindia.com';			
			//	$to="neelmani@kwebmaker.com,notification@gjepcindia.com";	
				$subject = "IIJS VIRTUAL SHOW 2.0 Approval Status/dated".date('Y-m-d').")";
				$headers  = 'MIME-Version: 1.0' . "\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";	
				$headers .='From: IIJS VIRTUAL SHOW 2.0 <admin@gjepc.org>';
				mail($to, $subject, $message, $headers);
				if($result_update)
				{
					header("Location:virtual_iijs_exhibitor_rgistration.php?action=view");
				}

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS Virtual Exhibitor Registration > Payment Details</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>
<!--navigation-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>     
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>

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
	<div class="breadcome"><a href="admin.php">Home</a> Virtual Exhibitor Registration</div>
</div>

<div id="main">
	<div class="content">
    
    <div class="content_head">IIJS > Virtual Exhibitor Registration
      <div style="float:right; padding-right:10px; font-size:12px;"><a href="virtual_iijs_exhibitor_rgistration.php?action=view">Back to Search</a></div>
    </div>
    	
<div class="clear"></div>
<div class="content_details1">
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<ul id="tabs" class="tab_1">
    <li id=""><a href="#" class="lastBg active"><strong>UTR Payment Details</strong></a></li>  
    <div class="clear"></div>
</ul>

<div id="formCon">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Payment Details</td>
</tr>


<?php if($_SESSION['succ_msg']!=""){ ?>
<tr>
<td colspan="12"><?php echo $_SESSION['succ_msg']; ?></td>
</tr>
<?php } ?>
</tr>
<form name="form1" method="post" onsubmit="return validation()"> 
<tr class="orange1"><td colspan="11" >UTR Details</td></tr>
<tr><td colspan="2">
	<table border="1" cellspacing="0" cellpadding="5" style="margin-bottom:10px;" width="100%">
			<thead>
				<th align="center">Select</th>
				<th align="center">UTR No</th>
				<th align="center">Amount Paid</th>
				<th align="center">TDS Amount</th>
				<th align="center">Date</th>
				<th align="center">Approve</th>
				<th align="center">Disapprove</th>
				<th align="center">Partial</th>
			</thead>
			<tbody>
			<?php 
			$utrExist2 = "SELECT sum(amountPaid) as `amountPaid`,sum(tdsAmount) as `tdsAmount` FROM `utr_history` WHERE registration_id='$registration_id' AND `event_selected`='vbsm2'";
			$existResult2 = $conn ->query($utrExist2);	
			while($printutr2 = $existResult2->fetch_assoc())
			{				
				$totalAmountPaid=$printutr2['amountPaid'];
				$totalTdsAmount=$printutr2['tdsAmount'];
			}
			?>
				<?php
				$utrExist = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND `event_selected`='vbsm2' order by `utr_date` asc";
				$existResult = $conn ->query($utrExist);
				$totalPrice = 0;
				$CheckFirstEntry = 0;
				$i=0;
				while($printutr = $existResult->fetch_assoc())
				{
				$id = $printutr['id']; 
				$getUTR_no = $printutr['utr_number']; 
				$amountPaid = $printutr['amountPaid']; 
				$tdsAmount = $printutr['tdsAmount']; 
				$utr_approved = $printutr['utr_approved'];
				$utr_date = $printutr['utr_date']; 
				$comment = $printutr['comment']; 
				$isDone = $printutr['IsDone']; 
				$first_sales_order_no = $printutr['first_sales_order_no']; 
				$sap_so_status = $printutr['sap_so_status']; 
				?>
				<tr>
				<td align="center"><!--<input type="hidden" name="utr_id[]" value="<?php echo $id;?>">-->
				<input type="radio" name="utr_id[]" value="<?php echo $id."-".$i;?>"></td>
				<td align="center"><?php echo $getUTR_no;?></td>
				<td align="center"><?php echo $amountPaid;?></td>
				<td align="center"><?php echo $tdsAmount;?></td>
				<td align="center"><input type="date" name="utr_date[]" value="<?php echo $utr_date;?>" /></td>
				<td align="center">
				<select class="textField" name="utr_approved[]" id="utr_approved">			
				 <option value="Y" <?php if($utr_approved=="Y") echo 'selected="selected"'; ?>> Approve </option>
				 <option value="D" <?php if($utr_approved=="D") echo 'selected="selected"'; ?>> Disapprove </option>
				 <option value="P" <?php if($utr_approved=="P") echo 'selected="selected"'; ?>> Pending </option>
				</select>
                </td>				
				<td align="center"><input type="textarea" name="comment[]" id='comment' value="<?php echo $comment;?>"></td>
				<!-------------------------- Start Partial --------------------------------------------->
				<?php if($utr_approved=='Y'){
				if($isDone == 1 && $sap_so_status == 1) { ?>
					<td align="center"><img src="images/active.png"/></td>
					<?php } elseif($sales_order_no=='') { ?>
					<td align="center">NO SO</td>
					<?php } elseif($printutr['part_salesorder_status'] == 0 && $sales_order_no!='') { ?>
					<td align="center" class="part" data-url="<?php echo $sales_order_no;?> <?php echo $registration_id;?> <?php echo $getUTR_no;?>">Click Partial </td>
					<?php } else { ?>
					<td align="center"><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
				<?php } 
				} ?>
				<!-------------------------- End Partial --------------------------------------------->
				</tr>
				<?php $i++; }	?>
			</tbody>
	</table>
		 </td>
	</tr>

    <tr class="orange1">
    <td colspan="11">Payment Details</td>
    </tr>
	<tr>
	<td>Payment Approval</td>
	<td>
	<input type="radio" value="approved" name="payment_approval" <?php if(preg_match('/approved/',$payment_status)){echo 'checked="checked"'; } ?>>Approve
	<input type="radio" value="rejected" name="payment_approval" <?php if(preg_match('/rejected/',$payment_status)){echo 'checked="checked"'; } ?>>Disapprove
	<input type="radio" value="pending" name="payment_approval" <?php if(preg_match('/pending/',$payment_status)){echo 'checked="checked"'; } ?>>Pending
	<textarea name="payment_dissapprove_reason" id="payment_dissapprove_reason"><?php echo $payment_dissapprove_reason ?></textarea>
	Disapprove Reson
	</td>
	</tr>

	<tr>
	<td>Application Approval</td>
	<td>
	<input type="radio" value="approved" name="application_approval" <?php if(preg_match('/approved/',$application_status)){echo 'checked="checked"'; } ?>>Approve
	<input type="radio" value="rejected" name="application_approval" <?php if(preg_match('/rejected/',$application_status)){echo 'checked="checked"'; } ?>>Disapprove
	<input type="radio" value="pending" name="application_approval" <?php if(preg_match('/pending/',$application_status)){echo 'checked="checked"'; } ?>>Pending
	<textarea name="application_dissapprove_reason" id="application_dissapprove_reason"><?php echo $application_dissapprove_reason;?></textarea>
	Disapprove Reason
	</td>
	</tr>
</table>
</div>
<div style="padding-left:250px; margin-top:5px;">
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Update" class="input_submit"/>
</div>
</form>

</div></div></div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script type="text/javascript">
/* Partial Advance Payment */
$(".part").click(function() {
	var values = $(this).data('url').split(" ");
	var so_number=values[0];
	var registration_id=values[1];
	var utr_no=values[2];
	//alert(so_number);
	
	if (confirm("Are you sure you want to Create Partial Advance Payment")) {
		$.ajax({
		url: "virtual_partial_advance_api.php",
		method:"POST",
		data:{so_number:so_number,registration_id:registration_id,utr_no:utr_no},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			//console.log(data); exit;
			if($.trim(data)==1){
				alert("Partial Advance Payment successfully Send..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);		
			}
			console.log(data);
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