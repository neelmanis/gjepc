<?php
include 'include-new/header.php'; 
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; } 
include 'db.inc.php';
include 'functions.php';
$registration_id = intval(filter($_SESSION['USERID'])); 
$bp_number = getBPNO($registration_id,$conn);
$pan_number = getPanNo($registration_id,$conn);
$company_name = getNameCompany($registration_id,$conn);
/* ===================KYC SSO API START=====================*/
$kycUrl = getKycUrl($bp_number,$pan_number,$company_name);
/* ===================KYC SSO API END=========================*/
/*============================================================*/
/* ===================KYC STATUS API START===================*/
$apiurl="http://api.mykycbank.com/service.svc/44402aeb2e5c4eef8a7100f048b97d84/BPID/".$bp_number;
$getResponse = file_get_contents($apiurl);
$getResult = json_decode($getResponse,true);
$apiResponse = json_decode($getResult,true);
$KycProfileId = $apiResponse['KycProfileId'];
$kycStatus = $apiResponse['status'];
$kycMessage = $apiResponse['Message'];
//print_r($apiResponse);
/* =====================KYC STATUS API END=====================*/
?>

<?php 
$info_status = $conn ->query("select status from information_master where registration_id='$registration_id' and status=1");
$info_num	=  $info_status->num_rows;

$comm_status = $conn ->query("select status from communication_details_master where registration_id='$registration_id' and status=1");
$comm_num	 = $comm_status->num_rows;

$chln_status = $conn ->query("select status from challan_master where registration_id='$registration_id' and status=1");
$chln_num	 = $chln_status->num_rows;

if($info_num==0 && $comm_num==0 && $chln_num==0){
$_SESSION['form_chk_msg']="Please first fill Information form";
$_SESSION['form_chk_msg1']="Please first fill Communication form";
$_SESSION['form_chk_msg2']="Please first fill challan form";
header('location:information_form.php');
}

if($comm_num==0 && $chln_num==0)
{ 
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	$_SESSION['form_chk_msg2']="Please first fill Challan form";
	header('location:communication_form.php');
}

if($chln_num==0)
{	
	$_SESSION['form_chk_msg2']="Please first fill Challan form";
	header('location:challan_form.php');
}
?>
<section class="py-5">	
<div class="container inner_container">

	<h1 class="bold_font text-center mb-5"><img src="assets/images/gold_star.png" class="title_star d-block mx-auto">Print Application/Challan forms </h1>
    
		<div class="row">        
        

	<div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
		<?php include 'include/regMenu.php'; ?>
	</div>

	<div class="col-lg col-md-12 ">    	
			<p>Please take a print of the below mentioned forms and courier your mandatory document to the council within 15 days. The cheque should be drawn in the name of "The Gem and Jewellery Export Promotion Council"</p>

		<div class="col-md-12 form-block minibuffer p-4 mb-4" style="background:#f2f2f2;">
			<div class="sub_head minibuffer blue mb-3"><i class="fa fa-users" aria-hidden="true"></i> For New Membership</div>
			<div class="row">
				<div class="col-6"><label class="form-label" for="pamp">Application form for Associate Membership :</label></div>
				<div class="col-6"> <a href="rcmc/communication_form.php" target="_blank"/><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a></div>
			</div>
			<?php
			$sqlxx = $conn ->query("SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' AND issue_membership_certificate_expire_status='Y'");
			$result = $sqlxx->fetch_assoc();
			$num = $sqlxx->num_rows;
			if($num==0){ ?>
			<div class="row">
				<div class="col-6"><label class="form-label" for="pamp">Print - Challan Form :</label></div>
				<div class="col-6"><a href="rcmc/challan_form.php" target="_blank"/><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a></div>
			</div>
			<?php } ?>
			<div class="row">
				<div class="col-6"><label class="form-label" for="pss">Print - Signature Slip :</label></div>
				<div class="col-6"><a href="rcmc/signature_slip.php" target="_blank"/><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a></div>
			</div>
			<?php 
			$eligible_for_renewal = eligible_for_renewal($registration_id,$conn);
			if($eligible_for_renewal !="N"){
			?>
			<div class="row">
				<div class="col-6"><label class="form-label" for="pif">Print - Application for (RCMC) Form :</label></div>
				<div class="col-6"><a href="rcmc/information_form.php" target="_blank"/><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a></div>
			</div>
			<?php } ?>
		</div>
		
		<?php /* Issue RCMC Certificate Start */
		$queryrcmc = $conn ->query("SELECT * FROM information_master where registration_id='$registration_id'");
		$default= $queryrcmc->fetch_assoc();
		$member_type_id = $default['member_type_id'];	

		$getrcmc = $conn ->query("select rcmc_certificate_issue_status,merchant_certificate_no,manufacturer_certificate_no from  approval_master where registration_id='$registration_id'");
		$result= $getrcmc->fetch_assoc();
		if($member_type_id==5){
		$certificate_no = strtoupper($result['merchant_certificate_no']);
		} else {
		$certificate_no = strtoupper($result['manufacturer_certificate_no']);
		}		
		//echo $certificate_no;
		$getLastYear = substr(strrchr($certificate_no, '/'), 1);
		$strings = explode('-',$getLastYear);
		$strtYear = $strings[0];
		$lastYear = $strings[1];
		
		$currentYear = date("Y");		
		$date_range = range($strtYear, $lastYear);//get year range
		//print_r($date_range);
		if(in_array($currentYear, $date_range)) { 
			if($result['rcmc_certificate_issue_status']=="Y"){ ?>
			<!--<div class="col-md-12 form-block minibuffer p-4 mb-4">			
			<div class="sub_head minibuffer blue">Registration cum Membership Certificate</div>
			<div class="row">
			<div class="col-6"><label class="form-label" for="pif">Print Registration cum membership certificate (RCMC) :</label></div>
			<div class="col-6"><a href="rcmc/print_certificate.php?page=50" target="_blank"><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a> </div>
			</div>
			</div>-->
		<?php } 
		} else {		
		} /* Issue RCMC Certificate Over */
		?>
		
		<?php
		$sqlx = $conn ->query("SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' AND issue_membership_certificate_expire_status='Y'");
		$result = $sqlx->fetch_assoc();
		$countx =  $sqlx->num_rows;

		//if($countx >0){ echo 'ok'; } else { echo 'not ok'; }
		if($result['apply_membership_renewal']=="Y"){ ?>

		<div class="col-md-12 form-block minibuffer p-4 mb-4" style="background:#f2f2f2;">			
			<div class="sub_head minibuffer blue mb-3"><i class="fa fa-repeat" aria-hidden="true"></i> For Renewal</div>
			<div class="row">
				<div class="col-6"><label class="form-label" for="pmc">Print Challan Form (3 Copies) :</label></div>
				<div class="col-6"> <a href="rcmc/challan_form.php" target="_blank"/><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a> </div>
			</div>			
		</div>
		<?php } ?>

		<?php if($result['membership_certificate_type']!=""){ ?>
		<?php if($result['admin_issue_membership_certificate']=="Y"){ ?>
		<div class="col-md-12 form-block minibuffer p-4 mb-4" style="background:#f2f2f2;">			
			<p class="sub_head minibuffer blue"><i class="fa fa-certificate" aria-hidden="true"></i> For Membership Certificate</p>
			<?php /*if(empty($kycStatus) || $kycStatus=="" || $kycStatus !='1'){ ?>
			<div class="row">
				<div class="col-6"><?php  echo $kycMessage;?></div>
				<div class="col-6"> <a href="<?php echo $kycUrl;?>" target="_blank" class="cta fade_anim"/>Click Here</a>
				</div>
			</div>
			<?php } else { */ ?>
			<div class="row">
				<div class="col-6"><label class="form-label" for="pmc">Print Membership Certificate :</label></div>
				<div class="col-6"> <a href="rcmc/membership.php" target="_blank"/><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a> </div>
			</div>
			<?php //} ?>
			<div class="row">
				<div class="col-6"><label class="form-label" for="print_invoice">Print Invoice :</label></div>
				<div class="col-6"> <a href="invoice.php" target="_blank"/><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a> </div>
				<div class="col-6"><label class="form-label" for="print_invoice">Print QR Based Invoice :</label></div>
				<div class="col-6"> <a href="qr-invoice.php" target="_blank"/><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a> </div>
			</div>
		</div>
		<?php } ?>
		<?php } ?>
		
		<?php 
		$eligible_for_renewal = eligible_for_renewal($registration_id,$conn);
		if($eligible_for_renewal != "N")
		{ ?>
		<!--<div class="col-md-12 form-block minibuffer">			
			<div class="sub_head minibuffer"><i class="fa fa-certificate" aria-hidden="true"></i> For old Membership Certificate</div>
			<div class="form-group row">
				<div class="col-6"><label class="form-label" for="pmc">Print Membership Certificate :</label></div>
				<div class="col-6"> <a href="rcmc/membership-FY2019-20.php" target="_blank"/><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a> </div>
			</div>
		</div>-->
		<?php }	else { echo ''; } ?>

		<?php /*if(empty($kycStatus) || $kycStatus=="" || $kycStatus !='1'){ ?>

		 	<div id="myModal" class="modal fade" role="dialog" style="background: rgba(0, 0, 0, 0.52)">
				<div class="modal-dialog">      
			        <div class="clear"></div>        
			        <div class="modal-body p-4" style="background:#fff;"> 
			        
			            <p>Dear <?php  echo  $company_name; ?></p>
			            <p><?php  echo $kycMessage;?></p>
			            <a href="<?php echo $kycUrl;?>" target="_blank" class="blue d-block">Click Here</a>
			            <p>Complete your KYC to download the member certificate</p>
			            <br>
			          
			            <div class="d-flex justify-content-start">
			            	<a href="<?php echo $kycUrl;?>" target="_blank" class="cta">Ok</a>
			            </div>           
			      	</div>
			  	</div>
			</div>
		
		<?php } */ ?>
		<?php
		$chln_statusCheck = $conn ->query("select * from challan_master where registration_id='$registration_id' and challan_financial_year='2022' order by id desc limit 0,1");
		$numeric = $chln_statusCheck->num_rows;
		
		$get_challan =  $chln_statusCheck->fetch_assoc();
		$response_Code = $get_challan['Response_Code'];
		if($numeric>0)
		{
		//echo	$result['admin_issue_membership_certificate'];
	//	if($result['admin_issue_membership_certificate']=="N")	{
		if($response_Code=="E000"){
			if($eligible_for_renewal == "N"){
		?>
		<div class="col-md-12 form-block minibuffer p-4 mb-4" style="background:#f2f2f2;">			
			<p class="sub_head minibuffer blue"><i class="fa fa-certificate" aria-hidden="true"></i> For PROVISIONAL CERTIFICATE</p>
			<div class="row">
				<div class="col-6"><label class="form-label" for="pmc">Print Provisional Certificate :</label></div>
				<div class="col-6"> <a href="provisional-certificate.php" target="_blank"/><button><i class="fa fa-print" aria-hidden="true"></i> Print</button></a> </div>
			</div>			
		</div>
		<?php
			}
	//	}
		} 
		}
		?>		
	</div>    
    </div>    
 </div>
</section>
<?php include 'include-new/footer.php'; ?>

<?php 
 if(empty($kycStatus) || $kycStatus=="" || $kycStatus !='1'){ ?>
	 <script type="text/javascript">
			$(window).on('load',function(){
			 	var overlay = $(".ui-widget-overlay");
		baseBackground = overlay.css("background");
		baseOpacity = overlay.css("opacity");
		overlay.css("background", "#000").css("opacity", "1");
		        $('#myModal').modal({
		        	backdrop: 'static',
		            keyboard: false,

		        });
		    });
	</script>
<?php  } ?>