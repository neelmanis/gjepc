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
$comm_num = $comm_status->num_rows;

$chln_status = $conn ->query("select status from challan_master where registration_id='$registration_id' and status=1");
$chln_num = $chln_status->num_rows;

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
?>

<?php
$sql="SELECT * FROM `information_master` WHERE 1 and registration_id='$registration_id'";
$result = $conn ->query($sql);
$rows	= $result->fetch_assoc();

$company_name  = strtoupper(filter($rows['company_name']));
$iec_no = str_replace(' ','',strtoupper(filter($rows['iec_no'])));
$iec_issue_date=$rows['iec_issue_date'];
$year_of_starting_bussiness = $rows['year_of_starting_bussiness'];
$member_type_id = filter($rows['member_type_id']);
?>

<section class="py-5">
	<div class="container inner_container">
    
    <h1 class="bold_font text-center mb-5"><img src="assets/images/gold_star.png" class="title_star d-block mx-auto">My Account - Apply RCMC Certificate</h1>
<div class="row">            
             
<div class="col-lg-auto order-lg-12 col-md-12 " data-sticky_parent><?php include 'include/regMenu.php'; ?></div>
    
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span style='color: green;'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<div class="col-lg col-md-12 ">
    
<div class="row">
<?php 
$sql1="SELECT * FROM `communication_address_master` WHERE 1 and registration_id='$registration_id'";
$result1 = $conn ->query($sql1);
while($rows1 = $result1->fetch_assoc())
{ 
?>
			<div class="form-group col-12"><p class="blue"><?php echo strtoupper(getaddresstype($rows1['type_of_address'],$conn));?></p></div>
			
			<?php if($rows1['name']!=""){?>
			<div class="form-group col-sm-6">			
				<label class="form-label">Person Name</label>
				<input type="text" class="form-control" disabled value="<?php echo strtoupper($rows1['name']);?>">
			</div>
			<?php } ?>
			
			<?php if($rows1['father_name']!=""){?>
			<div class="form-group col-sm-6">
				<label class="form-label">Father's Name</label>
				<input type="text" class="form-control" disabled value="<?php echo strtoupper($rows1['father_name']);?>">
			</div>
			<?php } ?>
			
			<?php if($rows1['address1']!=""){?> 
			<div class="form-group col-sm-6">			
				<label class="form-label">Address Line 1</label>
				<input type="text" class="form-control" disabled value="<?php echo strtoupper($rows1['address1']);?>">
			</div>
			<?php } ?>
            
			<?php if($rows1['address2']!=""){?>
			<div class="form-group col-sm-6">
				<label class="form-label">Address Line 2</label>
				<input type="text" class="form-control" disabled value="<?php echo strtoupper($rows1['address2']);?>">
			</div>
			<?php } ?>	
			
			<?php if($rows1['address3']!=""){ ?> 
			<div class="form-group col-sm-6">			
				<label class="form-label">Address Line 3</label>
				<input type="text" class="form-control" disabled value="<?php echo strtoupper($rows1['address3']);?>">
			</div>
			<?php } ?>
			
            <?php if($rows1['country']!=""){?> 
			<div class="form-group col-sm-6">			
				<label class="form-label">Country</label>
				<input type="text" class="form-control" disabled value="<?php echo strtoupper($rows1['country']);?>">
			</div>
			<?php } ?>
			
            <?php if($rows1['state']!=""){?> 
			<div class="form-group col-sm-6">			
				<label class="form-label">State</label>
				<input type="text" class="form-control" disabled value="<?php echo strtoupper(getFullStateName($rows1['state'],$conn));?>">
			</div>
			<?php } ?>
			
			<?php if($rows1['city']!=""){?> 
			<div class="form-group col-sm-6">
				<label class="form-label">City</label>
				<input type="text" class="form-control" disabled value="<?php echo strtoupper($rows1['city']);?>">
			</div>
			<?php } ?>
			
            <?php if($rows1['pincode']!=""){?> 
			<div class="form-group col-sm-6">			
				<label class="form-label">Pin Code</label>
				<input type="text" class="form-control" disabled value="<?php echo strtoupper($rows1['pincode']);?>">
			</div>
			<?php } ?>
			
			<?php if($rows1['landline_no1']!=""){?>
            <div class="form-group col-sm-6">
				<label class="form-label">Landline No. 1</label>
				<input type="text" class="form-control" disabled required value="<?php echo $rows1['landline_no1'];?>">
			</div>
			<?php } ?>
			
			<?php if($rows1['mobile_no']!=""){?> 
			<div class="form-group col-sm-6">
				<label class="form-label">Mobile No.</label>
				<input type="text" class="form-control" disabled value="<?php echo $rows1['mobile_no'];?>">
			</div>
			<?php } ?>
			
            <?php if($rows1['email_id']!=""){?> 
			<div class="form-group col-sm-6">			
				<label class="form-label">Email</label>
				<input type="text" class="form-control" disabled value="<?php echo $rows1['email_id'];?>">
			</div>
			<?php } ?>
            <?php } ?>
            
            </div>
                        
<p class="gold_clr"><strong>List of export products under which registration is required</strong></p>
<?php 
$export_query  = $conn ->query("select export_product_name from communication_details_master where registration_id='$registration_id'");
$export_result = $export_query->fetch_assoc();
$export_result = $export_result['export_product_name'];
?>
<?php
$export_result=explode(',',$export_result);
$j=1;
for($i=0;$i<count($export_result)-1;$i++){
?>
<div class="tablewidth_101">
<div class="detail_text212"><?php echo "<strong>".$j."</strong>-".$export_result[$i];?></div>
</div>
<div class="clear"></div>
<?php $j++;} ?>

<?php 
$rcmc_query = $conn ->query("select rcmc_certificate_expire_date from approval_master where registration_id='$registration_id'");
$rcmc_result = $rcmc_query->fetch_assoc();
$rcmc_certificate_expire_date=$rcmc_result['rcmc_certificate_expire_date'];
$curr_date=date("Y-m-d");
?>
<?php if($rcmc_certificate_expire_date=="0000-00-00" || $rcmc_certificate_expire_date<$curr_date){ ?>
<div class="padding_width" id="after_apply">
<div class="strong_text1 form-group"><strong>Apply for RCMC certificate</strong></div>
<div class="search_bt_icon">
<input type="submit" class="cta aply_for_rcmc  <?php echo $registration_id;?>"/>
</div>

</div>
<?php } else { ?>
<form action="final_submisson.php">
<div class="padding_width">
<strong>You have already applied for RCMC certificate</strong>
<?php 
/*............................Check if Approved.................................*/
$qfin_aprv = $conn ->query("SELECT final_submission FROM approval_master WHERE 1 and registration_id=$registration_id");
$rfin_aprv = $qfin_aprv->fetch_assoc();
$chk_fin_aprv = $rfin_aprv['final_submission'];
if($chk_fin_aprv!="Y"){
?>
<div class="form-group">
<input type="submit" class="cta mt-4" value="Final Submit"/>
</div>
<?php } ?>
</div>
</form>
<?php } ?>  
</div>

</div>
</div>
</section>
<?php include 'include-new/footer.php'; ?>

<script>
$(document).ready(function(){
$('.aply_for_rcmc').on('click',function(){
	clasvar = $(this).attr('class');
	x = clasvar.split(' ');
	registration_id = x[1];
		$.ajax({ 		
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=rcmc_certificate_apply&registration_id="+registration_id,
					dataType:'html',
					beforeSend: function(){
							$('#preloader').show();
							$('#status').show();
							},
					success: function(data){
							$('#preloader').hide();
							$('#status').hide();
							 $(location).attr('href','final_submisson.php');  
							}
		});
	});		
});
</script>