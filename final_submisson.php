<?php 
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
?>
<?php 
$registration_id = intval(filter($_SESSION['USERID']));
$info_status = $conn ->query("select status from information_master where registration_id='$registration_id' and status=1");
$info_num = $info_status->num_rows;

$comm_status = $conn ->query("select status from communication_details_master where registration_id='$registration_id' and status=1");
$comm_num	 = $comm_status->num_rows;

$chln_status = $conn ->query("select status from challan_master where registration_id='$registration_id' and status=1");
$chln_num	 = $chln_status->num_rows;

if($info_num==0 && $comm_num==0 && $chln_num==0){
$_SESSION['form_chk_msg']="Please first fill Information form";
$_SESSION['form_chk_msg1']="Please first fill Communication form";
$_SESSION['form_chk_msg2']="Please first fill challan form";
header('location:information_form.php');exit;
}

if($comm_num==0 && $chln_num==0){ 
	$_SESSION['form_chk_msg1']="Please first fill Communication form";
	$_SESSION['form_chk_msg2']="Please first fill Challan form";
	header('location:communication_form.php'); exit;
}
if($chln_num==0)
{
	$_SESSION['form_chk_msg2']="Please first fill Challan form";
	header('location:challan_form.php'); exit;
}

/*............................Check if Approved.................................*/
$qfin_aprv = $conn ->query("SELECT final_submission FROM approval_master WHERE 1 and registration_id=$registration_id");
$rfin_aprv = $qfin_aprv->fetch_assoc();
$no_of_rows= $qfin_aprv->num_rows;
$chk_fin_aprv = filter($rfin_aprv['final_submission']);
if($chk_fin_aprv=="Y"){ header('location:membership_rcmc.php'); exit; }
?>

<?php
if(isset($_POST['save']))
{
 $final_submission = filter($_POST['final_submission']);
 
 if($no_of_rows==0)
 {
	 $sql_query="insert into approval_master (registration_id,final_submission) values ('$registration_id','$final_submission')";
 } else {
 	$sql_query="update approval_master set final_submission='$final_submission' where registration_id='$registration_id'";
 }
$results =  $conn ->query($sql_query);
if($results){
  $_SESSION['succ_msg']="You have successfully submitted.";
  header('location:membership_rcmc.php'); 
} else { die ($conn->error); }
}
?>
<section class="py-5">
	<div class="container inner_container">
    	
        <h1 class="bold_font text-center mb-5"><img src="assets/images/gold_star.png" class="title_star d-block mx-auto"> My Account - Membership & RCMC - Apply RCMC Certificate</h1>
    
		<div class="row">        	
           
            
            <div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
			</div>
    
    		<div class="col-lg col-md-12 ">
				<p class="gold_clr mb-4 pb-2" style="border-bottom:1px dashed #a89c5d;"><strong> Account Information </strong> </p>
				
				

	<div class="col-md-8 col-sm-8 col-xs-12 speakerSelector">

<div class="sub_head">Final Submission</div>
<hr style="border-top:1px solid #502f43">
		
<?php
$slx = $conn ->query("select final_submission from approval_master where registration_id='$registration_id'");
$result = $slx->fetch_assoc();
?>
<form action="" method="POST">
<input type="checkbox" name="final_submission" id="final_submission" value="Y" <?php if($result['final_submission']=="Y"){?> checked="checked"<?php }?>/>
<p class="ab_description">I solemnly  declare and affirm that the document submitted are true to my knowledge and also understand that the documents once submitted will not be changed.</p>
<input type="submit" value="Submit" name="save" id="save" />
</form>	
<hr style="border-top:1px solid #502f43">				
  </div>    
  </div>    
  </div>    
  </div>    
</section>
<?php include 'include-new/footer.php'; ?>