<?php 
session_start(); 
ob_start();
?>
<?php
include('../db.inc.php');
include('../functions.php');

$id=intval($_REQUEST['id']);
$registration_id=intval($_REQUEST['registration_id']);
$event_name=$_REQUEST['event_name'];
$bp_number = $_REQUEST['bp_number'];
//$company_name=getNameCompany($registration_id,$conn);
//$eventDescription=getExhRoi_desc($event_name,$conn);

$sql="SELECT * FROM gjepclivedatabase.roi_space_registration where id='$id'";
$result=$conn->query($sql);
$rows=$result->fetch_assoc();

$contact_person_name=$rows['contact_person_name'];
$contact_person_designation=$rows['contact_person_designation'];
$contact_person_email=$rows['contact_person_email'];
$contact_person_mobile_no=$rows['contact_person_mobile_no'];

$section=$rows['section'];
$selected_area=$rows['selected_area'];
$tot_space_cost_rate=$rows['tot_space_cost_rate'];
$govt_service_tax=$rows['govt_service_tax'];
$grand_total=$rows['grand_total'];
$application_status=$rows['application_status'];
$application_dissapprove_reason=$rows['application_dissapprove_reason'];
$payment_status=$rows['payment_status'];
$payment_dissapprove_reason=$rows['payment_dissapprove_reason'];
$sales_order_no = trim($rows['sales_order_no']);

?>
<?php

if($_REQUEST['action']=='del' && $_REQUEST['action']!="")
{
	$sql = "delete from utr_history where id = '$_REQUEST[utr_id]'";
	$result = $conn->query($sql);
	if(!$result){ die($conn->error); }
	echo "<meta http-equiv=refresh content=\"0;url=manage_roi_forms.php?action=view\">";
}
?>
<?php
$saveUTR = $_POST['saveUTR'];
if($saveUTR=="saveinfo")
{
	//$gcodes = getGcode($registration_id,$conn);
	$gcodes = "";
	$utr_number = $_POST['utr_number'];
	$event = $_POST['event'];
	$year = 2022;
	$amountPaid = $_POST['amountPaid'];
	$tdsAmount = $_POST['tdsAmount'];
	if(empty($event)) { $eventError = "Plz Select Event Participated"; }
	elseif(empty($utr_number)) { $utrNameError = "Plz Enter UTR Number"; }
	elseif(empty($amountPaid)) { $amountPaidError = "Plz Enter Amount Paid"; }
	else {
		if($event=="iijstritiya22"){ $event_for="IIJS Tritiya 2022"; } 
		$mmx = "SELECT * FROM `utr_history` WHERE registration_id='$registration_id' AND utr_number='$utr_number' AND `show`='$event_for' AND `event_selected`='$event'";
		$mmxResult = $conn->query($mmx);
		$countUTR = $mmxResult->num_rows;
		if($countUTR > 0)
			{
			$mmRowx = $mmxResult->fetch_assoc();
			$id = $mmRowx['id'];
			
			$updateUTR = "UPDATE `utr_history` SET `modified_date`=NOW(),`utr_number`='$utr_number',`amountPaid`='$amountPaid', `tdsAmount`='$tdsAmount' WHERE `registration_id`='$registration_id' AND id='$id' AND `show`='$event_for' AND `event_selected`='$event'";
			$resultUTR = $conn->query($updateUTR);
			if($resultUTR) { $utrNameSuccess = "Saved Successfully"; }
			} else {
			$insertUTR = "INSERT INTO `utr_history`(`post_date`, `registration_id`,`gcode`, `utr_number`,`amountPaid`, `tdsAmount`, `show`,`event_selected`, `year`, `status`) VALUES (NOW(),'$registration_id','$gcodes','$utr_number','$amountPaid','$tdsAmount','$event_for','$event','$year','1')";
			$resultUTR = $conn->query($insertUTR);
			if($resultUTR) { $utrNameSuccess = "Saved Successfully"; }
		}
	}
}
?>
<?php
if(isset($_REQUEST["action"]) && $_REQUEST["action"]=="UPDATE")
{ 
	$utr_id = $_POST['utr_id'];
	$utr_date = $_POST['utr_date'];
	$utr_approved = $_POST['utr_approved'];
	
	for($i=0;$i<sizeof($utr_id);$i++) {
	if(in_array($utr_id[$i], $utr_approved))
		$utr_approve="Y";
	else
		$utr_approve="P";
		
	$sqll = "UPDATE `utr_history` SET utr_date='$utr_date[$i]',utr_approved='$utr_approve' WHERE id='$utr_id[$i]' AND `registration_id`='$registration_id'"; echo "<br/>";
	$mmx= $conn->query($sqll);
	}
	
	$registration_id = $_REQUEST['registration_id'];
	$roi_id = $_REQUEST['roi_id'];
	$event_name = $_REQUEST['event_name'];
	$application_status = $_REQUEST["application_status"];
	$payment_status = $_REQUEST["payment_status"];
	
	$company_name=getCompanyName($registration_id,$conn);
	$eventDescription=getExhRoi_desc($event_name,$conn);
	
	if($application_status=="N")
	{
		$application_dissapprove_reason=filter($_REQUEST['application_dissapprove_reason']);
	} else	{
		$application_dissapprove_reason="";
	}	
	if($payment_status=="N")
	{
		$payment_dissapprove_reason=filter($_REQUEST['payment_dissapprove_reason']);
	} else	{
		$payment_dissapprove_reason="";
	}	
	$conn->query("UPDATE `roi_space_registration` SET application_status='$application_status',application_dissapprove_reason='$application_dissapprove_reason',payment_status='$payment_status',payment_dissapprove_reason='$payment_dissapprove_reason' WHERE id='$roi_id' AND `registration_id`='$registration_id'");
	
	$message ='<table width="100%" bgcolor="#fff" style="margin:20px auto; border:2px solid #dddddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
		<tr>
		<td style="padding:30px;">
		<table width="100%" border="0" background="#fff" cellpadding="0" cellspacing="0">
			
			<tr>
				<td align="right"><a href="https://www.gjepc.org"><img src="https://registration.gjepc.org/images/logo.png" width="174" height="105"/></a></td>
				<td align="left" valign="top">
				<a href="https://gjepc.org/"><img src="https://registration.gjepc.org/images/IIJS_Tritiya_2022_logo.png" width="150" height="105" /></a></td>    	
			</tr>		
			<tr><td colspan="2" height="25px">&nbsp;</td></tr>    
			<tr><td colspan="2" height="1px" bgcolor="#333333"></td></tr>    
			<tr><td colspan="2" height="25px">&nbsp;</td></tr>    
			<tr>
				<td colspan="2" valign="top" style="font-size:13px;">
				<p><strong>Dear '.$company_name.',</strong> </p>
				</td>
			</tr>   
			
		<tr>
		<td colspan="2">
		<table width="100%" border="1" bordercolor="#CCCCCC" cellspacing="0" cellpadding="8" bgcolor="#f4f4f4" style="border-collapse:collapse; float:right;">
		  <tr valign="top">
			<td colspan="2" style="color:#14b3da;"><strong>Application Approval Summary</strong><br /></td>
		  </tr>
		  <tr valign="top">
			<td width="30%"><strong>Payment Approval Status </strong></td>
			<td width="21%">'.$payment_status.'</td>
		  </tr>
		  <tr valign="top">
			<td valign="top"><strong>Payment Dissapproval Reason</strong></td>
			<td valign="top">'.$payment_dissapprove_reason.'</td>
		  </tr>
		  <tr valign="top">
			<td width="30%"><strong>Application Approval Status </strong></td>
			<td width="21%">'.$application_status.'</td>
		  </tr>
		  <tr valign="top">
			<td valign="top"><strong>Application Dissapproval Reason</strong></td>
			<td valign="top">'.$application_dissapprove_reason.'</td>
		  </tr>
		</table>
		</td>
		</tr>  
		<tr><td colspan="2" height="25px">&nbsp;</td></tr>
		<tr></tr>
		<tr>
			<td colspan="2" style="line-height:20px;">
			<p>Kind Regards,</p>
			<p><strong>'.$eventDescription .' Web Team,</strong></p>
			</td>
		</tr>
		</table>
		</td>
		</tr>
		</table>';
			
		$to=getUserEmail($registration_id,$conn).',notification@gjepcindia.com';
		//$to="mukesh@kwebmaker.com";
		$subject = "$eventDescription Exhibitor Registration Approval Status/dated".date('Y-m-d').")";
		$headers  = 'MIME-Version: 1.0' . "\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n";	
		$headers .='From:'. $eventDescription.' <donotreply@gjepcindia.com>';
		mail($to, $subject, $message, $headers);
		header("Location:manage_roi_forms.php?action=view");
}	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ROI Details&gt; Exhibitor Registration &gt; Step-4</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>
<!--navigation-->
<script type="text/javascript" src="js/jqueryNew.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link rel="stylesheet" href="css/jquery-ui.css" />

<style>
.content_details1 table td {
    border: 1px solid #999999!important;
    padding-left: 10px;
}
</style>
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

<div id="main">
	<div class="content">
    
    <div class="content_head">ROI DETAIL
      <div style="float:right; padding-right:10px; font-size:12px;"><a href="manage_roi_forms.php?action=view">Back to Search</a></div>
    </div>
    	
<div class="clear"></div>
<div class="content_details1">
<form name="form1" action="roi_form_detail.php?gid=<?php echo $gid; ?>&registration_id=<?php echo $registration_id; ?>&action=update" method="post" onsubmit="return validation()"> 
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<div id="formCon">
<table width="100%" border="0"  class="detail_txt" >
	<tr class="orange1">
		<td colspan="11">Application Summary</td>
	</tr>
	<tr>
		<td>
			<strong>Contact Person Name:</strong>&nbsp; <?php echo $contact_person_name;?> <br />
			<strong>Contact Person Designation :</strong>&nbsp; <?php echo $contact_person_designation;?> <br />
			<strong>Contact Person Email :</strong>&nbsp; <?php echo $contact_person_email;?> <br />
			<strong>Contact Person Mobile no :</strong>&nbsp;<?php echo $contact_person_mobile_no;?> &nbsp;sqrt<br />
		</td>
		<td>
			<strong>Section :</strong>&nbsp; <?php echo $section;?> <br />
			<strong>Selected Area :</strong>&nbsp; <?php echo $selected_area;?> <br />
			<strong>Tot Space Cost Rate :</strong>&nbsp; <?php echo $tot_space_cost_rate;?> <br />
			<strong>Govt Service Tax :</strong>&nbsp; <?php echo $govt_service_tax;?> &nbsp;sqrt<br />
			<strong>Grand Total :</strong>&nbsp; <?php echo $grand_total;?> <br />
		</td>
	</tr>


<?php if($_SESSION['succ_msg']!=""){ ?>
<tr>
<td colspan="11"><?php echo $_SESSION['succ_msg']; ?></td>
</tr>
<?php } ?>
</tr>
<tr class="orange1"><td colspan="11">UTR Details</td></tr>
	<tr><td>
	<table border="1" cellspacing="0" cellpadding="5" style="margin-bottom:10px;" width="100%">
			<thead>
				<th align="center">Select</th>
				<th align="center">UTR No</th>
				<th align="center">Amount Paid</th>
				<th align="center">TDS Amount</th>
				<th align="center">Date</th>
				<th align="center">Approve / Disapprove</th>
				<th align="center">Partial</th>
				<th align="center">TDS</th>
				<th align="center">Delete</th>
			</thead>
			<tbody>
				<?php
				$utrExist = "SELECT id,utr_number,amountPaid,tdsAmount,utr_approved,utr_date,part_salesorder_status,IsDone FROM `utr_history` WHERE registration_id='$registration_id' AND event_selected='$event_name' order by `utr_date` asc";
				$existResult = $conn->query($utrExist);
				
				$totalPrice = 0;
				$CheckFirstEntry = 0;				

				while($printutr = $existResult->fetch_assoc())
				{
					$id = $printutr['id']; 
					$getUTR_no = $printutr['utr_number']; 
					$amountPaid = $printutr['amountPaid']; 
					$tdsAmount = $printutr['tdsAmount']; 
					$utr_approved = $printutr['utr_approved']; 
					$utr_date = $printutr['utr_date']; 
					$done = $printutr['IsDone']; 
				?>
				<tr>
				<td align="center"><input type="hidden" name="utr_id[]" value="<?php echo $id;?>"></td>
				<td align="center"><?php echo $getUTR_no;?></td>
				<td align="center"><?php echo $amountPaid;?></td>
				<td align="center"><?php echo $tdsAmount;?></td>
				<td align="center"><input type="date" name="utr_date[]" value="<?php echo $utr_date;?>" /></td>
				<td align="center">
                <input type="checkbox" name="utr_approved[]" value="<?php echo $id;?>" <?php if($utr_approved == "Y") echo 'checked="checked"';?>>
                </td>
				<!-------------------------- Start Partial --------------------------------------------->
				
					
					<?php if($printutr['part_salesorder_status'] =='' && $done==0) { ?>
					<td align="center" class="part" data-url="<?php echo $bp_number;?> <?php echo $sales_order_no;?> <?php echo $registration_id;?> <?php echo $getUTR_no;?>">Click Partial</td>
					<?php } else { ?>
					<td align="center" ><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
					<?php } ?>
					<!-------------------------- End Partial ------------------------------------------->
					<!-------------------------- Start TDS ------------------------------------------->
					<?php if($tdsAmount!="") { ?>
					<?php if($printutr['sap_sale_order_create_status'] == 0 && $sales_order_no!='') { ?>
					<td align="center" class="tds" data-url="<?php echo $bp_number;?> <?php echo $sales_order_no;?> <?php echo $registration_id;?> <?php echo $getUTR_no;?>">Click TDS</td>
					<?php } else { ?>
					<td align="center" ><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
					<?php } ?>
					<?php } else { ?>
					<td align="center">TDS BLANK</td>
					<?php } ?>
					<!-------------------------- End TDS ------------------------------------------->
					
				<?php //} ?>
				<td align="center"><a  href="roi_form_detail.php?action=del&utr_id=<?php echo $id?>&id=<?php echo $gid?>&registration_id=<?php echo $registration_id?>" onClick="return(window.confirm('Are you sure you want to delete?'));">Delete</a></td>
				</tr>
				<?php  $CheckFirstEntry++; ?>
				<?php }	?>
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
			<input type="radio" value="Y" name="payment_status" <?php if($payment_status=="Y"){?> checked <?php }?> >Approve
			<input type="radio" value="N" name="payment_status" <?php if($payment_status=="N"){?> checked <?php }?> >Disapprove
			<input type="radio" value="P" name="payment_status" <?php if($payment_status=="P"){?> checked <?php }?> >Pending
			<textarea name="payment_dissapprove_reason" id="payment_dissapprove_reason"><?php echo $application_dissapprove_reason;?></textarea>Reson
		</td>
	</tr>
	<tr>
		<td>Application Approval</td>
		<td>
			<input type="radio" value="Y" name="application_status" <?php if($application_status=="Y"){?> checked <?php }?> >Approve
			<input type="radio" value="N" name="application_status" <?php if($application_status=="N"){?> checked <?php }?>>Disapprove
			<input type="radio" value="P" name="application_status" <?php if($application_status=="P"){?> checked <?php }?>>Pending
			<textarea name="application_dissapprove_reason" id="application_dissapprove_reason"><?php echo $payment_dissapprove_reason;?></textarea>Reson
		</td>
	</tr>
</table>
</div>
<div style="padding-left:250px; margin-top:5px;">
	<input type="hidden" name="action" id="action" value="UPDATE" />
	<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />
	<input type="hidden" name="event_name" id="event_name" value="<?php echo $_REQUEST['event_name'];?>" />
	<input type="hidden" name="roi_id" id="roi_id" value="<?php echo $_REQUEST['id'];?>" />	
	<input type="submit" value="Update" class="input_submit"/>
</div>
</form>		

<form name="utr" method="POST" action="" id="form-horizontal">
		<input type="hidden" name="saveUTR" value="saveinfo">
		<table border="1" cellspacing="0" cellpadding="5" style="margin-bottom:10px;" width="100%">
			<th>ADD UTR DETAIL</th>
		</table>
		<table border="1" cellspacing="0" cellpadding="5" style="margin-bottom:10px;" width="100%">
			<thead>
				<th align="center">Event Participated: </th>
				<th align="center">UTR Number :</th>
				<th align="center">Amount Paid :</th>
				<th align="center">TDS Amount(If Any) :</th>
			</thead>
			<tr>
				<td>
				<select name="event" id="event" class="form-control">
					<option value="">-----Select Event----</option>
					<option value="iijstritiya22" selected>IIJS Tritiya 2022</option>
                </select>
				<?php if(isset($eventError)) { echo  '<span style="color: red;"/>'.$eventError.'</span>';} ?>
				</td>
				<td>
				<input type="text" class="form-control" id="utr_number" name="utr_number" value=""/>
				<?php if(isset($utrNameError)) { echo  '<span style="color: red;"/>'.$utrNameError.'</span>';} ?>
				</td>
				<td>
				<input type="number" class="form-control" id="amountPaid" name="amountPaid" value="" onkeypress="return isNumberKey(event)"/>
				<?php if(isset($amountPaidError)) { echo  '<span style="color: red;"/>'.$amountPaidError.'</span>';} ?>
				</td>
				<td>
				<input type="number" class="form-control" id="tdsAmount" name="tdsAmount" value=""/>
				<?php if(isset($utrNameSuccess)){ echo '<span style="color: green;"/>'.$utrNameSuccess.'</span>';} ?>
				</td>
			</tr>
			<tr><td><input type="submit" class="cta" id="submit" value="SAVE"/></td></tr>
	    </table>
	</form>
</div>


	
</div></div></div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
/* Partial Advance Payment */
$(".part").click(function() {
	var values = $(this).data('url').split(" ");
	var bpno=values[0];
	var so_number=values[1];
	var registration_id=values[2];
	var utr_no=values[3];
	
	if (confirm("Are you sure you want to Create Partial Advance Payment")) {
		$.ajax({
		url: "api_ro_partial_advance.php",
		method:"POST",
		data:{bpno:bpno,so_number:so_number,registration_id:registration_id,utr_no:utr_no},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			//console.log(data); return false;
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
