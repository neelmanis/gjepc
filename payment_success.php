<?php
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
?>
<?php 
$registration_id = intval(filter($_SESSION['USERID'])); 
$info_status=$conn ->query("select status from information_master where registration_id='$registration_id' and status=1");
$info_num=$info_status->num_rows;

$comm_status=$conn ->query("select status from communication_details_master where registration_id='$registration_id' and status=1");
$comm_num=$comm_status->num_rows;

$chln_status=$conn ->query("select status from challan_master where registration_id='$registration_id' and status=1");
$chln_num=$chln_status->num_rows;

if($info_num==0 && $comm_num==0 && $chln_num==0){
$_SESSION['form_chk_msg']="Please first fill Information form";
$_SESSION['form_chk_msg1']="Please first fill Communication form";
$_SESSION['form_chk_msg2']="Please first fill challan form";
header('location:information_form.php');exit;
}

if($comm_num==0 && $chln_num==0)
{ 
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	$_SESSION['form_chk_msg2']="Please first fill Challan form";
	header('location:communication_form.php');exit;
}
if($chln_num==0)
{
	$_SESSION['form_chk_msg2']="Please first fill Challan form";
	header('location:challan_form.php');exit;
}
// current challan yr calculation
    $cur_year = (int)date('y');
	$curyear  = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $curyear-1;
	 $cur_fin_yr1= $cur_year-1;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr= ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }
    else {
     $cur_fin_yr = $curyear;
 	 $cur_fin_yr1= $cur_year;
	 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
	 $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
    }
?>

<section>
	<div class="container inner_container">
		<div class="row mb">	
    
    <div class="col-12">
        <div class="innerpg_title">
            <h1>My Account - Payment Success</h1>
        </div>
    </div>

	<div class="col-lg-3 col-md-4 order-md-12" data-sticky_parent>
	<?php include 'include/regMenu.php'; ?>
	</div>
            
    <div class="col-lg-9 col-md-8 col-sm-12 order-md-1">
    <?php 
	//echo "<pre>"; print_r($_POST); 
	$post_date=date('Y-m-d');
	$Response_Code=$_POST['Response_Code'];
	$Unique_Ref_Number=$_POST['Unique_Ref_Number'];
	$ReferenceNo=$_POST['ReferenceNo'];
	$Transaction_Date=$_POST['Transaction_Date'];
	$Transaction_Amount=$_POST['Transaction_Amount'];
	
	$resultx = $conn ->query("update challan_payment_log set Response_Code='$Response_Code',Unique_Ref_Number='$Unique_Ref_Number' where registration_id='$registration_id' and ReferenceNo='$ReferenceNo'");
	if($Response_Code=="E000" && $_SESSION['ReferenceNo']=="$ReferenceNo")
	{
		$result1 = $conn ->query("update challan_master set Response_Code='$Response_Code',Unique_Ref_Number='$Unique_Ref_Number',ReferenceNo='$ReferenceNo',Transaction_Date='$post_date' where registration_id='$registration_id' and challan_financial_year='$cur_fin_yr'");
		
		$result2 = $conn ->query("update approval_master set payment_approve='Y',apply_membership_renewal='Y',membership_type='R',renewal_download_status='N',membership_expiry_status='N',membership_renewal_dt='$post_date',post_date='$post_date' where registration_id='$registration_id'");
		
		$_SESSION['succ_msg']="Your payment successfully done.";

	$html = "";
    $html .='<table cellpadding="10" width="100%" style="margin: 0px auto; font-family: Roboto; background-color: #fff; padding: 15px; border-collapse: collapse; border: 1px solid #000;">
				<tr>
		        	<td colspan="2" style="background-color: #a89c5d; padding: 3px;"></td>
		      	</tr>
				<tr>
	            	<td colspan="2" align="left"><img id="ri" src="https://registration.gjepc.org/images/logo.png"></td>                        
		      	</tr>
		      
			  	<tr>
		  			<td colspan="2">
		  			    <p>Dear  <strong>Member</strong>, </p>
		  			    <p>Thank you so much  for  renewing your  GJEPC membership for the year 2022-23 , you are requested to please fill and update your form by clicking link <a href="https://gjepc.org/dgft-form.php">https://gjepc.org/dgft-form.php</a> and apply for RCMC on DGFT portal <a href="https://www.dgft.gov.in">https://www.dgft.gov.in</a>  and  fill-up  all the details.</p>
		  			</td>			  
			  	</tr>  	  									
			</table>';
	$message = $html;
	
	$to_email_id = getUserEmail($registration_id,$conn);
    $cc = "";
	$subject = "Apply for RCMC on DGFT"; 
	send_mail($to_email_id, $subject, $message,$cc);

    $mobile =  getAuthPersonMobile($registration_id,$conn);
	$fy = "2022-23";
	$link = "https%3A%2F%2Fwww.dgft.gov.in";
	$dgft = "Your membership for $fy renewed%2C apply for RCMC on DGFT portal $link in fill-up details as per PDF.";
	send_sms($dgft,$mobile);

	} else {
	$resulty = $conn ->query("update challan_master set Response_Code='$Response_Code',Unique_Ref_Number='$Unique_Ref_Number',ReferenceNo='$ReferenceNo' where registration_id='$registration_id' and challan_financial_year='$cur_fin_yr'");
		if($Response_Code=="E00329")
			$_SESSION['succ_msg']="NEFT Challan Generated Successfully.";
		else
			$_SESSION['err_msg']="Sorry you could not make payment successfully.";
	}
	?>
    <?php 
    if($_SESSION['succ_msg']!=""){
    echo "<span style='color: green;'>".$_SESSION['succ_msg']."</span>";
    	$_SESSION['succ_msg']="";
    }
	if($_SESSION['err_msg']!=""){
	echo "<div class='alert alert-warning' role='alert' style='color: red;'>".$_SESSION['err_msg']."</div>";
	$_SESSION['err_msg']="";
	}
    ?>
    <table>
        <tr><td><b>Transaction ID :&nbsp;&nbsp;</b> <?php echo $Unique_Ref_Number;?></td></tr>
        <tr><td><b>Reference No:&nbsp;&nbsp;</b><?php echo $ReferenceNo;?></td></tr>
        <tr><td><b>Transaction Amount:&nbsp;&nbsp;</b><?php echo $Transaction_Amount;?></td></tr>
        <tr><td><b>Transaction Date:&nbsp;&nbsp;</b><?php echo $Transaction_Date;?></td></tr>
        <tr><td>&nbsp;</td></tr>
        <?php if($Response_Code=="E000"){?>
       	 <tr><td><a href="print_acknowledgement.php"><b>Click Here</b> to print challan acknowledgment</a></td></tr>
       	 <tr><td><a href="print_acknowledgement.php"><b>Click Here</b> to print Provisional Certificate</a></td></tr>
        <?php }?>
    </table>
    </div> 
    </div>   
    </div>  
    </section>
<?php include 'include-new/footer.php'; ?>