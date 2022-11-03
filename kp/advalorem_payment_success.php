<?php include('header_include.php'); ?>
<?php include('chk_login.php'); ?>

<?php include('include-new/header.php'); ?>

<section class="py-5">
	<div class="container-fluid inner_container">
	<div class="container">
    <ul class="row no-gutters justify-content-center page_subtabs mb-4" style="background: #9e9457">
    	<li class="col-auto"><a href="import_application.php" class="d-block ">Import Application</a></li>
        <li class="col-auto"><a href="export_application.php" class="d-block"> Export Application </a></li>
        <li class="col-auto"><a href="kimberley_process_search_applications.php" class="d-block">Application History </a></li>
      	<li class="col-auto"><a href="images/pdf/KP-User-Manual.pdf" target="_blank" class="d-block ">Online Manual</a></li>
    </ul>
    </div>
            
    <div class="col-lg-9 col-md-8 col-sm-12 order-md-1">
    <?php
	if(isset($_SESSION) && !empty($_SESSION)) 
	{
	//echo "<pre>"; print_r($_SESSION);  exit;
	$Response_Code = $_SESSION["response"]['Response_Code'];
	$Unique_Ref_Number = $_SESSION["response"]['Unique_Ref_Number'];
	$ReferenceNo = $_SESSION["response"]['ReferenceNo'];
	$Transaction_Date = date("Y-m-d H:i:s",strtotime($_SESSION["response"]['Transaction_Date']));
	$Transaction_Amount = $_SESSION["response"]['Transaction_Amount'];
	$Payment_Mode = $_SESSION["response"]['Payment_Mode'];
	$APPLICANT_ID = $_SESSION['MEMBER_ID'];

	$result = $conn ->query("update kp_payment_master set advol_RESPONSE_CODE='$Response_Code',advol_Unique_Ref_Number='$Unique_Ref_Number',advol_transaction_date='$Transaction_Date' where advol_ReferenceNo='$ReferenceNo' AND APPLICANT_ID='$APPLICANT_ID'");
	if($result){
		if($Response_Code=="E000" ){
			$_SESSION['succ_msg']="Your payment successfully done.";
		} else if($Response_Code=="E00329"){
			$_SESSION['succ_msg']="NEFT Challan Generated Successfully.";
		} else {
			$_SESSION['err_msg']="Sorry you could not make payment successfully.";
		}
    } else {
        $_SESSION['err_msg']="Something went wrong on server please contact Admin.";
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
        <?php /* if($Response_Code=="E000"){?>
       	 <tr><td><a href="print_acknowledgement.php"><b>Click Here</b> to print challan acknowledgement</a></td></tr>
        <?php } */ ?>
    </table>
    </div>
	<?php } else { ?>
	<p> Kindly Login And Check again your Payment Details</p>
	<?php } ?>	
    </div>   
    </section>
<?php include('include-new/footer.php');?>